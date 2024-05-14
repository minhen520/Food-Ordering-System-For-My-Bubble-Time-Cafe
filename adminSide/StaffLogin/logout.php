<?php
// Start the session
session_start();

// Unset or destroy the session variables
unset($_SESSION['logged_account_id']);
unset($_SESSION['logged_staff_name']);


// Redirect the user to the home page
header("Location: login.php"); 
exit();
?>