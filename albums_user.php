<?php
require_once('koneksi.php');
session_start();
$user_id = $_SESSION['userid'];

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Mendapatkan daftar album dari database
$query = "SELECT * FROM albums WHERE user_id = $user_id";
$result = mysqli_query($conn, $query);

$albums = [];
while ($row = mysqli_fetch_assoc($result)) {
    $albums[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Add Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/fontawesome.min.css">
    <link rel="stylesheet" href="./css/all.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- Add custom CSS -->

</head>

<body class="bg-gray-100">

<?php  include 'navbar_user.php';  ?>


    <div class="grid grid-cols-1 md:grid-cols- lg:grid-cols-5 gap-4 mx-auto p-4">
    <?php foreach ($albums as $album) : ?>
        <div class="overflow-hidden rounded-lg shadow-md bg-white flex flex-col transform hover:scale-105 transition duration-300" style="width: 250px;">
            <a href="album_detail_user.php?album_id=<?php echo $album['album_id']; ?>">
            <div class="p-4 flex-grow">
                    <h4 class="text-lg font-semibold mb-2"><?php echo $album['title']; ?></h4>
                    <p class="text-gray-600 mb-10"><?php echo $album['description']; ?></p>
                    <!-- Menampilkan deskripsi -->
                </div>
            </a>
            <!-- Tambahkan tombol edit -->
            <a href="edit_album.php?album_id=<?php echo $album['album_id']; ?>" class="absolute left-0 bottom-0 p-4">
                <i class="fa-regular fa-pen-to-square text-blue-500 hover:text-blue-700"></i>
            </a>
            <!-- Tambahkan tombol hapus -->
            <form action="delete_album.php" method="post" class="absolute right-0 bottom-0 p-4">
                <input type="hidden" name="album_id" value="<?php echo $album['album_id']; ?>">
                <button type="submit" onclick="return confirm('Are you sure you want to delete this album?');" class="text-red-500 hover:text-red-700"><i class="fa-sharp fa-solid fa-trash"></i></button>
            </form>
        </div>
    <?php endforeach; ?>
</div>



    <div class="flex justify-center mt-8">
        <a href="create_album_user.php" class="bg-indigo-500 text-white px-6 py-3 rounded-md hover:bg-indigo-600">Buat Album Baru</a>
    </div>

    

</body>


</html>
