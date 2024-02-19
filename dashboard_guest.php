<?php
session_start();

// Periksa apakah pengguna sudah login sebagai 'guest'
if (isset($_SESSION['username']) && $_SESSION['username'] === 'guest') {
    // Mendapatkan daftar foto dari database
    require_once('koneksi.php');

    $query = "SELECT * FROM photos";
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
    <title>Dashboard - Guest</title>
    <!-- Add Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="navbar bg-gray-800 text-white p-4 flex justify-between">
        <h2 class="text-lg font-bold">Selamat Datang, <?php echo $_SESSION['username']; ?>!</h2>
        <div class="flex space-x-4">
            <a href="logout.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Login</a>
        </div>
    </div>

    <div class="container mx-auto p-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 ">
            <?php foreach ($photos as $photo) : ?>
                <div class="post overflow-hidden rounded-lg shadow-md flex flex-col w-full transform hover:scale-105 transition duration-300">
                    <a href="uploads/<?php echo $photo['image_path']; ?>" data-lightbox="gallery" data-title="<?php echo $photo['title']; ?>">
                        <img class="w-full h-40 object-cover mb-2" src="uploads/<?php echo $photo['image_path']; ?>" alt="<?php echo $photo['title']; ?>">
                    </a>
                    <div class="p-4 flex-grow">
                        <h4 class="text-xl font-semibold mb-2"><?php echo $photo['title']; ?></h4>
                        <p class="text-gray-600 mb-4"><?php echo $photo['description']; ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="footer bg-gray-800 text-white p-4 text-center mt-8">
        <p>© 2024 My Website</p>
    </div>
</body>
</html>


<?php
} else {
    // Jika bukan guest, arahkan ke halaman login
    header("Location: login.php");
    exit();
}
?>
