<?php
session_start(); // Mulai session

require('koneksi.php');

// Proses form login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username']) && isset($_POST['password'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query untuk mendapatkan data pengguna berdasarkan username
    $query = "SELECT * FROM `users` WHERE username='$username'";
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
    $row = mysqli_fetch_assoc($result);

    // Periksa apakah pengguna ditemukan dan password cocok
    if ($row && md5($password) === $row['password']) {
        $_SESSION['username'] = $username;
        $_SESSION['userid'] = $row['user_id'];
        $_SESSION['access_level'] = $row['access_level'];

        // Redirect sesuai dengan akses level
        if ($row['access_level'] === 'admin') {
            header("Location: admin_dashboard.php");
        } else {
            header("Location: dashboard.php");
        }
        exit(); // Keluar untuk menghentikan eksekusi lebih lanjut
    } else {
        echo "<div class='form-container mx-auto mt-20'>
            <h1 class='text-center text-2xl font-bold mb-4'>Log In</h1>
            <div class='text-center text-red-500'>Username/password is incorrect.</div>
            <form action='' method='post' name='login' class='w-full max-w-sm mx-auto'>
                <input type='text' name='username' placeholder='Username' class='block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-400 focus:ring focus:ring-blue-400 focus:ring-opacity-50 mb-3 px-4 py-2' required />
                <input type='password' name='password' placeholder='Password' class='block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-400 focus:ring focus:ring-blue-400 focus:ring-opacity-50 mb-3 px-4 py-2' required />
                <input name='submit' type='submit' value='Login' class='w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded' />
            </form>
            <p class='text-center mt-4'>Belum Terdaftar? <a href='registration.php' class='text-blue-500'>Register Here</a></p>
        </div>";
    }
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Add Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="form-container mx-auto mt-20">
        <h1 class="text-center text-2xl font-bold mb-4">Log In</h1>
        <form action="" method="post" name="login" class="w-full max-w-sm mx-auto">
            <input type="text" name="username" placeholder="Username" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-400 focus:ring focus:ring-blue-400 focus:ring-opacity-50 mb-3 px-4 py-2" required />
            <input type="password" name="password" placeholder="Password" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-400 focus:ring focus:ring-blue-400 focus:ring-opacity-50 mb-3 px-4 py-2" required />
            <input name="submit" type="submit" value="Login" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" />
        </form>
        <p class="text-center mt-4">Belum Terdaftar? <a href='registration.php' class="text-blue-500">Daftar Disini</a></p>
    </div>
</body>
</html>
<?php
}
?>
