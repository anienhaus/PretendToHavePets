<?php 
// Destroy old session and create new one
session_unset();
session_destroy();
session_start();
// Reset last active time
$_SESSION['LAST_ACTIVITY'] = $time; 
// Redirect to the login page
header("Location: login.php");
?>