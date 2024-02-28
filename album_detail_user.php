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
 
<head>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Add Lightbox2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
    <!-- Add jQuery (Lightbox2 requires jQuery) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Add Lightbox2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    
</head>
<body class="bg-gray-100">
    
<?php  include 'navbar_user.php';  ?>


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
<script>
        function confirmLogout() {
            if (confirm('Apakah Anda yakin ingin logout?')) {
                window.location.href = 'index.php';
            }
        }
    </script>
</html>



