<?php session_start(); ?>
<?php	if (isset($_SESSION["email"]) && $_SESSION["email"]) { header("Location: docs.php"); exit(); } ?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Login</title>
<?php include '../snippets/head.php'; ?>
	</head>
	<body class="theme-dark-secondary">
<?php include '../snippets/header.php'; ?>


<?php //IF INPUT VALIDATES, SET SESSION VARIABLES, REDIRECT
	$input_email = "";
	$input_pswrd = "";

	if ((isset($_POST["email"]) && $_POST["email"]) || (isset($_POST["pswrd"]) && $_POST["pswrd"]))
	{
		//OPEN DATABASE
		include '../snippets/open_db.php';
		if ($db->connect_error) { die ("Database connection failed: " . $db->connect_error); }

		$input_email = htmlspecialchars(strip_tags($db->real_escape_string(trim($_POST["email"]))));
		$input_pswrd = htmlspecialchars(strip_tags($db->real_escape_string(trim($_POST["pswrd"]))));

		$email_v = "/^([a-zA-Z0-9][._]?)*[a-zA-Z0-9]@([a-zA-Z0-9][._-]?)*[a-zA-Z0-9]\.[a-zA-Z]{2,3}$/";
		$pswd_v1 = "/^[A-Za-z0-9!#$%^&*()_-]+$/";
		$js_ok = true;

		if ($input_email == null || $input_email == "") { $js_ok = false; $_SESSION['handoff'] .= "Email was empty.<br />"; }
		if ($input_pswrd == null || $input_pswrd == "") { $js_ok = false; $_SESSION['handoff'] .= "Password was empty.<br />"; }

		//IF BOTH INPUTS WERE NOT EMPTY, CHECK CONTENTS
		if ($js_ok == true)
		{
			if (preg_match($email_v, $input_email) == false) { $js_ok = false; $_SESSION['handoff'] .= "Invalid email format.<br />"; }
			if (preg_match($pswd_v1, $input_pswrd) == false) { $js_ok = false; $_SESSION['handoff'] .= "Invalid characters in password.<br />"; }
			if (strlen($input_pswrd) < 8) { $js_ok = false; $_SESSION['handoff'] .= "Password must be >8 characters.<br />"; }
		}

		//IF JAVASCRIPT CHECKS FAIL PHP ENFORCEMENT
		if ($js_ok == false)
		{
			$_SESSION['handoff'] .= "Invalid input. Turn on JavaScript... Face palm.";
		}

		else
		{
			//QUERY INPUT vs "Users"

			$user_que = "SELECT * FROM Users WHERE user_email = '$input_email';";

			if(!$user_res = $db->query($user_que))
			{
				$_SESSION['handoff'] .= "ERROR: DATABASE ACCESS FAILED.<br>" . $db->error;
				$db->close(); header("Location: login.php"); exit();
			}
			if ($user_res->num_rows !== 1) {
				//COULD STOP HERE, BUT WOULD BECOME SUBJECT TO EMAIL POLLING TIMING ATTACK
				//THEN AGAIN, IN MY SYSTEM EMAILS ARE NOT AT ALL SECRET, AND ARE SHOWN ON USER PAGES
				//IRREGARDLESS, I'LL MAINTAIN BEST PRACTICES FOR PROPRIETY's SAKE
				$_SESSION['handoff'] .= "EMAIL NOT FOUND";
			}

			$user_row = $user_res->fetch_assoc();
			$user_salt = $user_row['user_salt'];
			$user_hash = $user_row['user_hash'];

			$input_hash = crypt($input_pswrd, "\$6\$rounds=150000\$$user_salt\$");

			$compare = 0;

			if(strlen($user_hash) !== strlen($input_hash))
			{
				$compare = 1;
				$input_hash = $user_hash;
			}
			$xor_hash = $user_hash ^ $input_hash;
			for ($i = 0; $i < strlen($xor_hash); $i++)
			{
				$compare |= ord($xor_hash[$i]);
			}

			//IF PASSWORD HASH MATCHES
			if ($compare === 0)
			{
				$user_que = "SELECT * FROM Users WHERE user_email = '$input_email' AND user_hash = '$input_hash';";
				if(!$user_res = $db->query($user_que))
				{
					$_SESSION['handoff'] .= "ERROR: DATABASE ACCESS FAILED.<br>" . $db->error;
					$db->close(); header("Location: login.php"); exit();
				}
				if ($user_res->num_rows !== 1)
				{
					$_SESSION['handoff'] = "Email/password combination was incorrect.";
				}
				else
				{
					$_SESSION['email'] = $user_row['user_email'];
					$_SESSION['alias'] = $user_row['user_alias'];
					$_SESSION['image'] = $user_row['user_image'];
					$_SESSION['user_id'] = $user_row['user_id'];

					$_SESSION['handoff'] = "Welcome, " . $_SESSION["alias"];
					$db->close(); header("Location: " . $_SERVER['HTTP_REFERER']); exit();
				}
			}
			else
			{
				$_SESSION['handoff'] = "Email/password combination was incorrect.";
			}
		}
		$db->close();
	}
?>
		<section class="w3-container">
			<h1>Login</h1>
			<div>
				<form id="login_main_form" method="post" action="login.php">
					<p>Email:&nbsp;
						<input size="20" name="email" type="text" value=<?="\"" . $input_email . "\""?>></p><br />
						<label id="login_email_message" class="error-message"></label>

					<p>Password:&nbsp;
						<input size="20" name="pswrd" type="password" value=<?="\"" . $input_pswrd . "\""?>></p><br />
						<label id="login_pswrd_message" class="error-message"></label>

					<input type="submit" value="Login">
						<script type="text/javascript" src="../js/validate_login_main.js"></script>
						<script type="text/javascript" src="../js/register_login_main.js"></script>
				</form>
			</div>
		</section>
<?php include '../snippets/footer.php'; ?>
	</body>
</html>
