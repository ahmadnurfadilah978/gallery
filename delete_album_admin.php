<?php
require_once('koneksi.php');

// Periksa apakah ada data album_id yang dikirimkan melalui metode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['album_id'])) {
    $album_id = $_POST['album_id'];

    // Hapus album dari database berdasarkan album_id
    $query = "DELETE FROM albums WHERE album_id = $album_id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Jika penghapusan berhasil, arahkan kembali ke halaman dashboard
        header("Location: albums.php");
        exit();
    } else {
        // Jika penghapusan gagal, tampilkan pesan kesalahan
        echo "Error: " . mysqli_error($conn);
    }
} else {
    // Jika tidak ada data album_id yang dikirimkan, redirect kembali ke halaman dashboard
    header("Location: albums.php");
    exit();
}
?>
