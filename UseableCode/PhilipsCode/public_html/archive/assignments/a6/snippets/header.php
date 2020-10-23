		<header>
			<h1 class="title">Hey! Q&amp;A</h1>
<?php if (isset($_SESSION["email"]) && $_SESSION["email"]) { ?>
			<div id="header_0" class="header_right">
				<form method="post" action="../snippets/logout.php">
					<button class="button" type="submit">Logout</button>
				</form>
			</div>
			<div id="header_1" class="header_right hide_phone" style="margin-top:15px;">
				<label id="logged_in_message">Welcome, <?=$_SESSION["alias"]?></label>
			</div>
<?php } else { ?>			
			<div id="header_4" class="header_right hide_tiny">
				<form method="post" action="signup.php">
					<button class="button" type="submit">Register</button>
				</form>
			</div>
			<div id="header_3" class="header_right header_mobile">
				<form method="post" action="login.php">
					<button class="button" type="submit">Login</button>
				</form>
			</div>
			<div id="header_2" class="header_right header_desktop">
				<form method="post" action="login.php" id="login_header">
					<p>Email:&nbsp;</p><input size="20" name="email" type="text">
					<p>&nbsp;</p>
					<p>Password:&nbsp;</p><input size="20" name="pswrd" type="password">
					<p>&nbsp;</p>
					<button class="button" type="submit">Login</button>
					<script type="text/javascript" src="../js/validate_login_header.js"></script>
					<script type="text/javascript" src="../js/register_login_header.js"></script>
				</form>
			</div>
		<?php	} ?>
		</header>
