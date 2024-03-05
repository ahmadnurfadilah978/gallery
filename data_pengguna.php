<?php
// Masukkan koneksi.php
require_once('koneksi.php');
session_start();

// Cek apakah pengguna telah login dan merupakan admin
if (!isset($_SESSION['username']) || $_SESSION['access_level'] !== 'admin') {
    header("Location: admin_dashboard.php");
    exit();
}

// Dapatkan username admin saat ini
$currentAdminUsername = $_SESSION['username'];

// Ambil data pengguna dari database
$query_users = "SELECT * FROM users";
$result_users = mysqli_query($conn, $query_users);

$users = [];
while ($row = mysqli_fetch_assoc($result_users)) {
    $users[] = $row;
}

// Proses form jika ada aksi yang dikirimkan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'delete' && isset($_POST['user_id'])) {
        $user_id = $_POST['user_id'];
        // Tampilkan peringatan sebelum menghapus pengguna
        echo "<script>
                if(confirm('Are you sure you want to delete this user?')) {
                    window.location.href = 'delete_user.php?id=$user_id';
                }
              </script>";
    } elseif ($_POST['action'] === 'edit' && isset($_POST['user_id'])) {
        $user_id = $_POST['user_id'];
        // Redirect ke halaman edit_user.php dengan membawa parameter user_id
        header("Location: edit_user.php?id=$user_id");
        exit();
    }
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
    <link rel="stylesheet" href="./css/fontawesome.min.css">
    <link rel="stylesheet" href="./css/all.min.css">
    <style>
        /* Tambahkan CSS kustom di sini */
    </style>
</head>
<body class="bg-gray-100">

    <!-- Navbar -->
    <?php  include 'navbar_admin.php';  ?>


    <div class="container mx-auto p-8 ">
        <h2 class="text-2xl font-bold mb-4">User List</h2>

        <!-- Form pencarian -->
        <form class="mb-4">
            <input id="searchInput" type="text" placeholder="Search by name..." class="w-48 sm:w-64 px-2 py-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
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
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
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
                        <td class="px-6 py-4 whitespace-nowrap">
                            <!-- Form Edit dan Delete -->
                            <form method="POST">
                                <?php if ($user['username'] !== $currentAdminUsername) : ?>
                                    <!-- Tombol Edit -->
                                    <button type="submit" name="action" value="edit" class="text-blue-500 hover:text-blue-700 mr-2">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </button>
                                    <!-- Tombol Hapus -->
                                    <button type="submit" name="action" value="delete" class="text-red-500 hover:text-red-700" onclick="return confirm('Are you sure you want to delete this user?');">
                                        <i class="fa-sharp fa-solid fa-trash"></i>
                                    </button>
                                <?php endif; ?>
                                <!-- Hidden input untuk mengirim user_id -->
                                <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
        // Fungsi untuk pencarian
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
