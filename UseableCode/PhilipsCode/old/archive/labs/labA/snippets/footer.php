<footer>
			<div class=nav>
				<h3><a href="index.php"> Homepage </a></h3>
				<h3><a href="q_view.php"> Random Question </a></h3>
<?php if (isset($_SESSION["email"]) && $_SESSION["email"]) { ?>
				<h3><a href="q_manage.php"> Manage Account </a></h3>
				<h3><a href="q_create.php"> Create Question </a></h3>
<?php } else { ?>
				<h3><a href="login.php"> Login </a></h3>
				<h3><a href="signup.php"> Register </a></h3>
<?php } ?>
			</div>
		</footer>
