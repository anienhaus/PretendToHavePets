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
<body>

	<?php
	// Connect to the database
	include "../database_signin.php";
	$errMsg = "";
	$name = "";
	$email = "";
	$username = "";
	$password = "";
	$confirmPassword = "";
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		// Check to see that the username exists
		$name = $_POST["name"];
		$email = $_POST["email"];
		$username = $_POST["username"];
		$password = $_POST["password"];
		$confirmPassword = $_POST["confirm-password"];
	}			
	?>

	<h1>Pretend to Have Pets</h1>
	<!--Page content-->
	<section>
		<h2>Sign Up</h2>
		<form id="signup" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<fieldset>
				<div id="login-content">
					<label for="name">First Name: </label><br>
					<input type="text" id="name" name="name" value="<?php echo $name ?>" required>
					<br>
					<label for="email">Email: </label><br>
					<input type="text" id="email" name="email" value="<?php echo $email ?>" required>
					<br>
					<label for="username">Username: </label><br>
					<input type="text" id="username" name="username" value="<?php echo $username ?>" required>
					<br>
					<label for="password">Password: </label><br>
					<input type="password" id="password" name="password" value="<?php echo $password ?>" required>
					<br>
					<label for="confirm-password">Confirm Password: </label><br>
					<input type="password" id="confirm-password" name="confirm-password" value="<?php echo $confirmPassword ?>" required>
					<br>
					<input type="submit" value="Sign Up!" id="submit-login">
				</div>
			</fieldset>
			<div id="signup-err-msg"><?php echo $errMsg ?></div>
		</form>
		<p>Already a member? <a href="login.php">Sign In</a></p>
	</section>

</body>

</html>