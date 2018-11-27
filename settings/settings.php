<?php
	$basedir = "../";
	include "../check_session.php";
?>

<!doctype html>

<html lang="en">

<head>
	<title>Pretend to Have Pets</title>
	<link rel="stylesheet" href="../pretendtohavepets.css">
	<meta charset="UTF-8">
	<meta name="assignment" content="CSCI 445: Final Project">
	<meta name="viewport" content="width=device-width">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<!--The body of the webpage-->
<body>
	<!--Include the navigation bar-->
	<?php 
		$current = "settings";
		include '../navbar.php';
	?>
	<!--Page content-->
	<section>
		<h2>Change Password</h2>
		<p>Change Password Here</p>
	</section>
</body>

</html>