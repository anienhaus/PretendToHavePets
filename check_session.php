<?php
	// File with code to set up a session and check if someone is logged in

	if (session_status() == PHP_SESSION_NONE) {
		// Start a new session if it does not exist yet
    session_start();
	}
	if (!isset($_SESSION["userID"])) {
		// If the user is not logged in, redirect to the login page
		$path = $basedir . "login/login.php";
		header("Location: $path");
	}
	else {
		$time = $_SERVER['REQUEST_TIME']; // Current time
		$timeout_duration = 1200; // Amount of time it takes to time out, in seconds
		// Reset if the user has timed out
		if (isset($_SESSION['LAST_ACTIVITY']) && ($time - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
		  // Destroy old session and create new one
		  session_unset();
		  session_destroy();
		  session_start();
		  // Reset last active time
		  $_SESSION['LAST_ACTIVITY'] = $time; 
		  // Redirect to the login page
		  $path = $basedir . "login/login.php";
			header("Location: $path");
		}
		else {
			// Update last usage time
			$_SESSION['LAST_ACTIVITY'] = $time;
		}
	}
?>