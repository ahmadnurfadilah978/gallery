<?php
require_once('koneksi.php');
session_start();

// Periksa apakah pengguna sudah login dan memiliki akses admin
if (!isset($_SESSION['username']) || $_SESSION['access_level'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Periksa apakah formulir telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];

    // Proses unggah foto
    $file_name = $_FILES['image']['name'];
    $file_tmp = $_FILES['image']['tmp_name'];
    $file_size = $_FILES['image']['size'];
    $file_error = $_FILES['image']['error'];

    // Periksa apakah file terunggah dengan benar
    if ($file_error === 0) {
        // Periksa ukuran file
        if ($file_size <= 5000000) { // Maksimum 5 MB
            // Simpan file di folder uploads
            $file_destination = 'uploads/' . $file_name;
            move_uploaded_file($file_tmp, $file_destination);

            // Simpan informasi tentang foto di database
            $query = "INSERT INTO photos (title, description, image_path) VALUES ('$title', '$description', '$file_name')";
            $result = mysqli_query($conn, $query);

            if ($result) {
                // Redirect kembali ke halaman admin setelah unggahan berhasil
                header("Location: admin_dashboard.php");
                exit();
            } else {
                // Jika gagal menyimpan informasi ke database
                echo "Terjadi kesalahan. Silakan coba lagi.";
            }
        } else {
            // Jika ukuran file terlalu besar
            echo "Ukuran file terlalu besar. Maksimum 5 MB.";
        }
    } else {
        // Jika terjadi kesalahan saat mengunggah file
        echo "Terjadi kesalahan saat mengunggah file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Photo</title>
</head>
<body>
    <h2>Upload Photo</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title"><br>
        <label for="description">Description:</label><br>
        <textarea id="description" name="description"></textarea><br>
        <label for="image">Choose an image:</label><br>
        <input type="file" id="image" name="image"><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
