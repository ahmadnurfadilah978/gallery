<?php
require_once('koneksi.php');
session_start();

// Periksa apakah pengguna sudah login dan memiliki akses admin
if (!isset($_SESSION['username']) || $_SESSION['access_level'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Mendapatkan ID pengguna yang sedang login
$user_id = $_SESSION['userid'];

// Mendapatkan daftar foto dari database
$query = "SELECT photos.*, users.name AS user_name FROM photos
          LEFT JOIN users ON photos.user_id = users.user_id";
$result = mysqli_query($conn, $query);

$photos = [];
while ($row = mysqli_fetch_assoc($result)) {
    $photos[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Tambahkan link CSS di sini -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <link rel="stylesheet" href="./css/fontawesome.min.css">
    <link rel="stylesheet" href="./css/all.min.css">
</head>
<body>
    <!-- Navbar -->
    <div class="navbar bg-gray-800 text-white p-4">
        <h2 class="text-lg font-bold">Admin Dashboard</h2>
        <div class="flex items-center">
            <span class="mr-4">Welcome, <?php echo $_SESSION['username']; ?>!</span>
            <a href="admin_dashboard.php" class="hover:text-gray-400">Home</a>
            <a href="data_pengguna.php" class="hover:text-gray-400 ml-4">Users</a>
            <a href="albums.php" class="hover:text-gray-400 ml-4">Albums</a>
            <a href="fotoadmin.php" class="hover:text-gray-400 ml-4">Foto</a>
            <a href="login.php" class="bg-indigo-500 text-white px-4 py-2 rounded-md hover:bg-indigo-600 ml-4">Logout</a>
        </div>
    </div>

    <!-- Galeri Foto -->
    <div class="container mx-auto p-8">
        <h2 class="text-2xl font-bold mb-4">Gallery</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        <?php foreach ($photos as $photo) : ?>
            <div class="overflow-hidden rounded-lg shadow-md flex flex-col transform hover:scale-105 transition duration-300">
                <a href="uploads/<?php echo $photo['image_path']; ?>" data-lightbox="gallery" data-title="<?php echo $photo['title']; ?>">
                    <img class="w-full h-40 object-cover mb-2" src="uploads/<?php echo $photo['image_path']; ?>" alt="<?php echo $photo['title']; ?>">
                </a>
                <div class="p-4 flex-grow">
                    <p class="text-xl font-semibold mb-3"> <?php echo $photo['user_name']; ?></p>
                    <h4 class="text-black font-semibold mb-1"><?php echo $photo['title']; ?></h4>
                    <p class="text-gray-600 mb-4"><?php echo $photo['description']; ?></p>
                    <div class="flex flex-col sm:flex-row justify-between items-center">
                        <div class="flex justify-between w-full sm:w-auto mb-2 sm:mb-0">
                            <?php if ($photo['user_id'] === $user_id) : ?>
                                <!-- Tampilkan tombol edit dan hapus hanya jika user_id pengguna sama dengan user_id yang mengunggah foto -->
                                <a href="edit_upload_admin.php?id=<?php echo $photo['photo_id']; ?>" class="text-blue-500 hover:text-blue-700 mr-2"><i class="fa-regular fa-pen-to-square"></i></a>
                                <a href="delete_upload_admin.php?id=<?php echo $photo['photo_id']; ?>" onclick="return confirm('Are you sure you want to delete this photo?');" class="text-red-500 hover:text-red-700"><i class="fa-sharp fa-solid fa-trash"></i></a>
                            <?php endif; ?>
                        </div>
                        <div class="flex justify-between w-full sm:w-auto">
                            <?php
                                // Query untuk mengecek apakah pengguna telah menyukai foto ini
                                $check_like_query = "SELECT * FROM likes WHERE photo_id = {$photo['photo_id']} AND user_id = $user_id";
                                $check_like_result = mysqli_query($conn, $check_like_query);
                                $liked = mysqli_num_rows($check_like_result) > 0;

                                // Menentukan kelas ikon hati berdasarkan apakah pengguna menyukai foto ini atau tidak
                                $heart_icon_class = $liked ? "fa-solid fa-heart text-red-500" : "fa-regular fa-heart text-gray-500";
                            ?>
                            <a href="likes.php?fotoid=<?=$photo['photo_id']?>" class="text-blue-500 hover:underline mr-2" ><i class="<?php echo $heart_icon_class; ?>"></i></a>
                            <?php
                                $count_query = "SELECT COUNT(*) AS total_likes FROM likes WHERE photo_id = {$photo['photo_id']}";
                                $count_result = mysqli_query($conn, $count_query);
                                $count_row = mysqli_fetch_assoc($count_result);
                                $total_likes = $count_row['total_likes'];
                            ?>
                            <a href="likes.php?fotoid=<?=$photo['photo_id']?>" class="text-blue-500 hover:underline mr-2" ><?php echo $total_likes; ?></a>
                            <?php
                                $comment_count_query = "SELECT COUNT(*) AS total_comments FROM comments WHERE photo_id = {$photo['photo_id']}";
                                $comment_count_result = mysqli_query($conn, $comment_count_query);
                                $comment_count_row = mysqli_fetch_assoc($comment_count_result);
                                $total_comments = $comment_count_row['total_comments'];
                            ?>
                            <a href="comments_admin.php?photo_id=<?php echo $photo['photo_id']; ?>" class="text-blue-500 hover:underline mr-2"><i class="fa-regular fa-comment"></i><?php echo $total_comments; ?></a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
