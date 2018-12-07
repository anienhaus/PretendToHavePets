<!doctype html>
<html lang="en">


<head>
<?php
	$basedir = "../";
	$current="settings";
	include "../check_session.php";
?>
	<title>Pretend to Have Pets</title>
	<link rel="stylesheet" href="../pretendtohavepets.css">
	<link rel="stylesheet" href="settings.css">
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
	$oldPassword = "";
	$newPassword = "";
	$newConfirm = "";
	$errMsg = "";
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		// Check to see that the password is correct
		$oldPassword = test_input($_POST["old-password"]);
		$newPassword = test_input($_POST["new-password"]);
		$newConfirm = test_input($_POST["new-confirm"]);
		$userID = test_input($_SESSION["userID"]);
		$userQuery = "SELECT Password, Email FROM Users WHERE UserID = $userID";
		$userInfo = $conn->query($userQuery);
		$row = $userInfo->fetch_assoc();
		// If password is correct, change the password
		if ($oldPassword == $row["Password"]) {
			$sql = "UPDATE Users SET Password = '$newPassword' WHERE UserID = $userID";
			$conn->query($sql);
			$errMsg = "Your password has been changed.";
		}
		else {
			// Otherwise, give an error message
			$errMsg = "That password is incorrect!";
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

	<!--Include the navigation bar-->
	<?php 
		$current = "settings";
		include '../navbar.php';
	?>
	<!--Page content-->
	<section>
		<h2 class="page_title">Change Password</h2>
		<form id="change-password" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<fieldset>
				<div id="new-password-content">
					<label for="old-password">Current Password: </label><br>
					<input type="password" id="old-password" name="old-password" value="<?php echo $oldPassword ?>" required>
					<br>
					<label for="new-password">New Password: </label><br>
					<input type="password" id="new-password" name="new-password" onkeyup="checkPasswords()" value="<?php echo $newPassword ?>" required>
					<br>
					<label for="new-confirm">Confirm New Password: </label><br>
					<input type="password" id="new-confirm" name="new-confirm" onkeyup="checkPasswords()" value="<?php echo $newConfirm ?>" required>
					<br>
					<input id="submit" type="submit" value="Submit">
				</div>
			</fieldset>
			<div class="err-msg" id="change-password-err-msg"><?php echo $errMsg ?></div>
		</form>
	</section>
<script>
	
	// Check if the two typed passwords match, outputting an error message if they don't
	function checkPasswords() {
		if ($("#new-confirm").val() != $("#new-password").val()) {
			$("#change-password-err-msg").html("Those passwords don't match!");
			return false;
		}
		else {
			$("#change-password-err-msg").html("");
			return true;
		}
	}

	document.getElementById('change-password').addEventListener("submit", function(e) {
		if (checkPasswords() == false) {
			e.preventDefault();
		}
	});
		
</script>
</body>

		
</html>