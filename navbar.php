<header>
	<h1>Pretend to Have Pets</h1>
</header>
<nav>
	<a href="<?php echo $basedir ?>index.php" class="<?php if ($current == "index") echo 'active' ?>">My Pets</a>
	<a href="<?php echo $basedir ?>adopt/adopt.php" class="<?php if ($current == "adopt") echo 'active' ?>">Adopt a Pet</a>
	<a href="<?php echo $basedir ?>settings/settings.php" class="<?php if ($current == "settings") echo 'active' ?>">Change Password</a>
	<a id="logout" href="#" onclick="logout('<?php echo $basedir ?>')">Log Out</a>
</nav>

<script>
	// Redirects to a PHP script that will perform logout functions
	function logout(basedir) {
		alert("You will now be logged out.");
		document.location.href = basedir + "login/logout.php";
	}
</script>