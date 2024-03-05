<script src="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css"></script>

<div class="navbar  bg-white text-black p-4">
        <div class="flex items-center">
            <span class="text-lg font-bold">Welcome, <?php echo $_SESSION['username']; ?>!</span>
            <a href="admin_dashboard.php" class="hover:text-gray-400 ml-7">Home</a>
            <a href="data_pengguna.php" class=" hover:text-gray-400 ml-4">Users</a>
            <a href="albums.php" class="hover:text-gray-400 ml-4">Albums</a>
            <a href="fotoadmin.php" class="hover:text-gray-400 ml-4">Foto</a>
            <div class="ml-auto">
                <a href="#" onclick="confirmLogout()" class="bg-indigo-500 text-white px-4 py-2 rounded-md hover:bg-indigo-600">Logout</a>
            </div>
        </div>
    </div>

    <script>
        function confirmLogout() {
            if (confirm('Are you sure you want to log out?')) {
                window.location.href = 'index.php';
            }
        }
    </script>