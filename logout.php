<?php
session_start();

// Clear session data
session_unset(); // Remove all session variables
session_destroy(); // Destroy the session

// Clear the remember me cookie
if (isset($_COOKIE['remember_me'])) {
  setcookie('remember_me', '', time() - 3600, '/', '', true, true); // Set the cookie's expiration date to the past
}

// Redirect to login page
header("Location: login.php");
exit();
?>
