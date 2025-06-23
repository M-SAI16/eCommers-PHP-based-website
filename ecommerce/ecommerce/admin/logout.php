<?php
session_start(); // Start the session
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session
header("Location: login.php"); // Redirect to the admin login page
exit(); // Ensure no further code executes
?>