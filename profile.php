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

    <div class="container mx-auto mt-8 px-4"> <!-- Add padding to the container -->
        <div class="bg-white rounded-lg shadow-md p-8"> <!-- Add padding to the card -->
            <h3 class="text-3xl font-semibold mb-4 text-center">Profil Pengguna</h3> <!-- Center align the heading -->

            <?php if ($jumlah >= 1) : ?>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4"> <!-- Adjust column layout and gap -->
                    <div class="bg-gray-100 rounded-md p-4"> <!-- Add background color and padding -->
                        <p class="text-lg font-semibold mb-2 text-center">Username   :</p> <!-- Add margin bottom -->
                        <p class="text-base text-center"><?php echo $row['username']; ?></p> <!-- Center align text -->
                    </div>

                    <div class="bg-gray-100 rounded-md p-4"> <!-- Add background color and padding -->
                        <p class="text-lg font-semibold mb-2 text-center">Nama   :</p> <!-- Add margin bottom -->
                        <p class="text-base text-center"><?php echo $row['name']; ?></p> <!-- Center align text -->
                    </div>

                    <div class="bg-gray-100 rounded-md p-4"> <!-- Add background color and padding -->
                        <p class="text-lg font-semibold mb-2 text-center">Email   :</p> <!-- Add margin bottom -->
                        <p class="text-base text-center"><?php echo $row['email']; ?></p> <!-- Center align text -->
                    </div>
                </div>

                <div class="flex justify-center mt-8"> <!-- Center the button -->
                    <a href="edit_profile.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit Profil</a>
                </div>
            <?php else : ?>
                <p class="text-lg text-center mt-8">Profil tidak ditemukan.</p> <!-- Center align text -->
            <?php endif; ?>

        </div>
    </div>

</body>

</html>
