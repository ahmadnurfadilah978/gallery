<?php
require_once('koneksi.php');
session_start();
$user_id = $_SESSION['userid'];
// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

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
    <!-- Add Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Add Lightbox2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
    <!-- Add jQuery (Lightbox2 requires jQuery) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Add Lightbox2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <link rel="stylesheet" href="./css/fontawesome.min.css">
    <link rel="stylesheet" href="./css/all.min.css">
    <link rel="stylesheet" href="css/styles_dash.css">
</head>

<body>
    <div class="navbar">
        <h2>Selamat Datang, <?php echo $_SESSION['username']; ?>!</h2>
        <a href="dashboard.php">Home</a>
        <a href="profile.php">Profile</a>
        <a href="albums_user.php">Album</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="gallery grid mx-auto p-4">
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
                                <a href="edit.php?id=<?php echo $photo['photo_id']; ?>" class="text-blue-500 hover:text-blue-700 mr-2" ><i class="fa-regular fa-pen-to-square"></i></a>
                                <a href="delete.php?id=<?php echo $photo['photo_id']; ?>" onclick="return confirm('Are you sure you want to delete this photo?');" class="text-red-500 hover:text-red-700"><i class="fa-sharp fa-solid fa-trash"></i></a>
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
                            <a href="comments.php?photo_id=<?php echo $photo['photo_id']; ?>" class="text-blue-500 hover:underline mr-2"><i class="fa-regular fa-comment"></i><?php echo $total_comments; ?></a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="center-box">
        <div class="upload-box">
            <a href="upload.php">Unggah Foto</a>
        </div>
    </div>

    <div class="footer">
        <p>© 2024 My Website</p>
    </div>
</body>
</html>
