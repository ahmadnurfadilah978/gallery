<div class="flex justify-between items-center bg-blue-500 p-4">
    <h2 class="text-white text-lg font-bold">Selamat Datang, <?php echo $_SESSION['username']; ?>!</h2>
    <div class="flex space-x-4 relative">
        <a href="dashboard.php" class="text-white hover:bg-blue-600 px-4 py-2 rounded transition duration-300">Home</a>
        <a href="albums_user.php" class="text-white hover:bg-blue-600 px-4 py-2 rounded transition duration-300">Album</a>
        <a href="upload.php" class="text-white hover:bg-blue-600 px-4 py-2 rounded transition duration-300">Foto</a>
        <div class="relative">
            <button id="profileBtn" class="text-white hover:bg-blue-600 px-4 py-2 rounded transition duration-300">Profile</button>
            <div id="profileDropdown" class="absolute hidden bg-white border border-gray-200 z-10 right-0 mt-4 rounded shadow-md w-40">
                <a href="profile.php" class="block px-4 py-2 hover:bg-gray-100 transition duration-300">Edit Profile</a>
                <a href="#" onclick="confirmLogout()" class="block px-4 py-2 hover:bg-gray-100 transition duration-300">Logout</a>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmLogout() {
        if (confirm('Apakah Anda yakin ingin logout?')) {
            window.location.href = 'index.php';
        }
    }

    document.addEventListener("DOMContentLoaded", function(){
        document.getElementById('profileBtn').addEventListener('click', function(){
            document.getElementById('profileDropdown').classList.toggle('hidden');
        });
    });
</script>
