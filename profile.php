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
    <style>
        /* Custom styles */
        /* Navbar */
        .navbar {
            background-color: #1a202c;
        }

        /* Profile Content */
        .container {
            max-width: 800px;
        }

        /* Footer */
        .footer {
            background-color: #1a202c;
        }
    </style>
</head>

<body class="bg-gray-100">
    <!-- Navbar -->
    <div class="navbar bg-gray-800 text-white p-4">
        <h2 class="text-lg font-bold">Welcome, <?php echo $_SESSION['username']; ?>!</h2>
    </div>

    <!-- Profile Content -->
    <div class="container mx-auto mt-8 p-8 bg-white rounded-lg shadow-lg">
        <h3 class="text-3xl font-semibold mb-4 text-center">Profil Pengguna</h3>

        <?php if ($jumlah >= 1) : ?>
            <div class="grid grid-cols-1 sm:grid-cols-1 gap-3 justify-items-center">
                <div class="flex flex-col">
                    <p class="text-lg font-semibold text-center">Username:</p>
                    <p class="text-lg text-center"><?php echo $row['username']; ?></p>
                </div>
                <div class="flex flex-col">
                    <p class="text-lg font-semibold text-center">Nama:</p>
                    <p class="text-lg text-center"><?php echo $row['name']; ?></p>
                </div>
                <div class="flex flex-col">
                    <p class="text-lg font-semibold text-center">Email:</p>
                    <p class="text-lg text-center"><?php echo $row['email']; ?></p>
                </div>
                <!-- Add other profile information here -->
            </div>
        <?php else : ?>
            <p class="text-lg text-center">Profil tidak ditemukan.</p>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <div class="footer bg-gray-800 text-white p-4 mt-8">
        <div class="flex justify-center">
            <a href="dashboard.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-4">Kembali ke Beranda</a>
            <a href="edit_profile.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit Profil</a>
        </div>
    </div>
</body>

</html>
