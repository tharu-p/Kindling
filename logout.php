<?php
session_start();

// Destroy the session
session_destroy();

// Redirect to the login page (or wherever you want to redirect after logout)
header("Location: home.php"); // Or header("Location: home.php"); if you want to redirect to the home page
exit();
?>