<?php
session_start(); // Start the session

// Destroy all session data
session_unset();
session_destroy();

// Optional: Redirect to login page or homepage
header("Location: ../../../index.php");
exit();
?>
