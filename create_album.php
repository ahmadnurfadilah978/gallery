<?php
require_once('koneksi.php');
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Tangkap data dari form jika ada
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $user_id = $_SESSION['userid'];

    // Masukkan data ke dalam database
    $query = "INSERT INTO albums (user_id, title, description) VALUES ('$user_id', '$title', '$description')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Redirect ke halaman albums.php jika berhasil
        header("Location: albums.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Add Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Album</title>
</head>

<body class="bg-gray-100">

    <div class="navbar bg-gray-800 text-white p-4">
        <h2 class="text-lg font-bold">Admin Dashboard</h2>
        <div class="flex items-center">
            <span class="mr-4">Welcome, <?php echo $_SESSION['username']; ?>!</span>
            <a href="admin_dashboard.php" class="hover:text-gray-400">Home</a>
            <a href="data_pengguna.php" class="hover:text-gray-400 ml-4">Lihat Data Pengguna</a>
            <a href="albums.php" class="hover:text-gray-400 ml-4">Albums</a>
            <a href="fotoadmin.php" class="hover:text-gray-400 ml-4">Foto</a>
            <a href="login.php" class="bg-indigo-500 text-white px-4 py-2 rounded-md hover:bg-indigo-600 ml-4">Logout</a>
        </div>
    </div>

    <div class="container mx-auto mt-8">
        <div class="max-w-md mx-auto bg-white rounded-md overflow-hidden shadow-md p-8">
            <h2 class="text-2xl font-semibold mb-4">Create New Album</h2>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="mb-4">
                    <label for="title" class="block text-gray-700 font-medium">Title:</label>
                    <input type="text" id="title" name="title" class="w-full mt-1 px-4 py-2 border rounded-md focus:outline-none focus:border-indigo-500" required>
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-gray-700 font-medium">Description:</label>
                    <textarea id="description" name="description" class="w-full mt-1 px-4 py-2 border rounded-md focus:outline-none focus:border-indigo-500" rows="4" required></textarea>
                </div>
                <div>
                    <button type="submit" class="bg-indigo-500 text-white px-6 py-3 rounded-md hover:bg-indigo-600">Create Album</button>
                </div>
            </form>
        </div>
    </div>

</body>

</html>
