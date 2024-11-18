<?php
session_start();

// Check if the user is not authenticated
if(!isset($_SESSION['authenticated']))
{
    $_SESSION['status'] = "Please login to access the dashboard";
    header("Location: login.php");
    exit(0);  // Ensure no further code runs
}
?>
