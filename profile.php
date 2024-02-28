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
   
</head>

<body class="bg-gray-100">

<?php include 'navbar_user.php'; ?>

<div class="container mx-auto mt-4 p-1 bg-white rounded-none text-center"> <!-- Mengubah nilai padding menjadi p-1, menghapus shadow-lg, dan menghilangkan rounded-lg -->
    <h3 class="text-3xl font-semibold mb-4">Profil Pengguna</h3> <!-- Teks "Profil Pengguna" tetap di tengah -->

    <?php if ($jumlah >= 1) : ?>
        <div class="grid grid-cols-1 sm:grid-cols-1 gap-3 mx-auto"> <!-- Menjadikan kontainer di tengah dengan mx-auto -->
            <div class="flex flex-col"> <!-- Menghapus kelas items-end dari div ini -->
                <p class="text-lg font-semibold text-center">Username: <?php echo $row['username']; ?></p> <!-- Memposisikan teks Username ke tengah -->
            </div>

            <div class="flex flex-col"> <!-- Menghapus kelas items-end dari div ini -->
                <p class="text-lg font-semibold text-center">Nama:  <?php echo $row['name']; ?></p> <!-- Memposisikan teks Nama ke tengah -->
            </div>

            <div class="flex flex-col"> <!-- Menghapus kelas items-end dari div ini -->
                <p class="text-lg font-semibold text-center">Email:  <?php echo $row['email']; ?></p> <!-- Memposisikan teks Email ke tengah -->
            </div>

            <div class="flex justify-center">
                <a href="edit_profile.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit Profil</a>
            </div>
            <!-- Add other profile information here -->
        </div>
    <?php else : ?>
        <p class="text-lg text-center">Profil tidak ditemukan.</p>
    <?php endif; ?>

</div>
</body>

</html>
