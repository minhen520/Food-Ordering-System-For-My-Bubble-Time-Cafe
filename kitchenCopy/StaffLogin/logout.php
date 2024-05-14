<?php
// Start the session
session_start();

// Unset or destroy the session variables
unset($_SESSION['logged_kitchen_id']);
unset($_SESSION['logged_kitchen_name']);


// Redirect the user to the home page
header("Location: login.php"); // Change "home.php" to your desired destination
exit();
?>