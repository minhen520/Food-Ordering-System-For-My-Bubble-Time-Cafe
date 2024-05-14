<?php
session_start();
unset($_SESSION['latest_b']); // Unset the session variable
unset($_SESSION['latest_t']); // Unset the session variable
header("Location: ../posBackend/posTable.php"); // Redirect the user to the desired page
exit;
?>