<?php
	$basedir = "../";
	include "../check_session.php";
?>

<!doctype html>

<html lang="en">

<head>
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
		$oldPassword = $_POST["old-password"];
		$newPassword = $_POST["new-password"];
		$newConfirm = $_POST["new-confirm"];
		$userID = $_SESSION["userID"];
		$userQuery = "SELECT Password FROM Users WHERE UserID = $userID";
		$userInfo = $conn->query($userQuery);
		$row = $userInfo->fetch_assoc();
		// If password is correct, change the password
		if ($oldPassword == $row["Password"]) {
			$sql = "UPDATE Users SET Password = '$newPassword' WHERE UserID = $userID";
			$conn->query($sql);
		}
		else {
			// Otherwise, give an error message
			$errMsg = "That password is incorrect!";
		}
	}			
	?>

	<!--Include the navigation bar-->
	<?php 
		$current = "settings";
		include '../navbar.php';
	?>
	<!--Page content-->
	<section>
		<h2>Change Password</h2>
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
					<input type="submit" value="Submit" id="submit-new-password">
				</div>
			</fieldset>
			<div id="change-password-err-msg"><?php echo $errMsg ?></div>
		</form>
	</section>
</body>

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
		
</html>