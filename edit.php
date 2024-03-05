<?php
require_once('koneksi.php');
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Periksa apakah parameter id diberikan
if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$photo_id = $_GET['id'];

// Ambil data foto dari database berdasarkan ID
$query = "SELECT * FROM photos WHERE photo_id = $photo_id";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

// Periksa apakah data foto ditemukan
if (!$row) {
    // Redirect jika data foto tidak ditemukan
    header("Location: dashboard.php");
    exit();
}

// Periksa apakah pengguna memiliki izin untuk mengedit foto
if ($_SESSION['userid'] != $row['user_id']) {
    // Redirect jika pengguna tidak memiliki izin
    header("Location: dashboard.php");
    exit();
}

// Proses update foto jika form dikirimkan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];

    // Update data judul dan deskripsi ke database
    $query = "UPDATE photos SET title = '$judul', description = '$deskripsi' WHERE photo_id = $photo_id";
    mysqli_query($conn, $query);

    // Proses unggah file foto jika ada file yang dipilih
    if ($_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        // Direktori tempat menyimpan foto
        $upload_directory = "uploads/";

        // Mendapatkan nama file yang diunggah
        $filename = $_FILES['foto']['name'];

        // Memindahkan file yang diunggah ke direktori upload
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $upload_directory . $filename)) {
            // Update nama file foto ke database
            $query = "UPDATE photos SET image_path = '$filename' WHERE photo_id = $photo_id";
            mysqli_query($conn, $query);
        }
    }

    // Redirect kembali ke halaman utama setelah pembaruan
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Photo</title>
    <!-- Add Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Add Lightbox2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/fontawesome.min.css">
    <link rel="stylesheet" href="./css/all.min.css">
</head>
<body class="bg-gray-100">

<!-- Form Edit Photo -->
<div class="container mx-auto px-4 py-8 max-w-md">
    <h2 class="text-2xl font-bold mb-4 text-center">Edit Photo</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $photo_id; ?>" method="post" enctype="multipart/form-data" class="bg-white shadow-md rounded px-8 py-8">
        <div class="mb-4">
            <label for="foto" class="block text-gray-700 font-medium">Pilih Foto:</label>
            <input type="file" id="foto" name="foto" accept="image/*" required class="w-full p-2 border border-gray-300 rounded-md text-sm">
        </div>
        <div class="mb-4">
            <label for="judul" class="block text-gray-700 text-sm font-bold mb-2">Judul:</label>
            <input type="text" id="judul" name="judul" value="<?php echo $row['title']; ?>" class="w-full p-2 border border-gray-300 rounded-md text-sm">
        </div>
        <div class="mb-4">
            <label for="deskripsi" class="block text-gray-700 text-sm font-bold mb-2">Deskripsi:</label>
            <textarea id="deskripsi" name="deskripsi" rows="4" class="w-full p-2 border border-gray-300 rounded-md text-sm"><?php echo $row['description']; ?></textarea>
        </div>
        <div class="flex items-center justify-between">
            <input type="submit" value="Simpan" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">
        </div>
    </form>
</div>

</body>
</html>
