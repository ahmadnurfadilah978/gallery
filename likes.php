<?php
require_once('koneksi.php');
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Tangkap foto ID dari parameter URL
if (isset($_GET['fotoid'])) {
    $photo_id = $_GET['fotoid'];

    // Periksa apakah pengguna sudah memberi like pada foto ini sebelumnya
    $user_id = $_SESSION['userid'];
    $check_query = "SELECT * FROM likes WHERE user_id = $user_id AND photo_id = $photo_id";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) == 0) {
        // Jika pengguna belum memberi like, tambahkan like ke database
        $insert_query = "INSERT INTO likes (user_id, photo_id) VALUES ($user_id, $photo_id)";
        mysqli_query($conn, $insert_query);
    } else {
        // Jika pengguna sudah memberi like sebelumnya, hapus like dari database
        $delete_query = "DELETE FROM likes WHERE user_id = $user_id AND photo_id = $photo_id";
        mysqli_query($conn, $delete_query);
    }

    // Redirect kembali ke halaman sebelumnya
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
} else {
    // Parameter foto ID tidak diberikan, redirect ke halaman utama
    header("Location: index.php");
    exit();
}
?>
