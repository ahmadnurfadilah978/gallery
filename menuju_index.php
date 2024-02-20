
<?php
session_start();

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $nama = isset($_SESSION['nama']) ? $_SESSION['nama'] : '';
    header("Location: login.php"); // Assuming you want to redirect to "dashboard.php" when the session is set
    exit(); // Ensure that the script stops executing after the redirection
} else {
    header("Location: login.php"); // Redirect to "login.php" if the session is not set
    exit();
}
?>

