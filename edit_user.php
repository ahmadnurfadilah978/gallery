<?php
require_once('koneksi.php');
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Fungsi untuk mendapatkan data pengguna berdasarkan ID
function getUserById($conn, $user_id) {
    $query = "SELECT * FROM users WHERE user_id = $user_id";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}

// Ambil user ID dari parameter URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $user_id = $_GET['id'];
    $_SESSION['user_id'] = $user_id;
} else {
    echo "User ID tidak valid.";
    exit();
}

// Periksa apakah formulir telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data yang di-submit dari formulir
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $access_level = $_POST['access_level'];

    // Persiapkan query SQL untuk memperbarui informasi pengguna
    $update_query = "UPDATE users SET name='$name', username='$username', email='$email', access_level='$access_level' WHERE user_id=$user_id";

    // Eksekusi query untuk memperbarui data pengguna
    if (mysqli_query($conn, $update_query)) {
        echo "Informasi pengguna berhasil diperbarui.";
        // Redirect kembali ke halaman data_pengguna.php
        header("Location: data_pengguna.php");
        exit();
    } else {
        echo "Terjadi kesalahan saat memperbarui informasi pengguna: " . mysqli_error($conn);
    }
}

// Ambil informasi pengguna dari database berdasarkan ID
$user = getUserById($conn, $user_id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <!-- Tambahkan Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto py-8">
        <div class="max-w-md mx-auto bg-white rounded-lg overflow-hidden shadow-md">
            <h2 class="text-2xl font-bold text-center mt-4 mb-8">Edit User</h2>
            <form method="POST" action="" class="px-6 py-4">
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo $user['name']; ?>"
                        class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div class="mb-4">
                    <label for="username" class="block text-sm font-medium text-gray-700">Username:</label>
                    <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>"
                        class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>"
                        class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div class="mb-4">
                    <label for="access_level" class="block text-sm font-medium text-gray-700">Access Level:</label>
                    <input type="text" id="access_level" name="access_level" value="<?php echo $user['access_level']; ?>"
                        class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <button type="submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-300 w-full">Submit</button>
            </form>
        </div>
    </div>
</body>

</html>
