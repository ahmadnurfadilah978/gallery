<?php
require_once('koneksi.php');
session_start();

// Periksa apakah pengguna sudah login dan memiliki akses admin
if (!isset($_SESSION['username']) || $_SESSION['access_level'] !== 'admin') {
    header("Location: admin_dashboard.php");
    exit();
}
$query_users = "SELECT * FROM users";
$result_users = mysqli_query($conn, $query_users);

$users = [];
while ($row = mysqli_fetch_assoc($result_users)) {
    $users[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <!-- Tambahkan link CSS di sini -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>

    <!-- Navbar -->
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


    <div class="container mx-auto p-8">
        <h2 class="text-2xl font-bold mb-4">User List</h2>

        <!-- Form pencarian -->
        <form class="mb-4">
            <input id="searchInput" type="text" placeholder="Search by name..." class="w-full px-4 py-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
        </form>

        <!-- Tabel daftar pengguna -->
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Access Level</th>
                
                </tr>
            </thead>
            <tbody id="userTableBody" class="bg-white divide-y divide-gray-200">
                <?php foreach ($users as $user) : ?>
                    <tr class="userDataRow">
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo $user['user_id']; ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo $user['name']; ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo $user['username']; ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo $user['email']; ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo $user['access_level']; ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Tambahkan script JavaScript untuk filter pencarian -->
    <script>
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchQuery = this.value.toLowerCase();
            const rows = document.querySelectorAll('.userDataRow');

            rows.forEach(row => {
                const name = row.childNodes[3].innerText.toLowerCase();
                if (name.includes(searchQuery)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
