<header>
	<h1>Pretend to Have Pets</h1>
</header>
<nav>
	<a href="<?php echo $basedir ?>index.php" class="<?php if ($current == "index") echo 'active' ?>">My Pets</a>
	<a href="<?php echo $basedir ?>adopt/adopt.php" class="<?php if ($current == "adopt") echo 'active' ?>">Adopt a Pet</a>
	<a href="<?php echo $basedir ?>settings/settings.php" class="<?php if ($current == "settings") echo 'active' ?>">Change Password</a>
	<a href="#">Log Out</a>
</nav>