<?php
    session_start();
    session_unset(); // Remove all session variables
    session_destroy(); // Destroy the session
    header("Location: AdminAccess.php"); // Redirect to main page
    exit;
?>
