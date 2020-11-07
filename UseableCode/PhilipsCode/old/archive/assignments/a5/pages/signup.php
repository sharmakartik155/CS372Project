<?php session_start(); ?>
<?php	if (isset($_SESSION["email"]) && $_SESSION["email"]) { header("Location: account.php"); exit(); } ?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Register</title><script type="text/javascript" src="../js/validate_login_main.js"></script> 
<?php include '../snippets/head.php'; ?>
	</head>
	<body>
<?php include '../snippets/header.php'; ?>
		
		

<?php //PHP ENFORCE JAVASCRIPT CHECKS
	$input_email = "";
	$input_alias = "";
	$input_birth = "";
	$input_pswrd = "";
	$input_pswd2 = "";
	
	if ((isset($_POST["email"]) && $_POST["email"]) || (isset($_POST["alias"]) && $_POST["alias"]) || (isset($_POST["birth"]) && $_POST["birth"]) || (isset($_POST["pswrd"]) && $_POST["pswrd"]) || (isset($_POST["pswd2"]) && $_POST["pswd2"]))
	{
		$input_email = trim($_POST['email']);
		$input_alias = trim($_POST['alias']);
		$input_birth = trim($_POST['birth']);
		$input_pswrd = trim($_POST['pswrd']);
		$input_pswd2 = trim($_POST['pswd2']);
		
	 	$result = true;
	 	
		$email_v = "/^([a-zA-Z0-9][._]?)*[a-zA-Z0-9]@([a-zA-Z0-9][._-]?)*[a-zA-Z0-9]\.[a-zA-Z]{2,3}$/";
		$alias_v = "/^(([a-zA-Z0-9][_]?)*[a-zA-Z0-9])?$/";
		$date_v1 = "/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/";
		$date_v2 = "/^((19[0-9][0-9])|(20[0-1][0-9]))-((0[1-9])|(1[0-2]))-((0[1-9])|([1-2][0-9])|(3[01]))$/";
		$pswd_v1 = "/^[A-Za-z0-9!#$%^&*()_-]+$/";
		$pswd_v2 = "/\S*[0-9!#$%^&*()_-]\S*/";
		
		
		if 			($input_email == null || $input_email == "") { $result = false; }
		elseif (preg_match($email_v, $input_email) == false) { $result = false; }
		
		if 			($input_alias == null || $input_alias == "") { $result = false; }
		elseif (preg_match($alias_v, $input_alias) == false) { $result = false; }
		
		if 			($input_birth == null || $input_birth == "") { $result = false; }
		elseif (preg_match($date_v1, $input_birth) == false) { $result = false; }
		elseif (preg_match($date_v2, $input_birth) == false) { $result = false; }
		
		if 			($input_pswrd == null || $input_pswrd == "") { $result = false; }
		elseif (preg_match($pswd_v1, $input_pswrd) == false) { $result = false; }
		elseif (preg_match($pswd_v2, $input_pswrd) == false) { $result = false; }
		elseif (strlen($input_pswrd) < 8) { $result = false; }
		
		if ($input_pswd2 != $input_pswrd) { $result = false; }
		
		
		
		
		//IF JAVASCRIPT CHECKS FAIL PHP ENFORCEMENT
		if ($result != true) { $_SESSION['handoff'] .= "Invalid input. Turn on JavaScript... Face palm."; }
		
		//IF JAVASCRIPT CHECKS PASS PHP ENFORCEMENT
		else
		{
			//CHECK IF ALIAS AND EMAIL ARE UNIQUE TO THE DATABASE
			$user_is_unique = true;
			
			//OPEN DATABASE
			$db = new mysqli("localhost", "pko319", "M7#rh6Et", "pko319");
			if ($db->connect_error) { die ("Database connection failed: " . $db->connect_error); }
			
			$user_query = "SELECT * FROM Users WHERE user_alias = '$input_alias';"; $user_result = $db->query($user_query);
			//"IF ANY USER_ALIAS FOUND MATCHING INPUT_ALIAS"
			if ($user_result->num_rows > 0) { $user_is_unique = false; $_SESSION['handoff'] .= "Alias already exists.<br>"; }
			
			$user_query = "SELECT * FROM Users WHERE user_email = '$input_email';"; $user_result = $db->query($user_query);
			//"IF ANY USER_EMAIL FOUND MATCHING INPUT_EMAIL"
			if ($user_result->num_rows > 0) { $user_is_unique = false; $_SESSION['handoff'] .= "Email already exists.<br>"; }
			
			
			
			//IF ALIAS AND EMAIL ARE UNIQUE
			if ($user_is_unique)
			{
				
				//IF IMAGE WAS UPLOADED
				$target_dir 	= "../users/"; //. $input_alias . "/"; if (!file_exists($target_dir)) { mkdir($target_dir); chmod($target_dir, 0777);}
				$target_file = $target_dir . $input_alias . "_" . time() . "_" . basename($_FILES["image"]["name"]) ;
				
				$image_ok = true;
				
				//8192 KB
				$max_size = 8388608;
				$file_size = $_FILES["image"]["size"];
				$percent_above = (($file_size * 100) / $max_size) - 100;
				$image_type = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
				
				
				//IF CAN'T GET IMAGE SIZE
				if (!getimagesize($_FILES["image"]["tmp_name"])) { $image_ok = false; $_SESSION['handoff'] .= "No profile picture selected.<br>"; }
				
				//IF FILE ALREADY EXISTS
				elseif (file_exists($target_file)) { $image_ok = false; }
				
				//IF FILE IS TOO BIG
				elseif ($file_size > $max_size) { $image_ok = false; $_SESSION['handoff'] .= "File was " . $percent_above . "% too big.<br>"; }
				
				//IF FILE EXTENSION IS INVALID
				elseif ($image_type != "jpg" && $image_type != "png" && $image_type != "jpeg" && $image_type != "gif" ) {	$image_ok = false; $_SESSION['handoff'] .= "Invalid file extension.<br>";}
				
				//IF IMAGE IS OK, TRY UPLOAD
				if ($image_ok) {
					$upload_ok = move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
					
					//IF UPLOAD FAILS, USE DEFAULT
					if (!$upload_ok) {
						$target_file = $target_dir . "_default.png";
						$_SESSION['handoff'] .= "Error uploading profile picture :(.<br>Used default instead.<br>";
					}
				}
				
				//IF IMAGE NOT OK, USE DEFAULT
				else {
					$target_file = $target_dir . "_default.png";
					$_SESSION['handoff'] .= "Used default profile picture.<br>";
				}
				
				$insert = "INSERT INTO Users (user_email, user_alias, user_birth, user_pswrd, user_image) VALUES ('$input_email', '$input_alias', '$input_birth', '$input_pswrd', '$target_file');";
				$db_ins = $db->query($insert);
				
				$_SESSION['handoff'] .= "Account created successfully!";
				
				$db->close();
				header("Location: login.php");
				exit();
			}
			//ALWAYS CLOSE DATABASE
			$db->close();
		}
	}
