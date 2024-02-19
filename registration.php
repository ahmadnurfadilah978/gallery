<?php
require('koneksi.php');

// Jika formulir dikirimkan, masukkan nilai ke dalam database.
if (isset($_REQUEST['username'])) {
    // Menghapus karakter backslashes
    $nama = stripslashes($_REQUEST['name']);
    $nama = mysqli_real_escape_string($conn, $nama);
    $username = stripslashes($_REQUEST['username']);
    // Melakukan escape karakter khusus dalam sebuah string
    $username = mysqli_real_escape_string($conn, $username);
    $email = stripslashes($_REQUEST['email']);
    $email = mysqli_real_escape_string($conn, $email);
    $password = stripslashes($_REQUEST['password']);
    $password = mysqli_real_escape_string($conn, $password);
    $trn_date = date("Y-m-d H:i:s");

    // Periksa apakah nama pengguna sudah ada
    $check_query = "SELECT * FROM `users` WHERE `username`='$username'";
    $check_result = mysqli_query($conn, $check_query);
    if (mysqli_num_rows($check_result) > 0) {
        // Jika nama pengguna sudah ada, tampilkan pesan kesalahan
        echo "<div class='form'>
            <h3>Pendaftaran Gagal. Username sudah ada.</h3>
            <br/>Klik di sini untuk <a href='registration.php'>coba lagi</a></div>";
    } else {
        // Jika nama pengguna belum ada, lanjutkan dengan pendaftaran
        $query = "INSERT into `users` (nama, username, password, email)
            VALUES ('$nama','$username', '".md5($password)."', '$email')";
        $result = mysqli_query($conn, $query);
        if ($result) {
            echo "<div class='form'>
            <h3>Anda berhasil terdaftar.</h3>
            <br/>Klik di sini untuk <a href='login.php'>Login</a></div>";
        } else {
            echo "<div class='form'>
            <h3>Pendaftaran Gagal. Silakan coba lagi nanti.</h3>
            <br/>Klik di sini untuk <a href='registration.php'>coba lagi</a></div>";
        }
    }
} else {
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pendaftaran</title>
    <!-- Tambahkan link ke file CSS Tailwind -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Link ke file CSS kustom Anda -->
    <style>
        .form {
            margin-top: 8rem;
            max-width: 30rem;
            margin-left: auto;
            margin-right: auto;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form h1 {
            font-size: 1.875rem;
            margin-bottom: 1rem;
        }

        .form input[type="text"],
        .form input[type="email"],
        .form input[type="password"],
        .form input[type="submit"] {
            width: 100%;
            margin-bottom: 1rem;
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
        }

        .form input[type="submit"] {
            background-color: #3b82f6;
            color: #fff;
            transition: background-color 0.3s ease;
            cursor: pointer;
        }

        .form input[type="submit"]:hover {
            background-color: #2563eb;
        }
    </style>
</head>
<body>
<div class="form">
    <h1 class="text-3xl mb-4">Pendaftaran</h1>
    <form name="registration" action="" method="post">
        <input type="text" name="nama" placeholder="Nama" class="block w-full rounded-md border-gray-300 shadow-sm mb-2" required />
        <input type="text" name="username" placeholder="Username" class="block w-full rounded-md border-gray-300 shadow-sm mb-2" required />
        <input type="email" name="email" placeholder="Email" class="block w-full rounded-md border-gray-300 shadow-sm mb-2" required />
        <input type="password" name="password" placeholder="Password" class="block w-full rounded-md border-gray-300 shadow-sm mb-2" required />
        <input type="submit" name="submit" value="Daftar" class="block w-full bg-blue-500 text-white rounded-md py-2 px-4 hover:bg-blue-600" />
    </form>
</div>
</body>
</html>
<?php } ?>
