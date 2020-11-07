<!DOCTYPE html>
<!-- html 5 -->
<!-- PROPERTY OF PHILIP OTTENBREIT. © 2019. DO NOT COPY WITHOUT WRITTEN PERMISSION. CONTACT: pko319@uregina.ca.  -->

<html lang="en">

	<head>
		<title>Hey! Register</title>
		<?php include '../html_snippets/default_head.php'; ?>
		<script type="text/javascript" src="../js/login_signup_validate.js"></script> 
	</head>
	
	<body>
		<?php include '../html_snippets/header.php'; ?>
		
		<section>
			<h1>Register</h1>
			<div class=register>
				<div style="width:270px;">
					<form id="login_signup" method="post" action="signup_post.php" enctype="multipart/form-data">
						<p>Email:&nbsp;&nbsp;&nbsp;&nbsp;<input name="email" type="text"></p><br/>
						<label id="signup_email_message" class="error_message"></label>
						<p>Alias:&nbsp;&nbsp;&nbsp;&nbsp;<input name="alias" type="text"></p><br/>
						<label id="signup_alias_message" class="error_message"></label>
						<p>Birthday:&nbsp;<input name="birthday" type="text"></p><br/>
						<label id="signup_birthday_message" class="error_message"></label>
						<p>Password:&nbsp;<input name="password" type="password"></p><br/>
						<label id="signup_password_message" class="error_message"></label>
						<p>Verify:&nbsp;&nbsp;&nbsp;<input name="password2" type="password"></p><br/>
						<label id="signup_password2_message" class="error_message"></label>
						<p>Upload a Profile Picture:</p>
						<input type="file" name="profile_img"><br/><br/>
						<button type="submit">Register</button>
					</form>
					<script type="text/javascript"  src="../js/login_signup_register.js" ></script>
				</div>
			</div>
		</section>
		
		<?php include '../html_snippets/footer.php'; ?>
	</body>
</html>

