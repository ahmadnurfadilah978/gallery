<?php
// edit_profile.php
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
$row = mysqli_fetch_assoc($result_users);

// Handle form submission to update profile
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $new_username = $_POST['username']; // Added for username update

    // Update user information in the database, including username
    $update_query = "UPDATE users SET name='$name', email='$email', username='$new_username' WHERE username='$user_id'";
    $result = mysqli_query($conn, $update_query);

    if ($result) {
        // Update session username if it's changed
        $_SESSION['username'] = $new_username;

        header("Location: profile.php");
        exit();
    } else {
        echo "Update failed. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-6 text-center">Edit Profil</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="max-w-md mx-auto bg-white p-6 rounded-md shadow-md">
            <div class="mb-4">
                <label for="username" class="block text-gray-700 font-semibold mb-2">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo $row['username']; ?>" class="border-2 border-gray-300 rounded-md p-2 w-full focus:outline-none focus:border-blue-500">
            </div>
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-semibold mb-2">Nama:</label>
                <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>" class="border-2 border-gray-300 rounded-md p-2 w-full focus:outline-none focus:border-blue-500">
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-semibold mb-2">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $row['email']; ?>" class="border-2 border-gray-300 rounded-md p-2 w-full focus:outline-none focus:border-blue-500">
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Simpan</button>
        </form>
    </div>
</body>

</html>
