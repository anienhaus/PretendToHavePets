<!doctype html>

<html lang="en">

<head>
	<title>Pretend to Have Pets</title>
	<link rel="stylesheet" href="pretendtohavepets.css">
	<meta charset="UTF-8">
	<meta name="assignment" content="CSCI 445: Final Project">
	<meta name="viewport" content="width=device-width">
</head>

<!--The body of the webpage-->
<body>
	<!--Include the navigation bar-->
	<?php 
		$current = "index";
		$basedir = "";
		include 'navbar.php';
	?>
	<!--Connect to the database-->
	<?php
		include "database_signin.php";
	?>
	<!--Page content-->
	<section>
		<h2>(Name)'s Pets</h2>
		<p>Display list of pets linking to the pet's page</p>
	</section>
</body>

</html>