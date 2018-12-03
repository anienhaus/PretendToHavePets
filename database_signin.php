<?php
		// Template that will connect to the database. This is so username and password only has to be changed in one place.
		$servername = "localhost";
		$username = "root"; // CHANGE AS NEEDED
		$password = "rEmk0VutRCIqQ4PN"; // CHANGE AS NEEDED
		$dbname = "php_pets";
		$conn = new mysqli($servername, $username, $password, $dbname);
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		} 
?>