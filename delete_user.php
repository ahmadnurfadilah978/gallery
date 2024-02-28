<?php
require_once('koneksi.php');

// Pastikan user_id yang akan dihapus telah diterima melalui parameter GET
if(isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Buat query untuk menghapus pengguna berdasarkan user_id
    $delete_query = "DELETE FROM users WHERE user_id = $user_id";

    // Jalankan query
    if(mysqli_query($conn, $delete_query)) {
        // Jika pengguna berhasil dihapus, kembalikan ke halaman data_pengguna.php
        header("Location: data_pengguna.php");
        exit();
    } else {
        // Jika terjadi kesalahan saat menghapus, tampilkan pesan error
        echo "Error deleting user: " . mysqli_error($conn);
    }
} else {
    // Jika user_id tidak ditemukan dalam parameter GET, kembali ke halaman sebelumnya
    header("Location: data_pengguna.php");
    exit();
}
?>
