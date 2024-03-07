<?php
require_once('koneksi.php');
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: admin_dashboard.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'];
    $deskripsifoto = $_POST['deskripsifoto'];
    $album_id = $_POST['albumid']; // Mendapatkan ID album dari form
    $created_at = date("Y-m-d");
    $userid = $_SESSION['userid'];

    // Handling file upload
    $foto = $_FILES['foto'];
    $foto_name = $foto['name'];
    $foto_tmp = $foto['tmp_name'];

    // Determine the directory to save the photo
    $upload_dir = 'uploads/';
    $foto_path = $upload_dir . $foto_name;

    // Save photo information to the database (without access_level)
    $query = "INSERT INTO photos (user_id, album_id, title, description, image_path, created_at) 
              VALUES ('$userid', '$album_id', '$judul', '$deskripsifoto', '$foto_name', '$created_at')";
    mysqli_query($conn, $query);

    // Move the uploaded file to the specified directory
    move_uploaded_file($foto_tmp, $foto_path);

    header('Location: admin_dashboard.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Foto</title>
    <!-- Tambahkan CSS Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/fontawesome.min.css">
    <link rel="stylesheet" href="./css/all.min.css">
    <style>
        /* Tambahkan gaya khusus di sini jika diperlukan */
    </style>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h2 class="text-3xl font-semibold mb-8 text-center">Upload Foto</h2>
        <form action="" method="post" enctype="multipart/form-data" class="max-w-md mx-auto bg-white rounded-md overflow-hidden shadow-md p-6">
            <div class="mb-4">
                <label for="foto" class="block text-gray-700 font-medium">Pilih Foto:</label>
                <input type="file" id="foto" name="foto" accept="image/*" required>
            </div>
            <div class="mb-4">
                <label for="judul" class="block text-gray-700 font-medium">Judul:</label>
                <input type="text" id="judul" name="judul" class="form-input w-full mt-1 px-4 py-2 border rounded-md focus:outline-none focus:border-indigo-500" required>
            </div>
            <div class="mb-4">
                <label for="deskripsifoto" class="block text-gray-700 font-medium">Deskripsi:</label>
                <textarea id="deskripsifoto" name="deskripsifoto" class="form-textarea w-full mt-1 px-4 py-2 border rounded-md focus:outline-none focus:border-indigo-500" required></textarea>
            </div>
            <div class="mb-4">
                <label for="albumid" class="block text-gray-700 font-medium">Pilih Album:</label>
                <select id="albumid" name="albumid" class="form-select w-full mt-1 px-4 py-2 border rounded-md focus:outline-none focus:border-indigo-500" required>
                    <?php
                    // Sisipkan koneksi dan logika untuk mengambil daftar album dari database
                    require_once('koneksi.php');
                    session_start();
                    $userid = $_SESSION['userid'];
                    $query = "SELECT * FROM albums WHERE user_id = $userid";
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value=\"" . $row['album_id'] . "\">" . $row['title'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <!-- Hapus elemen yang terkait dengan akses foto -->
            <!-- Hapus elemen select dan label -->
            <!-- Hapus pemrosesan akses_level di PHP -->
            <div class="flex justify-center">
                <button type="submit" class="bg-indigo-500 text-white px-6 py-3 rounded-md hover:bg-indigo-600 transform transition duration-300 ease-in-out"><i class="fas fa-cloud-upload-alt mr-2"></i> Upload</button>
            </div>
        </form>
        <div class="mt-4 text-center">
            <a href="admin_dashboard.php" class="text-indigo-500 hover:underline">Kembali ke Beranda</a>
        </div>
    </div>
</body>

</html>