?>
		<section>
			<h1>Register</h1>
			<div class=register>
				<div>
					<form id="signup" method="post" action="signup.php" enctype="multipart/form-data">
						<p>Email:
							<input name="email" type="text" value=<?="\"" . $input_email . "\""?>></p><br/>
							<label id="signup_email_message" class="error_message"></label>
						
						<p>Alias:
							<input name="alias" type="text" value=<?="\"" . $input_alias . "\""?>></p><br/>
							<label id="signup_alias_message" class="error_message"></label>
						
						<p>Birthdate:
							<input name="birth" type="text" placeholder="YYYY-MM-DD" value=<?="\"" . $input_birth . "\""?>></p><br/>
							<label id="signup_birth_message" class="error_message"></label>
						
						<p>Password:
							<input name="pswrd" type="password" value=<?="\"" . $input_pswrd . "\""?>></p><br/>
							<label id="signup_pswrd_message" class="error_message"></label>
						
						<p>Verify:
							<input name="pswd2" type="password" value=<?="\"" . $input_pswd2 . "\""?>></p><br/>
							<label id="signup_pswd2_message" class="error_message"></label>
						
						<p>Optional profile picture: </p>
							<input type="file" name="image">
						
						<input type="submit" value="Register">
						<script type="text/javascript" src="../js/validate_signup.js"></script>
						<script type="text/javascript" src="../js/register_signup.js"></script>
					</form>
				</div>
			</div>
		</section>
<?php include '../snippets/footer.php'; ?>
	</body>
</html>



