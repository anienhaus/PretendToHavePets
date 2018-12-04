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
</head>

<!--The body of the webpage-->
<body class="login-pages">

	<?php
	// Connect to the database
	include "../database_signin.php";
	$errMsg = "";
	$username = "";
	$password = "";
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		// Check to see that the username exists
		$username = test_input($_POST["username"]);
		$password = test_input($_POST["password"]);
		$userQuery = "SELECT UserID, Password FROM Users WHERE Username = '$username'";
		//$stmt = $conn->prepare($userQuery);
		//$stmt->bind_param("s", $username);
		$userInfo = $conn->query($userQuery);
		if ($userInfo->num_rows == 0) {
			$errMsg = "Username not recognized. Have you created an account?";
		}
		// If it exists, check that the password is correct
		else {
			$row = $userInfo->fetch_assoc();
			$correctPassword = $row["Password"];
			// If both are correct, log in
			if ($password == $correctPassword) {
				// Set up session and sign in
				$_SESSION["userID"] = $row["UserID"];
				header("Location: ../index.php");
			}
			else {
				$errMsg = "Incorrect password.";
			}
		}
	}	

	$conn->close();

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
		<h2>Sign In</h2>
		<form id="login" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<fieldset>
				<div id="login-content">
					<label for="username">Username: </label><br>
					<input type="text" id="username" name="username" value="<?php echo $username ?>" required>
					<br>
					<label for="password">Password: </label><br>
					<input type="password" id="password" name="password" value="<?php echo $password ?>" required>
					<br>
					<input id="submit" type="submit" value="Log In" id="submit-login">
				</div>
			</fieldset>
			<div class="err-msg"><?php echo $errMsg ?></div>
		</form>
		<p>Not a member? <a href="signup.php">Sign Up!</a></p>
		<p><a href="forgot_password.php">I forgot my password!</a></p>
	</section>

</body>

</html>