<?php
session_start();

// Destroy all session data
session_unset();
session_destroy();

// Prevent browser caching of the login page
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

// Redirect to the login page
header("Location: login.php?error=session_expired");
exit;
?>
