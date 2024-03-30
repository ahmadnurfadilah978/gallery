<script src="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css"></script>

<div class="navbar  bg-white text-black p-4">
        <div class="flex items-center">
            <span class="text-lg font-bold">Welcome, <?php echo $_SESSION['username']; ?>!</span>
            <a href="admin_dashboard.php" class="ml-4 text-black-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Home</a>
            <a href="data_pengguna.php" class=" ml-4 text-black-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Users</a>
            <a href="albums.php" class="ml-4 text-black-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Albums</a>
            <a href="fotoadmin.php" class="ml-4 text-black-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Foto</a>
            <div class="ml-auto">
                <a href="#" onclick="confirmLogout()" class=" text-black-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Logout</a>
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