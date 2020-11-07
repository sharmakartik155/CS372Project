<header>
	<h1 class="title">Hey! Q&A</h1>
	
	<div class="login">
		<form method="post" action="signup.php">
			<button class="button" type="submit">Register</button>
		</form>
	</div>
	
	<form id="login_header" method="post">
		<div class="login">
			<p>Email:&nbsp;</p><input size="20" name="email" type="text">
			<p>&nbsp;</p>
			<p>Password:&nbsp;</p><input size="20" name="password" type="password">
			<p>&nbsp;</p>
			<button class=button type="submit">Login</button>
		</div>
		<div id="header_login_messages" class="login" style="clear:both;">
			<label id="email_message" class="error_message"></label>
			<label id="password_message" class="error_message"></label>
		</div>
	</form>
	<script type = "text/javascript"  src = "../js/login_header_register.js" ></script>
</header>
