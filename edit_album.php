<?php
// Periksa apakah pengguna sudah login
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Pastikan album_id tersedia dalam parameter URL
if (!isset($_GET['album_id'])) {
    header("Location: albums_user.php"); // Redirect ke halaman lain jika album_id tidak ditemukan
    exit();
}

// Ambil album_id dari parameter URL
$album_id = $_GET['album_id'];

// Tambahkan koneksi ke database atau file koneksi.php
require_once('koneksi.php');

// Query untuk mendapatkan detail album dari database berdasarkan album_id
$query = "SELECT * FROM albums WHERE album_id = $album_id";
$result = mysqli_query($conn, $query);

// Periksa apakah album ditemukan
if (mysqli_num_rows($result) !== 1) {
    echo "Album not found!";
    exit();
}

// Ambil data album dari hasil query
$album = mysqli_fetch_assoc($result);

// Proses form jika ada pengiriman data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data yang dikirim dari form
    $title = $_POST['title'];
    $description = $_POST['description'];

    // Update data album ke database
    $update_query = "UPDATE albums SET title = '$title', description = '$description' WHERE album_id = $album_id";
    $update_result = mysqli_query($conn, $update_query);

    // Periksa apakah query berhasil dieksekusi
    if ($update_result) {
        // Redirect ke halaman detail album setelah berhasil mengedit
        header("Location: albums_user.php?album_id=$album_id");
        exit();
    } else {
        echo "Failed to update album!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Album</title>
    <!-- Tambahkan link CSS Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 py-8 px-4">
    <div class="max-w-md mx-auto bg-white rounded-md shadow-md p-6">
        <h2 class="text-2xl font-bold mb-4">Edit Album</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?album_id=<?php echo $album_id; ?>" method="post">
            <div class="mb-4">
                <label for="title" class="block text-gray-700 font-semibold mb-2">Title:</label>
                <input type="text" id="title" name="title" value="<?php echo $album['title']; ?>" class="w-full p-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:border-blue-500">
            </div>
            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-semibold mb-2">Description:</label>
                <textarea id="description" name="description" class="w-full p-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:border-blue-500"><?php echo $album['description']; ?></textarea>
            </div>
            <div class="mb-4">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Update</button>
            </div>
        </form>
    </div>
</body>

</html>
