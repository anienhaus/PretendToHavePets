<?php
	// If logged in, redirect to the index
	session_start();
	$_SESSION['LAST_ACTIVITY'] = $_SERVER['REQUEST_TIME']; 
	if (isset($_SESSION["userID"])) {
		header("Location: ../index.php");
	}
	$current="resetPassword";
	include "../check_session.php";
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
<body class="main">

	<?php
	// Connect to the database
	include "../database_signin.php";
	$errMsg = "";
	$username = "";
	$password = "";
	$confirmPassword = "";
	$code = "";
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		// Check to see that the username exists
		$username = test_input($_POST["username"]);
		$code = test_input($_POST["code"]);
		$password = test_input($_POST["password"]);
		$confirmPassword = test_input($_POST["confirm-password"]);
		$userQuery = "SELECT UserID FROM Users WHERE Username = '$username'";
		$userInfo = $conn->query($userQuery);
		if ($userInfo->num_rows == 0) {
			$errMsg = "This username is not recognized.";
		}
		else {
			// Check that the username has a reset code
			$row = $userInfo->fetch_assoc();
			$userID = $row["UserID"];
			$resetQuery = "SELECT UserID, Code FROM ResetCodes WHERE UserID = $userID";
			$resetInfo = $conn->query($resetQuery);
			if ($resetInfo->num_rows == 0) {
				$errMsg = "This username has not requested a reset code. <br>Please request a reset code.";
			}
			else {
				// Check that the reset code is correct
				$row = $resetInfo->fetch_assoc();
				$correctCode = $row["Code"];
				if ($correctCode != $code) {
					$errMsg = "That reset code is incorrect.";
				}
				else {
					// Reset the password
					$sql = "UPDATE Users SET Password = '$password' WHERE UserID = $userID";
					$conn->query($sql);
					$errMsg = "Your password has been changed.<br><a href='login.php'>Sign In</a>";
					// Remove this user from the request password database
					$sql = "DELETE FROM ResetCodes WHERE UserID = $userID";
					$conn->query($sql);
				}
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
		<h2>Reset Password</h2>
		<p>Please enter the password reset code that was emailed to you.<br>
		Didn't receive a code? <a href="forgot_password.php">Request a Code</a></p>
		<form id="reset-password" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<fieldset>
				<div id="reset-content">
					<label for="username">Username: </label><br>
					<input type="text" id="username" name="username" value="<?php echo $username ?>" required>
					<br>
					<label for="code">Reset Code: </label><br>
					<input type="text" id="code" name="code" value="<?php echo $code ?>" required>
					<br>
					<label for="password">Password: </label><br>
					<input type="password" id="password" name="password" onkeyup="checkPasswords()" value="<?php echo $password ?>" required>
					<br>
					<label for="confirm-password">Confirm Password: </label><br>
					<input type="password" id="confirm-password" name="confirm-password" onkeyup="checkPasswords()" value="<?php echo $confirmPassword ?>" required>
					<br>
					<input type="submit" value="Reset Password" id="submit-login">
				</div>
			</fieldset>
			<div class="err-msg"><?php echo $errMsg ?>
				<span id="password-err-msg"></span>
			</div>
		</form>
	</section>

</body>

<script>

	// Check if the two typed passwords match, outputting an error message if they don't
	function checkPasswords() {
		if ($("#password").val() != $("#confirm-password").val()) {
			$("#password-err-msg").html("Those passwords don't match!");
			return false;
		}
		else {
			$("#password-err-msg").html("");
			return true;
		}
	}
		
</script>

</html>