<?php
require_once('koneksi.php');

// Periksa apakah parameter id diberikan
if (isset($_GET['id'])) {
    $photo_id = $_GET['id'];

    // Hapus data foto dari database berdasarkan ID
    $query = "DELETE FROM photos WHERE photo_id = $photo_id";
    mysqli_query($conn, $query);

    // Redirect kembali ke halaman utama setelah penghapusan
    header("Location: dashboard.php");
    exit();
} else {
    // Redirect jika parameter id tidak diberikan
    header("Location: index.php");
    exit();
}
?>
