<?php
$basedir = "/PretendToHavePets/";
$current = "index";
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
		<div id="pets">
			<?php 
				$userID = $_SESSION["userID"];
				$sql = "SELECT * FROM Pets WHERE Owner='$userID'";
				$petInfo = $conn->query($sql);

				while($row = $petInfo->fetch_assoc()) {
					$species = $row['Species'];
					$sql = "SELECT ImagePath FROM Species WHERE SpeciesID='$species'";
					$speciesInfo = $conn->query($sql);
					$sRow = $speciesInfo->fetch_assoc();
					$imagePath = $sRow['ImagePath'];

					echo "<div class='petSquare'>";
					echo "<p class='petName'>" . $row['Name'] . "</p>";
					echo "<img id='picture' style='width: 300; height: 260;' src='" . $imagePath . "'>";
					echo "<div class='petStats'>";
					echo "<p class='stats'>Health: " . $row['HealthLevel'] . "</p>";
					echo "<p class='stats'>Hunger: " . $row['HungerLevel'] . "</p>";
					echo "<p class='stats'>Energy: " . $row['EnergyLevel'] . "</p>";
					echo "</div>";
					echo "</div>";
				}
			?>
		</div>
	</section>
</body>

</html>