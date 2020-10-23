<?php session_start(); ?>

<!DOCTYPE html>
<!-- html 5 -->
<!-- PROPERTY OF PHILIP OTTENBREIT. © 2019. DO NOT COPY WITHOUT WRITTEN PERMISSION. CONTACT: pko319@uregina.ca.  -->

<html lang="en">
	<head>
		<title>Hey! Q&A</title>
		<?php include '../snippets/default_head.php'; ?>
	</head>
	
	<body>
		<?php include '../snippets/header.php'; ?>
		<section>
		<h1>LOGIN PAGE</h1>
		<?php
				if (isset($_SESSION["email"]) && $_SESSION["email"]) {
					header("Location: q_manage.php");
					exit();
				}
				if (isset($_POST["email"]) && $_POST["email"]) {
					echo "EMAIL/PASSWORD PROCESSING"; //ADD A DATABASE CHECK HERE!!!
					$_SESSION["email"] = $_POST["email"] ;
					$_SESSION["password"] = $_POST["password"];
					header("Location: login.php");
					exit();
				}
				else {
					echo "NOT LOGGED IN, LOGIN PAGE";
				}
				
				$validate = true;
				$v_email = "/^([a-zA-Z0-9][._]?)*[a-zA-Z0-9]@([a-zA-Z0-9][._-]?)*[a-zA-Z0-9]\.[a-zA-Z]{2,3}$/";
				$v_password = "/^[A-Za-z0-9!#$%^&*()_-]+$/";
				$email = "";
				$error = "";

				if (isset($_POST["submitted"]) && $_POST["submitted"]) {
		
					//Guard against insertion attacks, by stripping "\0", "\t", "\n", "\x0B", "\r", " "
					$email = trim($_POST["email"]);
					$password = trim($_POST["password"]);
		
					//Open database connection
					$db = new mysqli("localhost", "pko319", "M7#rh6Et", "pko319");
					if ($db->connect_error) { die ("Connection failed: " . $db->connect_error); }
		
					//Query
					$q = "SELECT * FROM Users WHERE user_email = $email AND user_password = $password;";
				
					$r = $db->query($q);
					$row = $r->fetch_assoc();
		
					if($email != $row["email"] && $password != $row["password"]) {
						$validate = false;
					}
					else {
						$emailMatch = preg_match($reg_Email, $email);
						if($email == null || $email == "" || $emailMatch == false) {
							$validate = false;
						}
						$pswdLen = strlen($password);
						$passwordMatch = preg_match($reg_Pswd, $password);
						if($password == null || $password == "" || $pswdLen < 8 || $passwordMatch == false) {
							$validate = false;
						}
					}
					if($validate == true) {

								session_start();
								$_SESSION["email"] = $row["email"];
								header("Location: index.php");
								$db->close();
								exit();
						}
						else {
								$error = "The email/password combination was incorrect. Login failed.";
								$db->close();
						}
				}
			
			
			
		?>
		</section>
		<?php include '../snippets/footer.php'; ?>
	</body>
</html>
