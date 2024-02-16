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
        header("Location: albums_user.php");
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
    <style>
        .navbar {
            overflow: hidden;
            background-color: #3498db;
            padding: 10px;
            text-align: center
        }

        .navbar h2 {
            margin: 0;
            color: #f2f2f2;
        }

        .navbar a {
            color: #f2f2f2;
            text-decoration: none;
            padding: 14px 16px;
            display: inline-block;
            transition: 0.3s;
        }

        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }
    </style>
</head>

<body class="bg-gray-100">

    <div class="navbar">
        <h2>Selamat Datang, <?php echo $_SESSION['username']; ?>!</h2>
        <a href="dashboard.php">Home</a>
        <a href="profile.php">Profile</a>
        <a href="albums_user.php">Lihat Album</a>
        <a href="logout.php">Logout</a>
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
                    <textarea id="description" name="description" class="w-full mt-1 px-4 py-2 border rounded-md focus:outline-none focus:border-indigo-500" rows="4"></textarea>
                </div>
                <div>
                    <button type="submit" class="bg-indigo-500 text-white px-6 py-3 rounded-md hover:bg-indigo-600">Create Album</button>
                </div>
            </form>
        </div>
    </div>

</body>

</html>
