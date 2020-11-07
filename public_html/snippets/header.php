		<header>
			<div class="w3-bar w3-dark-grey noselect">
	        <a href="demo.php"><img src="logo.png" class="w3-bar-item w3-hover-opacity" style="width:70px; height:auto;"></a>
	        <div class="w3-bar-item bar-font-size">OutlineR</div>
	        <a href="register.php" class="w3-bar-item bar-font-size w3-button w3-right">Register</a>
	        <a href="login.php" class="w3-bar-item bar-font-size w3-button w3-right">Login</a>
	    </div>
<?php if (isset($_SESSION["email"]) && $_SESSION["email"]) { ?>

	<a href="../snippets/logout.php" class="w3-bar-item bar-font-size w3-button w3-right">Logout</a>
	<a href="../pages/docs.php" class="w3-bar-item bar-font-size w3-button w3-right">My Docs</a>

<?php } else { ?>

	<a href="../pages/register.php" class="w3-bar-item bar-font-size w3-button w3-right">Register</a>
	<a href="../pages/login.php" class="w3-bar-item bar-font-size w3-button w3-right">Login</a>

<?php	} ?>
		</header>
