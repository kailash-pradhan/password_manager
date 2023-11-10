<?php
session_start(); // Resume the session

// Check if the user is logged in (session variables are set)
if (isset($_SESSION["user_id"])) {
    // Unset and destroy the session
    session_unset();
    session_destroy();
}

// Redirect the user to the login page
header("Location: index.html");
exit();
?>
