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
	$email = "";
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		// Check to see that the email exists
		$email = test_input($_POST["email"]);
		$userQuery = "SELECT UserID FROM Users WHERE Email = '$email'";
		$userInfo = $conn->query($userQuery);
		if ($userInfo->num_rows == 0) {
			$errMsg = "This email is not attatched to an account.";
		}
		// If it exists, create reset code and send an email with it
		else {
			// Get the user ID
			$row = $userInfo->fetch_assoc();
			$userID = $row["UserID"];
			// Generate random string for resetting password
			$resetCode = generate_password();
			// Add it to the database
			$insertQuery = "INSERT INTO ResetCodes (UserID, Code) VALUES ($userID, '$resetCode')";
			$conn->query($insertQuery);
			// Send email with reset code
			// TODO: Test this!
			mail("$email", "Your Password Reset Code", "Your password reset code is $resetCode.");
			// Redirect to reset page
			header("Location: password_reset.php");
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

	// Function to generate a random 15-character string
	function generate_password() {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$randomString = "";
		for ($i = 0; $i < 15; $i++) {
			$randomString = $randomString . $chars[rand(0, strlen($chars) - 1)];
		}
		return $randomString;
	}

	?>

	<h1>Pretend to Have Pets</h1>
	<!--Page content-->
	<section>
		<h2>Forgot Password</h2>
		<p>Please enter your email.<br>
		An email will be sent with a new password.</p>
		<form id="forgot-password" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<fieldset>
				<div id="forgot-password-content">
					<label for="email">Email: </label><br>
					<input type="text" id="email" name="email" value="<?php echo $email ?>" required>
					<br>
					<input id="submit" type="submit" value="Send" id="submit-login">
				</div>
			</fieldset>
			<div class="err-msg" id="err-msg"><?php echo $errMsg ?></div>
		</form>
		<p>Wait! <a href="login.php">I suddenly remembered my password!</a></p>
	</section>

</body>

<script>

	// Check that all of the given fields are appropriate
	document.getElementById('forgot-password').addEventListener("submit", function(e) {
		// Validate email
		var emailPattern = /[a-zA-z0-9]+@[a-zA-Z0-9](.[a-zA-Z0-9])+/; // Good email regex
		if (!emailPattern.test($("#email").val())) {
			$("#err-msg").html("Please enter a valid email address.");
			e.preventDefault();
		}
		else {
			$("#err-msg").text("");
		}
	});
		
</script>

</html>