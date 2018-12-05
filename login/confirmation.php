<?php
	// If logged in, redirect to the index
	session_start();
	$_SESSION['LAST_ACTIVITY'] = $_SERVER['REQUEST_TIME']; 
	if (isset($_SESSION["userID"])) {
		header("Location: ../index.php");
	}
?>

<!doctype html>

<html lang="en">

<head>
	<title>Pretend to Have Pets</title>
	<link rel="stylesheet" href="../pretendtohavepets.css">
	<link rel="stylesheet" href="login.css">
	<meta charset="UTF-8">
	<meta name="assignment" content="CSCI 445: Final Project">
	<meta name="viewport" content="width=device-width">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<link rel="icon" type="image/ico" href="../images/favicon.ico">
</head>

<!--The body of the webpage-->
<body>

	<?php
	// Connect to the database
	include "../database_signin.php";
	$code = "";
	$errMsg = "";
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		// Assign the variables
		$code = test_input($_POST["code"]);

		// Check to see that the code exists
		$codeQuery = "SELECT * FROM Activations WHERE Code = '$code'";
		$codeInfo = $conn->query($codeQuery);
		if ($codeInfo->num_rows == 0) {
			$errMsg = "That activation code is incorrect.";
		}
		else {
			// Get user info
			$row = $codeInfo->fetch_assoc();
			$name = $row["Name"];
			$email = $row["Email"];
			$username = $row["Username"];
			$password = $row["Password"];
			// Add user to Users database
			$insertQuery = "INSERT INTO Users (Name, Email, Username, Password) VALUES ('$name', '$email', '$username', '$password')";
			$conn->query($insertQuery);
			// Delete row from Activations database
			$sql = "DELETE FROM Activations WHERE Code = '$code'";
			$conn->query($sql);
			// Alert the user their account has been activated
			$errMsg = "Your account has been activated.<br><a href='login.php'>Sign In</a>";
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

	<h1>Pretend to Have Pets</h1>
	<!--Page content-->
	<section>
		<h2>Activate Account</h2>
		<p>
			Enter the confirmation code that was emailed to you.<br>
			No confirmation code? <a href="signup.php">Create an Account</a>
		</p>
		<form id="confirm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<fieldset>
				<div id="confirm-content">
					<label for="code">Confirmation Code: </label><br>
					<input type="text" id="code" name="code" value="<?php echo $code ?>" required>
					<br>
					<input type="submit" value="Activate">
				</div>
			</fieldset>
			<div class="err-msg">
				<?php echo $errMsg ?>
			</div>
		</form>
	</section>

</body>

</html>