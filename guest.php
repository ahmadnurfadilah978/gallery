<?php
// guest.php

// Include the connection file
require_once('koneksi.php');

// Start the session
session_start();

// Check if the user is a guest
if (isset($_SESSION['username'])) {
    // Redirect logged-in users to a different page
    header("Location: home.php");
    exit();
}

// Your HTML and content for the guest page
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Guest Account</title>
    <!-- Include your CSS stylesheets if needed -->
</head>
<body>
    <div class="navbar">
        <h2>Welcome, Guest!</h2>
        <!-- Add links or other navigation elements for the guest page -->
        <a href="home.php">Home</a>
        <a href="about.php">About</a>
        <a href="contact.php">Contact</a>
        <a href="login.php">Login</a>
    </div>

    <div class="content">
        <!-- Your content for the guest page -->
        <h1>Guest Account Page</h1>
        <p>This is the guest account page content.</p>
        <p>Feel free to explore our website!</p>
    </div>

    <div class="footer">
        <p>© 2023 My Website</p>
    </div>
</body>
</html>
