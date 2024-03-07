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

// Mendapatkan daftar foto dari database, atau hasil pencarian jika ada
$query = "SELECT photos.*, users.name AS user_name FROM photos
          LEFT JOIN users ON photos.user_id = users.user_id
          LEFT JOIN albums ON photos.album_id = albums.album_id
          WHERE albums.access_level = 'public'";

// Jika ada permintaan pencarian, sesuaikan kueri untuk mencocokkan hasil pencarian
if(isset($_GET['query']) && !empty($_GET['query'])){
    $search_query = $_GET['query'];
    $query .= " AND (photos.title LIKE '%$search_query%' OR photos.description LIKE '%$search_query%')";
}

// Tambahkan pengurutan secara menurun berdasarkan ID foto
$query .= " ORDER BY photos.photo_id DESC";

$result = mysqli_query($conn, $query);

// Pagination
$limit = 8;
$total_records = mysqli_num_rows($result);
$total_pages = ceil($total_records / $limit);
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($current_page - 1) * $limit;

$query .= " LIMIT $start, $limit";

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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
    <!-- Add jQuery (Lightbox2 requires jQuery) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Add Lightbox2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <link rel="stylesheet" href="./css/fontawesome.min.css">
    <link rel="stylesheet" href="./css/all.min.css">
</head>
<body class="bg-gray-100">

    <?php  include 'navbar_admin.php';  ?>

    <!-- Form for search -->
    <div class="search-container flex justify-center mt-4 mb-8">
        <form action="admin_dashboard.php" method="GET" class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
            <input type="text" placeholder="Cari foto..." name="query" class="py-2 px-4 focus:outline-none" style="width: 300px;">
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 hover:bg-blue-600 transition-colors duration-300"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
    </div>

    <!-- Galeri Foto -->
    <div class="container mx-auto p-8 ">
        <h2 class="text-2xl font-bold mb-4">Gallery</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        <?php foreach ($photos as $photo) : ?>
            <div class="overflow-hidden rounded-lg shadow-md flex flex-col transform hover:scale-105 transition duration-300">
                <a href="uploads/<?php echo $photo['image_path']; ?>" data-lightbox="gallery" data-title="<?php echo $photo['title']; ?>">
                    <img class="w-full h-40 object-cover" src="uploads/<?php echo $photo['image_path']; ?>" alt="<?php echo $photo['title']; ?>">
                </a>
                <div class="p-4 flex-grow bg-white">
                    <h4 class="text-xl font-bold mb-2"><?php echo $photo['title']; ?></h4>
                    <p class="text-gray-600 mb-4"><?php echo $photo['description']; ?></p>
                    <p class="  font-semibold mb-2"> <?php echo $photo['user_name']; ?></p>
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

    <!-- Pagination -->
     <!-- Navigasi pagination -->
     <div class="pagination mt-4 mb-8">
    <ul class="flex justify-center items-center">
        <!-- Tombol Halaman Sebelumnya -->
        <?php if ($current_page > 1) : ?>
            <li class="mr-2">
                <a href="?page=<?php echo $current_page - 1; ?>&query=<?php echo isset($_GET['query']) ? $_GET['query'] : ''; ?>" class="text-white px-4 py-2 rounded-md bg-gradient-to-r from-blue-400 to-blue-600 hover:from-blue-600 hover:to-blue-800 transition-colors duration-300">Previous</a>
            </li>
        <?php endif; ?>

        <!-- Tautan ke setiap halaman -->
        <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
            <li class="mx-1">
                <a href="?page=<?php echo $i; ?>&query=<?php echo isset($_GET['query']) ? $_GET['query'] : ''; ?>" class="<?php echo ($current_page == $i) ? 'font-bold text-blue-600' : 'text-gray-600 hover:text-blue-600'; ?> px-4 py-2 rounded-md hover:bg-blue-100 transition-colors duration-300"><?php echo $i; ?></a>
            </li>
        <?php endfor; ?>

        <!-- Tombol Halaman Berikutnya -->
        <?php if ($current_page < $total_pages) : ?>
            <li class="ml-2">
                <a href="?page=<?php echo $current_page + 1; ?>&query=<?php echo isset($_GET['query']) ? $_GET['query'] : ''; ?>" class="text-white px-4 py-2 rounded-md bg-gradient-to-r from-blue-400 to-blue-600 hover:from-blue-600 hover:to-blue-800 transition-colors duration-300">Next</a>
            </li>
        <?php endif; ?>
    </ul>
</div>
  
</body>
</html>
