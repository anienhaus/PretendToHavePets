<?php
	$basedir = "../";
	$current = "adopt";
	include "../check_session.php";
	include "../database_signin.php";
	$query = "SELECT * FROM Species";
	$species = $conn->query($query);
?>

<!doctype html>

<html lang="en">

<head>
	<title>Pretend to Have Pets</title>
	<link rel="stylesheet" href="../pretendtohavepets.css">
	<link rel="stylesheet" href="adopt.css">
	<meta charset="UTF-8">
	<meta name="assignment" content="CSCI 445: Final Project">
	<meta name="viewport" content="width=device-width">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<script>
	function handleSelect() {
		 <?php 
            $images = array();
            while($row = $species->fetch_assoc()) {
                array_push($images, $row['Name'] ,$row['ImagePath']);
            }
        ?>
		var speciesInfo= <?php echo json_encode($images);?>;
		for(var i = 0; i < speciesInfo.length; i += 2) {
            if(speciesInfo[i] == ($("select").find(":selected").val())){
                $("#picture").css({"width": "300px", "height": "260px"}).attr("src", "../" + speciesInfo[i + 1]);
            }
        }
	}
</script>

<!--The body of the webpage-->
<body>
	<!--Include the navigation bar-->
	<?php 
		include '../navbar.php';
		$petName = "";
		$species = "";
		$ownerID = $_SESSION["userID"];
		$err="";

		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$petName = test_input($_POST["petName"]);
			$species = $_POST["species"];

			$sql = "SELECT Name FROM Pets WHERE Owner='$ownerID'";
			$currentPets = $conn->query($sql);
			while($row = $currentPets->fetch_assoc()){
				if($row['Name'] == $petName) {
					$err = "You already have a pet with this name!";
				}
			}

			if($err == ""){
				$sql = "SELECT SpeciesID FROM Species WHERE Name='$species'";
				$speciesFromTable = $conn->query($sql);
				$row = mysqli_fetch_assoc($speciesFromTable);
				$speciesID = $row['SpeciesID'];

				$sql = "INSERT INTO Pets (Owner, Name, Species, HealthLevel, LastWalked, HungerLevel, LastFed, EnergyLevel, LastNap) VALUES 
					('$ownerID', '$petName', '$speciesID', 100, 100, 100, 100, 100, 100)";
				$conn->query($sql);
				header("Location: " . $basedir);
			}
		}

		// Function to clean data
		function test_input($data) {
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}	
	?>
	<!--Page content-->
	<section>
		<h2 class="page_title">Pick a Pet</h2>
		<img id="picture" style="width: 0; height:0;">
		<div class="adopt_options"><div>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
		<fieldset id="speciesSelect">
			<p id="species_label">Pet Species<br></p>
			<select id="species" name="species" onChange="handleSelect();" required>
				<option disabled selected value>Pet Options</option>
				<?php 
					$species = $conn->query($query);
					if($species->num_rows == 0){
						echo "No species found";
					}
					else{
						echo $species->num_rows;
					}
					while($row = $species->fetch_assoc()){
						echo "<option value='" . $row['Name'] . "'>" . $row['Name'] . "</option>";
					}
				?>	
			</select>
		</fieldset>
		<fieldset id="petInfo">
			<!-- <legend>Pet Info</legend> -->
			<p id="name_label">What's their name? <br></p>
				<input type="text" name="petName" id="petName" required>*
			<?php echo $err;?>
		</fieldset>
	<input id="submit" class="submit" type="submit">
	</form>
	</section>
</body>

</html>