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

    <!-- Add custom CSS -->
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
</head>

<body class="bg-gray-100">

    <div class="navbar">
        <h2>Selamat Datang, <?php echo $_SESSION['username']; ?>!</h2>
        <a href="dashboard.php">Home</a>
        <a href="profile.php">Profile</a>
        <a href="albums_user.php">Lihat Album</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols- lg:grid-cols-5 gap-4 mx-auto p-4">
        <?php foreach ($albums as $album) : ?>
            <div class="overflow-hidden rounded-lg shadow-md bg-white flex flex-col transform hover:scale-105 transition duration-300">
                <a href="album_detail_user.php?album_id=<?php echo $album['album_id']; ?>">
                    <div class="p-4 flex-grow">
                        <h4 class="text-xl font-semibold mb-2"><?php echo $album['title']; ?></h4>
                        <p class="text-gray-600 mb-2"><?php echo $album['description']; ?></p> <!-- Menampilkan deskripsi -->
                        <!-- Tambahkan tombol edit dan hapus -->
                        <div class="p-4 flex justify-between">
                            <a href="edit_album.php?album_id=<?php echo $album['album_id']; ?>" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600"></i> Edit </a>
                            
                            <form action="delete_album.php" method="post">
                                <input type="hidden" name="album_id" value="<?php echo $album['album_id']; ?>">
                                <button type="submit" onclick="return confirm('Are you sure you want to delete this album?');" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Hapus</button>
                            </form>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="flex justify-center mt-8">
        <a href="create_album_user.php" class="bg-indigo-500 text-white px-6 py-3 rounded-md hover:bg-indigo-600">Buat Album Baru</a>
    </div>

    <div class="mt-8 text-center">
        <p>© 2023 My Website</p>
    </div>

</body>

</html>
