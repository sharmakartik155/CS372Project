<div class="w3-bar theme-dark-primary">
<?php if (!isset($_SESSION["email"]) || !$_SESSION["email"]) { ?>
	<a href="../pages/demo.php"><img src="../assets/logo.png" class="w3-bar-item w3-hover-opacity" style="width:70px; height:auto;"></a>
	<div class="w3-bar-item bar-font-size noselect">OutlineR</div>
	<a href="../pages/login.php" class="w3-bar-item bar-font-size w3-button w3-right">Login</a>
	<a href="../pages/register.php" class="w3-bar-item bar-font-size w3-button w3-right">Register</a>
<?php } else { ?>
	<a href="../pages/docs.php"><img src="../assets/logo.png" class="w3-bar-item w3-hover-opacity" style="width:70px; height:auto;"></a>
	<div class="w3-bar-item bar-font-size noselect">OutlineR</div>
	<a href="../snippets/logout.php" class="w3-bar-item bar-font-size w3-button w3-right">Logout</a>
	
<?php if ($_SERVER['PHP_SELF'] == "/~soren200/pages/docs.php") { ?>
	<a href="../pages/settings.php" class="w3-bar-item bar-font-size w3-button w3-right">Settings</a>
<?php } else { ?>
	<a href="../pages/docs.php" class="w3-bar-item bar-font-size w3-button w3-right">My Docs</a>

<?php } }?>
</div>
