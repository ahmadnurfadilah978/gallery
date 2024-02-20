<?php
// profile.php
require_once('koneksi.php');
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Get user ID from the session
$user_id = $_SESSION['username'];

// Fetch user information from the database
$query_users = "SELECT * FROM users where username='$user_id'";
$result_users = mysqli_query($conn, $query_users);
$jumlah = mysqli_num_rows($result_users);
$row = mysqli_fetch_assoc($result_users);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Link your custom CSS file if needed -->
</head>

<body class="bg-gray-100">
    <!-- Navbar -->
    <div class="navbar bg-gray-800 text-white p-4">
        <h2 class="text-lg font-bold">Welcome, <?php echo $_SESSION['username']; ?>!</h2>
        <div class="container">
            <h3 class="text-2xl font-bold">Profil Pengguna</h3>

            <?php if ($jumlah >= 1) : ?>
                <p class="mt-4 text-lg">Username: <?php echo $row['username']; ?></p>
                <p class="mt-2 text-lg">Nama: <?php echo $row['name']; ?></p>
                <p class="mt-2 text-lg">Email: <?php echo $row['email']; ?></p>

                <!-- Add other profile information here -->
            <?php else : ?>
                <p class="text-lg">Profil tidak ditemukan.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer bg-gray-800 text-white p-4">
        <div class="flex items-center justify-center">
            <a href="dashboard.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-4">Back to Home</a>
            <a href="edit_profile.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-4">Edit Profil</a>
        </div>
    </div>
</body>

</html>
