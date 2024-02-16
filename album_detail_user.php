<?php
require_once('koneksi.php');
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Tangkap album_id dari parameter URL
if (!isset($_GET['album_id'])) {
    header("Location: albums_user.php"); // Mengarahkan ke halaman lain jika album_id tidak ditemukan
    exit();
}

$album_id = $_GET['album_id']; // Menangkap album_id dari parameter URL

// Mendapatkan daftar album dari database
$query_album = "SELECT * FROM albums WHERE album_id = $album_id";
$result_album = mysqli_query($conn, $query_album);

$album = mysqli_fetch_assoc($result_album); // Menyimpan data album ke dalam variabel $album

// Mendapatkan daftar foto dari database
$query_photos = "SELECT * FROM photos";
$result_photos = mysqli_query($conn, $query_photos);

$photos = [];
while ($row = mysqli_fetch_assoc($result_photos)) {
    $photos[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
    <style>
        .navbar {
    overflow: hidden;
    background-color: #3498db;
    padding: 10px;
    text-align: center
}

.navbar h2 {
    margin: 0;
    color: #f2f2f2;
}

.navbar a {
    color: #f2f2f2;
    text-decoration: none;
    padding: 14px 16px;
    display: inline-block;
    transition: 0.3s;
}

.navbar a:hover {
    background-color: #ddd;
    color: black;
    
}
    </style>
<head>
    <!-- Add Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Add Lightbox2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
    <!-- Add Lightbox2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
</head>
<body class="bg-gray-100">
<div class="navbar">
    <h2>Selamat Datang, <?php echo $_SESSION['username']; ?>!</h2>
    <a href="dashboard.php">Home</a>
    <a href="profile.php">Profile</a>
    <a href="albums_user.php">Lihat Album</a>
    <a href="logout.php">Logout</a>
</div>

<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 p-8">
    <?php foreach ($photos as $photo) : ?>
        
        <?php if ($photo['album_id'] == $album_id) : ?>
            <a href="uploads/<?php echo $photo['image_path']; ?>" data-lightbox="photos" data-title="<?php echo $photo['title']; ?>">
                <div class="mb-4">
                    <div class="overflow-hidden rounded-lg shadow-md hover:shadow-lg">
                        <div class="bg-cover bg-center h-40" style="background-image: url('uploads/<?php echo $photo['image_path']; ?>');">
                        </div>
                        <div class="p-4">
                            <h3 class="text-lg font-semibold"><?php echo $photo['title']; ?></h3>
                            <p class="text-gray-500"><?php echo $photo['description']; ?></p>
                        </div>
                    </div>
                </div>
            </a>
        <?php endif; ?>
    <?php endforeach; ?>
</div>

</body>
</html>


