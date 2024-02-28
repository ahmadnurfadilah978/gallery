<?php
include 'koneksi.php';

// Tentukan jumlah data per halaman
$limit = 8;

// Tentukan halaman saat ini
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($current_page - 1) * $limit;

// Inisialisasi variabel query
$query = "";

// Periksa apakah parameter query telah diberikan
if(isset($_GET['query'])) {
    // Sanitasi inputan pencarian
    $search = mysqli_real_escape_string($conn, $_GET['query']);
    
    // Query untuk mencari foto berdasarkan judul atau deskripsi yang cocok dengan input pencarian
    $query = "SELECT photos.*, users.name AS user_name, COUNT(likes.like_id) AS total_likes, COUNT(comments.comment_id) AS total_comments
              FROM photos
              LEFT JOIN users ON photos.user_id = users.user_id
              LEFT JOIN likes ON photos.photo_id = likes.photo_id
              LEFT JOIN comments ON photos.photo_id = comments.photo_id
              WHERE photos.title LIKE '%$search%' OR photos.description LIKE '%$search%'
              GROUP BY photos.photo_id
              ORDER BY photos.photo_id DESC
              LIMIT $start, $limit";
} else {
    // Jika parameter query tidak diberikan, ambil semua foto tanpa pencarian
    $query = "SELECT photos.*, users.name AS user_name, COUNT(likes.like_id) AS total_likes, COUNT(comments.comment_id) AS total_comments
              FROM photos
              LEFT JOIN users ON photos.user_id = users.user_id
              LEFT JOIN likes ON photos.photo_id = likes.photo_id
              LEFT JOIN comments ON photos.photo_id = comments.photo_id
              GROUP BY photos.photo_id
              ORDER BY photos.photo_id DESC
              LIMIT $start, $limit";
}

$result = mysqli_query($conn, $query);

$photos = [];
while ($row = mysqli_fetch_assoc($result)) {
    $photos[] = $row;
}

// Hitung total jumlah data
if(isset($_GET['query'])) {
    $search = mysqli_real_escape_string($conn, $_GET['query']);
    $count_query = "SELECT COUNT(*) as total FROM photos WHERE title LIKE '%$search%' OR description LIKE '%$search%'";
} else {
    $count_query = "SELECT COUNT(*) as total FROM photos";
}

$count_result = mysqli_query($conn, $count_query);
$count_data = mysqli_fetch_assoc($count_result);
$total_pages = ceil($count_data['total'] / $limit);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Guest</title>
    <!-- Add Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Add Lightbox2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
    <!-- Add jQuery (Lightbox2 requires jQuery) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Add Lightbox2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
</head>
<body class="bg-gray-100">
    <div class="navbar bg-gray-800 text-white p-4 flex justify-between">
        <h2 class="text-lg font-bold">Selamat Datang</h2>
        <div class="flex space-x-4">
            <a href="login.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Login</a>
        </div>
    </div>

    <!-- Form pencarian -->
    <div class="search-container flex justify-center mt-4 mb-8">
        <form action="index.php" method="GET" class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
            <input type="text" placeholder="Cari foto..." name="query" class="py-2 px-4 focus:outline-none" style="width: 300px;">
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 hover:bg-black-600 transition-colors duration-300">Cari</button>
        </form>
    </div>

    <div class="container mx-auto p-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 ">
            <?php foreach ($photos as $photo) : ?>
                <div class="post overflow-hidden rounded-lg shadow-md flex flex-col w-full transform hover:scale-105 transition duration-300">
                    <a href="uploads/<?php echo $photo['image_path']; ?>" data-lightbox="gallery" data-title="<?php echo $photo['title']; ?>">
                        <img class="w-full h-40 object-cover mb-2" src="uploads/<?php echo $photo['image_path']; ?>" alt="<?php echo $photo['title']; ?>">
                    </a>
                    <div class="p-4 flex-grow">
                        <p class="text-xl font-semibold mb-3"> <?php echo $photo['user_name']; ?></p>
                        <h4 class="text-xl font-semibold mb-2"><?php echo $photo['title']; ?></h4>
                        <p class="text-gray-600 mb-2"><?php echo $photo['description']; ?></p>
                        <!-- Jumlah Like dan Komentar -->
                        <div class="flex justify-between items-center">
                            <p class="text-gray-600 mr-4"><?php echo $photo['total_likes']; ?> Likes</p>
                            <a href="komen_guest.php?photo_id=<?php echo $photo['photo_id']; ?>" class="text-gray-600 flex items-center">
                                <i class="far fa-comment text-gray-500 mr-2"></i>
                                <?php echo $photo['total_comments']; ?>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Navigasi pagination -->
        <div class="pagination mt-4 mb-8">
            <ul class="flex justify-center">
                <!-- Tombol Halaman Sebelumnya -->
                <?php if ($current_page > 1) : ?>
                    <li class="mr-2">
                        <a href="?page=<?php echo $current_page - 1; ?>&query=<?php echo isset($_GET['query']) ? $_GET['query'] : ''; ?>" class="text-blue-500 hover:text-blue-700">Previous</a>
                    </li>
                <?php endif; ?>

                <!-- Tautan ke setiap halaman -->
                <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                    <li class="mx-2">
                        <a href="?page=<?php echo $i; ?>&query=<?php echo isset($_GET['query']) ? $_GET['query'] : ''; ?>" class="<?php echo ($current_page == $i) ? 'font-bold' : ''; ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                <?php endfor; ?>

                <!-- Tombol Halaman Berikutnya -->
                <?php if ($current_page < $total_pages) : ?>
                    <li class="ml-2">
                        <a href="?page=<?php echo $current_page + 1; ?>&query=<?php echo isset($_GET['query']) ? $_GET['query'] : ''; ?>" class="text-blue-500 hover:text-blue-700">Next</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <div class="footer bg-gray-800 text-white p-4 text-center mt-8">
        <p>© 2024 My Website</p>
    </div>

    <!-- Add Font Awesome Script -->
    <link rel="stylesheet" href="./css/fontawesome.min.css">
    <link rel="stylesheet" href="./css/all.min.css">
</body>
</html>
