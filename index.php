<?php
$basedir = "";
include "check_session.php";
?>

<!doctype html>

<html lang="en">

<head>
	<title>Pretend to Have Pets</title>
	<link rel="stylesheet" href="pretendtohavepets.css">
	<meta charset="UTF-8">
	<meta name="assignment" content="CSCI 445: Final Project">
	<meta name="viewport" content="width=device-width">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<!--The body of the webpage-->
<body>
	<!--Include the navigation bar-->
	<?php 
		$current = "index";
		include 'navbar.php';
	?>
	<!--Connect to the database-->
	<?php
		include "database_signin.php";
	?>
	<!--Page content-->
	<section>
		<?php
			// Get necessary info
			$userQuery = "SELECT Name FROM Users WHERE UserID = '" . $_SESSION["userID"] . "'";
			$userInfo = $conn->query($userQuery);
			$row = $userInfo->fetch_assoc();
			$usersName = $row["Name"];
		?>
		<h2><?php echo $usersName ?>'s Pets</h2>
		<p>Display list of pets linking to the pet's page</p>
	</section>
</body>

</html>