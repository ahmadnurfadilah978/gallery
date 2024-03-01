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
        header("Location: {$_SERVER['PHP_SELF']}?photo_id=$photo_id");
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
        header("Location: {$_SERVER['PHP_SELF']}?photo_id=$photo_id");
        exit();
    } else {
        echo "Error: " . $delete_sql . "<br>" . $conn->error;
    }
}

// Query untuk mengambil data foto dan deskripsi dari tabel photos
$sql_photo = "SELECT * FROM photos WHERE photo_id = $photo_id";
$result_photo = $conn->query($sql_photo);

// Data foto dan deskripsi
$photo_data = $result_photo->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo empty($photo_id) ? 'Parameter photo_id tidak ditemukan' : 'Photo Detail'; ?></title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/fontawesome.min.css">
    <link rel="stylesheet" href="./css/all.min.css">
    <style>
        .enlarge-image {
            width: 100%; /* Menyesuaikan lebar parent container */
            max-width: 600px; /* Maksimum lebar gambar */
            height: auto; /* Menyesuaikan tinggi dengan rasio aspek gambar */
        }
        .cancel-button {
            position: absolute;
            bottom: 0;
            right: 0;
        }
    </style>
    <script>
        function confirmDelete(commentId) {
            if (confirm("Apakah Anda yakin ingin menghapus komentar ini?")) {
                window.location.href = "<?php echo $_SERVER['PHP_SELF']; ?>?photo_id=<?php echo $photo_id; ?>&delete_comment=" + commentId;
            }
        }
    </script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col justify-center items-center relative"> <!-- Tambahkan kelas relative pada body -->
    <div class="bg-white p-6 rounded-lg shadow-md max-w-lg w-full relative"> <!-- Tambahkan kelas relative pada div -->
        <?php if (empty($photo_id) || !$photo_data): ?>
            <p class="text-red-600">Parameter photo_id tidak ditemukan atau tidak ada data foto untuk ID tersebut.</p>
        <?php else: ?>
            <img class="enlarge-image object-cover mb-2" src="uploads/<?php echo $photo_data['image_path']; ?>" alt="<?php echo $photo_data['title']; ?>">
            <p class="text-gray-800"><?php echo $photo_data['description']; ?></p>

            <!-- Comments Section -->
            <h2 class="text-xl font-bold mt-6 mb-4">Comments</h2>
            <div>
                <?php
                // Query untuk mengambil komentar sesuai dengan photo_id
                $sql_comments = "SELECT comments.*, users.username FROM comments 
                                INNER JOIN users ON comments.user_id = users.user_id
                                WHERE photo_id = $photo_id";
                $result_comments = $conn->query($sql_comments);

                if ($result_comments->num_rows > 0) {
                    // Output data dari setiap baris
                    while($row = $result_comments->fetch_assoc()) {
                        ?>
                        <div class="bg-gray-200 p-4 rounded-md mb-2 flex justify-between items-center">
                            <div>
                                <p class="text-sm text-gray-700"><strong>Comment by <?php echo $row["username"]; ?>:</strong></p>
                                <p class="text-gray-800"><?php echo $row["comment_text"]; ?></p>
                            </div>
                            <?php if ($row['user_id'] == $_SESSION['userid']): ?>
                                <!-- Tombol hapus komentar dengan peringatan konfirmasi -->
                                <a href="javascript:void(0);" onclick="confirmDelete(<?php echo $row['comment_id']; ?>)" class="text-red-500 hover:text-red-700"><i class="fa-sharp fa-solid fa-trash"></i></a>
                            <?php endif; ?>
                        </div>
                        <?php
                    }
                } else {
                    echo '<p class="text-gray-700">No comments yet.</p>';
                }
                ?>
            </div>

            <!-- Form untuk menambahkan komentar -->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?photo_id=' . $photo_id; ?>" method="post" class="mt-6 relative"> <!-- Tambahkan kelas relative pada form -->
                <div class="mb-4">
                    <label for="comment_text" class="block text-gray-700 text-sm font-bold mb-2">Add Comment:</label>
                    <textarea name="comment_text" id="comment_text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" rows="4" required></textarea>
                </div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Submit</button>
                <a href="dashboard.php" class="cancel-button mb-4 font-bold text-blue-500 hover:text-blue-700 hover:underline">Cancel</a> 
                <!-- Tautan untuk kembali ke dashboard -->
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
