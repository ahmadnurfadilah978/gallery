<?php
require_once('koneksi.php');

// Periksa apakah ada data album_id yang dikirimkan melalui metode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['album_id'])) {
    $album_id = $_POST['album_id'];

    // Mulai transaksi
    mysqli_autocommit($conn, false);
    $error = false;

    // Hapus foto-foto terkait dengan album yang akan dihapus
    $queryDeletePhotos = "DELETE FROM photos WHERE album_id = $album_id";
    if (!mysqli_query($conn, $queryDeletePhotos)) {
        $error = true;
    }

    // Hapus album dari database berdasarkan album_id
    $queryDeleteAlbum = "DELETE FROM albums WHERE album_id = $album_id";
    if (!mysqli_query($conn, $queryDeleteAlbum)) {
        $error = true;
    }

    // Commit atau rollback transaksi
    if ($error === false) {
        mysqli_commit($conn);
        header("Location: albums.php");
        exit();
    } else {
        mysqli_rollback($conn);
        echo "Error deleting album and related photos: " . mysqli_error($conn);
    }
    
    // Akhiri transaksi
    mysqli_autocommit($conn, true);
} else {
    // Jika tidak ada data album_id yang dikirimkan, redirect kembali ke halaman albums.php
    header("Location: albums.php");
    exit();
}
?>
