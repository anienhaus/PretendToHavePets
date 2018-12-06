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
	$name = "";
	$email = "";
	$username = "";
	$password = "";
	$confirmPassword = "";
	$usernameError = "";
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		// Assign the variables
		$name = test_input($_POST["name"]);
		$email = test_input($_POST["email"]);
		$username = test_input($_POST["username"]);
		$password = test_input($_POST["password"]);
		$confirmPassword = test_input($_POST["confirm-password"]);

		// Check to see that the username doesn't already exist
		$userQuery = "SELECT UserID FROM Users WHERE Username = '$username'";
		$userInfo = $conn->query($userQuery);
		if ($userInfo->num_rows != 0) {
			$usernameError = "Sorry, that username is taken.";
		}
		else {
			// Generate activation code
			$code = generate_code();
			// Add to the Activation table
			$insertQuery = "INSERT INTO Activations (Code, Username, Password, Name, Email) VALUES ('$code', '$username', '$password', '$name', '$email')";
			$conn->query($insertQuery);
			// Send confirmation email
			mail($email, "Pretend to Have Pets Signup Confirmation", "Your confirmation code is $code.");
			// Redirect to confirmation page
			header("Location: confirmation.php");
		}
	}	

	// Function to clean data
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}	

	// Function to generate a random seven-character string
	function generate_code() {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$randomString = "";
		for ($i = 0; $i < 7; $i++) {
			$randomString = $randomString . $chars[rand(0, strlen($chars) - 1)];
		}
		return $randomString;
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
					<input type="password" id="password" name="password" onkeyup="checkPasswords()" value="<?php echo $password ?>" required>
					<br>
					<label for="confirm-password">Confirm Password: </label><br>
					<input type="password" id="confirm-password" name="confirm-password" onkeyup="checkPasswords()" value="<?php echo $confirmPassword ?>" required>
					<br>
					<input type="submit" value="Sign Up!" id="submit-login">
				</div>
			</fieldset>
			<div class="err-msg">
				<span id="name-err-msg"></span>
				<span id="email-err-msg"></span>
				<span id="username-err-msg"><?php echo $usernameError ?></span>
				<span id="password-err-msg"></span>
			</div>
		</form>
		<p>Already a member? <a href="login.php">Sign In</a></p>
	</section>

</body>

<script>
	
	// Check if the two typed passwords match, outputting an error message if they don't
	function checkPasswords() {
		if ($("#password").val() != $("#confirm-password").val()) {
			$("#password-err-msg").html("Those passwords don't match!<br>");
			return false;
		}
		else {
			$("#password-err-msg").html("");
			return true;
		}
	}

	// Check that all of the given fields are appropriate
	document.getElementById('signup').addEventListener("submit", function(e) {
		// Check that the two given passwords match
		if (checkPasswords() == false) {
			e.preventDefault();
		}
		// Check that the name is okay
		var pattern = /^[a-zA-Z ']*$/; // Good name
		if (!pattern.test($("#name").val())) {
			$("#name-err-msg").html("Name may only include letters, spaces, and apostrophes.<br>");
			e.preventDefault()
		}
		else {
			$("#name-err-msg").html("");
		}
		// Validate email
		var emailPattern = /[a-zA-z0-9]+@[a-zA-Z0-9](.[a-zA-Z0-9])+/; // Good email regex
		if (!emailPattern.test($("#email").val())) {
			$("#email-err-msg").html("Please enter a valid email address.<br>");
			e.preventDefault();
		}
		else {
			$("#email-err-msg").text("");
		}
		// Validate username
		var usernamePattern = /^[a-zA-Z0-9 '!#$%^&~]*$/; // Good username
		if (!usernamePattern.test($("#username").val())) {
			$("#username-err-msg").html("One of those characters is not allowed in usernames.<br>");
			e.preventDefault()
		}
		else {
			$("#username-err-msg").html("");
		}
	});
		
</script>

</html>