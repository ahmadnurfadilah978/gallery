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
        header("Location: comments.php?photo_id=$photo_id");
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
        header("Location: comments.php?photo_id=$photo_id");
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
                            <a href="?photo_id=<?php echo $photo_id; ?>&delete_comment=<?php echo $row['comment_id']; ?>" class="text-red-500 hover:text-red-700"><i class="fa-sharp fa-solid fa-trash"></i></a>
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

    <?php if (!empty($photo_id)): ?>
        <div class="bg-white p-6 rounded-lg shadow-md max-w-lg w-full mt-4">
            <h1 class="text-2xl font-bold mb-4">Add Comment</h1>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?photo_id=' . $photo_id; ?>" method="post">
                <div class="mb-4">
                    <label for="comment_text" class="block text-gray-700 text-sm font-bold mb-2">Comment:</label>
                    <textarea name="comment_text" id="comment_text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" rows="4" required></textarea>
                </div>

                <!-- Anda dapat menghapus input hidden ini jika user_id tersedia dalam sesi -->
                <!-- <input type="hidden" name="user_id" value="1"> -->
                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Submit</button>
                    <a href="dashboard.php?photo_id=<?php echo $photo_id; ?>" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">Cancel</a>
                </div>
            </form>
        </div>
    <?php endif; ?>
</body>
</html>
