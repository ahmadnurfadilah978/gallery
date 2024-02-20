<?php
require_once('koneksi.php');
session_start();

// Periksa koneksi
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

// Ambil parameter photo_id dari URL
$photo_id = isset($_GET['photo_id']) ? $_GET['photo_id'] : '';

// Proses penambahan komentar jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['userid']; // Asumsikan Anda memiliki informasi user_id dalam sesi
    $comment_text = $_POST['comment_text'];

    // Query untuk menyimpan komentar ke database
    $sql = "INSERT INTO comments (user_id, photo_id, comment_text) VALUES ($user_id, $photo_id, '$comment_text')";

    if ($conn->query($sql) === TRUE) {
        // Komentar berhasil ditambahkan, redirect ke halaman komentar
        header("Location: komen_guest.php?photo_id=$photo_id");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Proses penghapusan komentar
if (isset($_GET['delete_comment'])) {
    $comment_id = $_GET['delete_comment'];

    // Query untuk menghapus komentar dari database
    $delete_sql = "DELETE FROM comments WHERE comment_id = $comment_id AND user_id = {$_SESSION['userid']}";

    if ($conn->query($delete_sql) === TRUE) {
        // Komentar berhasil dihapus
        header("Location: komen_guest.php?photo_id=$photo_id");
        exit();
    } else {
        echo "Error: " . $delete_sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo empty($photo_id) ? 'Parameter photo_id tidak ditemukan' : 'Comments'; ?></title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/fontawesome.min.css">
    <link rel="stylesheet" href="./css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen flex flex-col justify-center items-center">
    <div class="bg-white p-6 rounded-lg shadow-md max-w-lg w-full">
        <?php if (empty($photo_id)): ?>
            <p class="text-red-600">Parameter photo_id tidak ditemukan.</p>
        <?php else: ?>
            <h1 class="text-2xl font-bold mb-4">Comments</h1>
            <div class="mb-4">
                <!-- Form untuk menambahkan komentar baru -->
            </div>
            <?php
            // Query untuk mengambil komentar sesuai dengan photo_id
            $sql = "SELECT comments.*, users.username FROM comments 
                    INNER JOIN users ON comments.user_id = users.user_id
                    WHERE photo_id = $photo_id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data dari setiap baris
                while($row = $result->fetch_assoc()) {
                    ?>
                    <div class="bg-gray-200 p-4 rounded-md mb-2 flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-700"><strong>Komentar dari <?php echo $row["username"]; ?>:</strong></p>
                            <p class="text-gray-800"><?php echo $row["comment_text"]; ?></p>
                        </div>
                        <?php if ($row['user_id'] == $_SESSION['userid']): ?>
                            <!-- Tombol hapus komentar -->
                            <a href="?photo_id=<?php echo $photo_id; ?>&delete_comment=<?php echo $row['comment_id']; ?>"></a>
                        <?php endif; ?>
                    </div>
                    <?php
                }
            } else {
                echo '<p class="text-gray-700">Belum ada komentar untuk foto ini.</p>';
            }
            ?>
        <?php endif; ?>
    </div>
    <div class="mt-4 text-center">
            <a href="index.php" class="text-indigo-500 hover:underline">Kembali ke Beranda</a>
        </div>

</body>
</html>
