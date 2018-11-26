<!doctype html>

<html lang="en">

<head>
	<title>Pretend to Have Pets</title>
	<link rel="stylesheet" href="../pretendtohavepets.css">
	<link rel="stylesheet" href="login.css">
	<meta charset="UTF-8">
	<meta name="assignment" content="CSCI 445: Final Project">
	<meta name="viewport" content="width=device-width">
</head>

<!--The body of the webpage-->
<body>

	<?php
		// Connect to the database
		include "database_signin.php";
		$errMsg = "";
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			// Check to see that the username exists
			// If it exists, check that the password is correct
			// If both are correct, log in
			$errMsg = "Error!";
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
					<input type="text" id="username" name="username" required>
					<br>
					<label for="password">Password: </label><br>
					<input type="password" id="password" name="password" required>
					<br>
					<input type="submit" value="Log In" id="submit-login">
				</div>
			</fieldset>
			<div id="login-err-msg"><?php echo $errMsg ?></div>
		</form>
	</section>

</body>

</html>