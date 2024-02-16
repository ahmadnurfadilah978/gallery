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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>

<body class="bg-gray-100">

    <div class="navbar bg-gray-800 text-white p-4">
        <h2 class="text-lg font-bold">Admin Dashboard</h2>
        <div class="flex items-center">
            <span class="mr-4">Welcome, <?php echo $_SESSION['username']; ?>!</span>
            <a href="admin_dashboard.php" class="hover:text-gray-400">Home</a>
            <a href="data_pengguna.php" class="hover:text-gray-400 ml-4">Lihat Data Pengguna</a>
            <a href="albums.php" class="hover:text-gray-400 ml-4">Albums</a>
            <a href="fotoadmin.php" class="hover:text-gray-400 ml-4">Foto</a>
            <a href="login.php" class="bg-indigo-500 text-white px-4 py-2 rounded-md hover:bg-indigo-600 ml-4">Logout</a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mx-auto p-4">
    <?php foreach ($albums as $album) : ?>
        <div class="overflow-hidden rounded-lg shadow-md bg-white flex flex-col transform hover:scale-105 transition duration-300" style="width: 250px;">
            <a href="album_detail.php?album_id=<?php echo $album['album_id']; ?>">
                <div class="p-4 flex-grow">
                    <h4 class="text-lg font-semibold mb-2"><?php echo $album['title']; ?></h4>
                </div>
            </a>
            <!-- Tambahkan tombol hapus -->
            <form action="delete_album_admin.php" method="post" class="p-4">
                <input type="hidden" name="album_id" value="<?php echo $album['album_id']; ?>">
                <button type="submit" onclick="return confirm('Are you sure you want to delete this album?');" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Hapus</button>
            </form>
        </div>
    <?php endforeach; ?>
    </div>

    <div class="flex justify-center mt-8">
        <a href="create_album.php" class="bg-indigo-500 text-white px-6 py-3 rounded-md hover:bg-indigo-600">Buat Album Baru</a>
    </div>

    <div class="mt-8 text-center">
        <p>© 2024 My Website</p>
    </div>

</body>

</html>
