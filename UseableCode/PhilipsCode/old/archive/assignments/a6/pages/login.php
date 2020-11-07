<?php session_start(); ?>
<?php	if (isset($_SESSION["email"]) && $_SESSION["email"]) { header("Location: account.php"); exit(); } ?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Login</title><script type="text/javascript" src="../js/validate_login_main.js"></script> 
<?php include '../snippets/head.php'; ?>
	</head>
	<body>
<?php include '../snippets/header.php'; ?>



<?php //IF INPUT VALIDATES, SET SESSION VARIABLES, REDIRECT
	$email = "";
	$pswrd = "";
	if (isset($_POST["email"]) && $_POST["email"])
	{
		$email = trim($_POST["email"]);
		$pswrd = trim($_POST["pswrd"]);
		
		$email_v = "/^([a-zA-Z0-9][._]?)*[a-zA-Z0-9]@([a-zA-Z0-9][._-]?)*[a-zA-Z0-9]\.[a-zA-Z]{2,3}$/";
		$pswd_v1 = "/^[A-Za-z0-9!#$%^&*()_-]+$/";
		$validate = true;
		
		if ($email == null || $email == "") { $validate = false; $_SESSION['handoff'] .= "Email was empty.<br>"; }
		if ($pswrd == null || $pswrd == "") { $validate = false; $_SESSION['handoff'] .= "Password was empty.<br>"; }
		
		//IF BOTH INPUTS WERE NOT EMPTY, CHECK CONTENTS
		if ($validate = true)
		{
			if (preg_match($email_v, $email) == false) { $validate = false; $_SESSION['handoff'] .= "Invalid email format.<br>"; }
			if (preg_match($pswd_v1, $pswrd) == false) { $validate = false; $_SESSION['handoff'] .= "Invalid characters in password.<br>"; }		
			if (strlen($pswrd) < 8) { $validate = false; $_SESSION['handoff'] .= "Password must be >8 characters.<br>"; }
		}
		
		//IF JAVASCRIPT CHECKS FAIL PHP ENFORCEMENT
		if ($validate == false)
		{
			$_SESSION['handoff'] .= "Invalid input. Turn on JavaScript... Face palm.";
		}
		
		else
		{
		
			//OPEN DATABASE
			$db = new mysqli("localhost", "pko319", "M7#rh6Et", "pko319");
			if ($db->connect_error) { die ("Database connection failed: " . $db->connect_error); }
		
			//QUERY INPUT vs "Users"
			$user_query = "SELECT * FROM Users WHERE user_email = '$email' AND user_pswrd = '$pswrd';";
			$user_result = $db->query($user_query);
			$user_row = $user_result->fetch_assoc();
		
			if ($user_result->num_rows == 0) { $validate = false; $_SESSION['handoff'] = "Email/password combination was incorrect."; }
			elseif ($user_result->num_rows != 1) { $validate = false; $_SESSION['handoff'] = "Weird database thing."; }
			elseif ($email != $user_row["user_email"] || $pswrd != $user_row["user_pswrd"]) { $validate = false; $_SESSION['handoff'] = "Weird database thing."; }
	
			if ($validate == true)
			{
				$_SESSION['email'] = $user_row['user_email'];
				$_SESSION['alias'] = $user_row['user_alias'];
				$_SESSION['birth'] = $user_row['user_birth'];
				$_SESSION['image'] = $user_row['user_image'];
				$_SESSION['user_id'] = $user_row['user_id'];
				$_SESSION['handoff'] = "Welcome, " . $_SESSION["alias"];
			
				header("Location: " . $_SERVER['HTTP_REFERER']);
				$db->close();
				exit();
			}
		}
	}
?>
		<section>
			<h1>Login</h1>
			<div class="register">
				<div>
					<form method="post" action="login.php" id="login_main_form">
						<script type="text/javascript" src="../js/validate_login_main.js"></script> 				
						<p>&nbsp;&nbsp;&nbsp;Email:&nbsp;<input size="20" name="email" type="text" value=<?="\"" . $email . "\""?>></p><br>
						<label id="login_email_message" class="error_message"></label>
						<p>Password:&nbsp;<input size="20" name="pswrd" type="password" value=<?="\"" . $pswrd . "\""?>></p><br>
						<label id="login_pswrd_message" class="error_message"></label>
						<input type="submit" value="Login">
						<script type="text/javascript" src="../js/register_login_main.js"></script>
					</form>
				</div>
			</div>
		</section>
<?php include '../snippets/footer.php'; ?>
	</body>
</html>


