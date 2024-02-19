<?php
require_once('koneksi.php');
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Proses jika ada pengiriman data dari form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Pastikan semua data yang diperlukan diterima dari formulir
    if(isset($_POST['album_id'], $_POST['title'], $_POST['description'])) {
        $album_id = $_POST['album_id'];
        $title = $_POST['title'];
        $description = $_POST['description'];

        // Update data album ke database
        $sql = "UPDATE albums SET title='$title', description='$description' WHERE album_id=$album_id";

        if ($conn->query($sql) === TRUE) {
            // Jika perubahan berhasil disimpan, redirect kembali ke halaman albums.php
            header("Location: albums.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Data yang diperlukan tidak lengkap";
    }
}

// Periksa apakah ada parameter album_id yang diterima dari URL
if (!isset($_GET['album_id'])) {
    header("Location: albums.php");
    exit();
}

$album_id = $_GET['album_id'];

// Dapatkan detail album dari database berdasarkan album_id yang diberikan
$query = "SELECT * FROM albums WHERE album_id = $album_id";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    // Album tidak ditemukan
    echo "Album tidak ditemukan";
    exit();
}

$album = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Album</title>
    <!-- Tambahkan Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Tambahkan style khusus untuk mengatur konten ke tengah */
        .flex-center {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Membuat konten berada di tengah layar */
        }
        /* Tambahkan style untuk memusatkan kotak form */
        .container {
            max-width: 480px; /* Atur lebar maksimum */
        }
    </style>
</head>

<body class="bg-gray-100">

    <div class="flex-center"> <!-- Tambahkan kelas flex-center di sini -->
        <div class="container mx-auto"> <!-- Tambahkan kelas mx-auto di sini -->
            <div class="max-w-md bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <h1 class="text-2xl font-bold mb-4 text-center">Edit Album</h1>
                <form action="" method="post">
                    <input type="hidden" name="album_id" value="<?php echo $album['album_id']; ?>">
                    <div class="mb-4">
                        <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Judul</label>
                        <input type="text" name="title" id="title" value="<?php echo $album['title']; ?>" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Deskripsi</label>
                        <textarea name="description" id="description" rows="3" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"><?php echo $album['description']; ?></textarea>
                    </div>
                    <div class="flex items-center justify-between">
                        <a href="albums.php" class="text-indigo-600 hover:text-indigo-900">Kembali Album</a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>
