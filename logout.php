<?php
session_destroy();
session_unset();// Redirecting To Home Page
header("Location:dashboard_guest.php");
?> 