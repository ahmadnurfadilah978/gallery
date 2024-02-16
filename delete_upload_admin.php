<?php
require_once('koneksi.php');
session_start();

// Periksa apakah pengguna sudah login dan memiliki akses admin
if (!isset($_SESSION['username']) || $_SESSION['access_level'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $photo_id = $_GET['id'];

    // Query untuk menghapus foto dari database
    $query = "DELETE FROM photos WHERE photo_id = $photo_id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Jika berhasil dihapus, redirect ke halaman admin_dashboard.php atau halaman lain yang sesuai
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "Failed to delete photo.";
        exit();
    }
} else {
    echo "Invalid request.";
    exit();
}
?>
