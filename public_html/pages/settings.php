<!DOCTYPE html>

<?php
	session_start();
	if (!isset($_SESSION["email"]) || !$_SESSION["email"])
	{
		header("Location: login.php");
		exit();
	}




	//OPEN DATABASE FOR ENTIRE PAGE
	include '../snippets/open_db.php';
	if ($db->connect_error) { die ("Database connection failed: " . $db->connect_error); }



		//IF PASSWORD FIELD IS SET
		if ((isset($_POST['pswrd0']) && $_POST['pswrd0']) || (isset($_POST['pswrd1']) && $_POST['pswrd1']) || (isset($_POST['pswrd2']) && $_POST['pswrd2']))
		{
			$pswrd0 = htmlspecialchars(strip_tags($db->real_escape_string(trim($_POST["pswrd0"]))));
			$pswrd1 = htmlspecialchars(strip_tags($db->real_escape_string(trim($_POST["pswrd1"]))));
			$pswrd2 = htmlspecialchars(strip_tags($db->real_escape_string(trim($_POST["pswrd2"]))));

			$pswd_v1 = "/^[A-Za-z0-9!#$%^&*()_-]+$/";
			$pswd_v2 = "/\S*[0-9!#$%^&*()_-]\S*/";

			//redo verification in case javascript was manipulated or disabled
			$js_ok = true;

			if ($pswrd0 == null || $pswrd0 == "") { $js_ok = false; $_SESSION['handoff'] .= "Old password is empty.<br>"; }
			else
			{
				if ($pswrd1 == null || $pswrd1 == "") { $js_ok = false; $_SESSION['handoff'] .= "New password is empty.<br>"; }
				else
				{
					if (strlen($pswrd1) < 8) { $js_ok = false; $_SESSION['handoff'] .= "New password must be at least 8 characters long.<br>"; }
					else
					{
						if (preg_match($pswd_v2, $pswrd1) == false) { $js_ok = false; $_SESSION['handoff'] .= "New password requires at least one non-letter.<br>"; }
					}
					if (preg_match($pswd_v1, $pswrd1) == false) { $js_ok = false; $_SESSION['handoff'] .= "New password contains invalid character(s).<br>"; }
				}

				if ($pswrd2 == null || $pswrd2 == "") { $js_ok = false; $_SESSION['handoff'] .= "Verification was empty.<br />"; }

				if ($pswrd1 !== $pswrd2)
				{
					$js_ok = false; $_SESSION['handoff'] .= "New password does not match verification.<br>";
				}
			}

			if ($js_ok !== true) { $_SESSION['handoff'] .= "Invalid input. Enable JavaScript... ::face-palm::<br />"; }

			//if verification has passed, attempt to update User with new salt + new hash based on new password
			else
			{
				$input_pswrd = $pswrd1;
				$user_email = $_SESSION["email"];
				$user_que = "SELECT * FROM Users WHERE user_email = '$user_email';";

				if(!$user_res = $db->query($user_que))
				{
					$_SESSION['handoff'] .= "ERROR: DATABASE ACCESS FAILED.<br>" . $db->error;
					$db->close(); header("Location: settings.php"); exit();
				}
				if ($user_res->num_rows == 0) {
					$_SESSION['handoff'] .= "SESSION EMAIL WAS NOT FOUND IN DATABASE" . $db->error;
					$db->close(); header("Location: settings.php"); exit();
				}

				//if $user_res has more than one row, check if the old password matches
				$user_row = $user_res->fetch_assoc();
				$user_salt = $user_row['user_salt'];
				$user_hash = $user_row['user_hash'];
				$input_hash = crypt($pswrd0, "\$6\$rounds=150000\$$user_salt\$");

				$compare = 0;

				//cryptographically secure password comparison, safe against timing attacks

				//ensures that the OR functions compare same-lengthed strings
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

				//if password hash matches   aka if the lengths were the same and each bitwise xor
				if ($compare === 0)
				{
					$user_que = "SELECT * FROM Users WHERE user_email = '$user_email' AND user_hash = '$input_hash';";
					if(!$user_res = $db->query($user_que))
					{
						$_SESSION['handoff'] .= "ERROR: DATABASE ACCESS FAILED.<br>" . $db->error;
						$db->close(); header("Location: settings.php"); exit();
					}
					elseif ($user_res->num_rows !== 1)
					{
						$_SESSION['handoff'] .= "ERROR: DATABASE ACCESS FAIL.<br>";
					}
					else
					{
						$user_salt = openssl_random_pseudo_bytes(16);
						$user_hash = crypt($input_pswrd, "\$6\$rounds=150000\$$user_salt\$");

						$user_id = $_SESSION['user_id'];
						$user_upd = "UPDATE Users SET user_salt='$user_salt', user_hash='$user_hash' WHERE user_id='$user_id';";
						if(!$user_res = $db->query($user_upd))
						{
							$_SESSION['handoff'] .= "ERROR: DATABASE ACCESS FAILED.<br>" . $db->error;
							$db->close(); header("Location: settings.php"); exit();
						}
						$_SESSION['handoff'] = "Please log back in.<br>Password changed successfully";
						$db->close(); header("Location: ../snippets/logout.php"); exit();
					}
				}
				else
				{
					$_SESSION['handoff'] .= "Old password was incorrect.";
				}
			}
			$_GET['settings'] = "password";
		}











		//IF IMAGE UPLOAD FIELD IS SET
		if (isset($_FILES['image']['name']))
		{
			if (!$_FILES['image']['name']) { $_SESSION['handoff'] .= "No file selected.<br />"; header("Location: " . $_SERVER['HTTP_REFERER']); exit(); }

			$target_dir 	= "../users/"; //. $input_alias . "/"; if (!file_exists($target_dir)) { mkdir($target_dir); chmod($target_dir, 0777);}
			$target_file = $target_dir . $_SESSION["alias"] . "_" . time() . "_" . basename($_FILES["image"]["name"]) ;

			$image_ok = true;


			//8192 KB, 8 MB
			$max_size = 8388608;
			$file_size = $_FILES["image"]["size"];
			$percent_above = (($file_size * 100) / $max_size) - 100;

			$image_type = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


			//IF CAN'T GET IMAGE SIZE
			if (!getimagesize($_FILES["image"]["tmp_name"])) { $image_ok = false; $_SESSION['handoff'] .= "No profile picture selected.<br />"; }

			//IF FILE ALREADY EXISTS
			elseif (file_exists($target_file)) { $image_ok = false; $_SESSION['handoff'] .= "File already exists. Try again.<br />"; }

			//IF FILE IS TOO BIG
			elseif ($file_size > $max_size) { $image_ok = false; $_SESSION['handoff'] .= "File was " . $percent_above . "% too big.<br />"; }

			//IF FILE EXTENSION IS INVALID
			elseif ($image_type != "jpg" && $image_type != "png" && $image_type != "jpeg" && $image_type != "gif" ) {	$image_ok = false; $_SESSION['handoff'] .= "Invalid file extension.<br />";}

			//IF IMAGE IS OK, TRY UPLOAD
			if ($image_ok) {
				$upload_ok = move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

				//IF UPLOAD FAILS, USE DEFAULT
				if (!$upload_ok) {
					$target_file = $target_dir . "_default.png";
					$_SESSION['handoff'] .= "Error uploading profile picture :(.<br />";
				}
			}

			if ($image_ok && $upload_ok) {
				$user_id = $_SESSION['user_id'];
				$user_upd = "UPDATE Users SET user_image='$target_file' WHERE user_id='$user_id';";

				$user_res = $db->query($user_upd);


				$_SESSION["image"] = $target_file;
				$_SESSION['handoff'] .= "Image changed successfully!";
			}
			else { $_SESSION['handoff'] .= "Kept old profile image.<br />"; }

			$db->close(); header("Location: settings.php"); exit();
		}





//IF PREFERED THEME IS SET

if (isset($_POST['theme']) && $_POST['theme']) {
	$theme_selected = substr($_POST['theme'], -1);
	$themes = array(
		"background: #121212; color: #EEEEEE;",
		"background: #242424; color: #EEEEEE;",
		"background: #FFFFFF; color: #000000;",
		"background: #36342b; color: #c76312;",
		"background: #143D59; color: #F4B41A;",
		"background: #293250; color: #6DD47E;"
	);

	$theme_to_upload = $themes[$theme_selected];
	$user_id = $_SESSION['user_id'];

	$user_upd = "UPDATE Users SET user_theme='$theme_to_upload' WHERE user_id='$user_id';";
	if(!$user_res = $db->query($user_upd)) {
		$_SESSION['handoff'] .= "Error updating prefered theme: <br>" . $db->error;
	}
	else {
		$_SESSION['handoff'] = "Your theme changed successfully!";
	}
}

if (isset($_POST['font']) && $_POST['font']) {
	$font_size_to_upload = $_POST['font'];

	$user_id = $_SESSION['user_id'];

	$user_upd = "UPDATE Users SET user_font_size='$font_size_to_upload' WHERE user_id='$user_id';";
	if(!$user_res = $db->query($user_upd)) {
		$_SESSION['handoff'] .= "Error updating prefered font size: <br>" . $db->error;
	}
	else {
		$_SESSION['handoff'] = "Your font size is now " . $font_size_to_upload;
	}
}

?>
























<html lang="en">
	<head>
		<title>Settings</title>
		<link rel="stylesheet" type="text/css" href="../css/settings.css">
<?php include '../snippets/head.php'; ?>
		<script>
				function focusTab(tabName) {
					window.location.hash = tabName;
					var allTabs = document.getElementsByClassName("tabcontent");

					for (var i = 0; i < allTabs.length; i++) { allTabs[i].style.display = "none"; }

					document.getElementById(tabName + "Content").style.display = "block";
				}

				function validateNewPasswordForm() {
					var input_pswrd_0 = document.forms["changePasswordForm"]["pswrd0"].value;
					var input_pswrd_1 = document.forms["changePasswordForm"]["pswrd1"].value;
					var input_pswrd_2 = document.forms["changePasswordForm"]["pswrd2"].value;

					var result = true;
					var errors = "";

					var pswd_v1 = /^[A-Za-z0-9!#$%^&*()_-]+$/;
					var pswd_v2 = /\S*[0-9!#$%^&*()_-]\S*/;

					if (input_pswrd_0 == null || input_pswrd_0 == ""){
						errors += "Old password is empty.<br>";
						result = false;
					}

					if (input_pswrd_1 == null || input_pswrd_1 == "") {
						errors += "New password is empty.<br>";
						result = false;

					}
					else
					{
						if (pswd_v2.test(input_pswrd_1) == false) {
							errors += "New password requires at least one non-letter.<br>";
							result = false;
						} else if (pswd_v1.test(input_pswrd_1) == false) {
							errors += "New password contains invalid character(s).<br>";
							result = false;
						}
						if (input_pswrd_1.length < 8) {
							errors += "New password must be at least 8 characters long.<br>";
							result = false;
						}
					}
					if (input_pswrd_2 !== input_pswrd_1) {
						errors += "New password does not match verification.<br>";
						result = false;
					}

					if (result == false) {
						toast(errors);
						return false;
					}

					return result;
				}

				function confirmDeleteAccountDialog() {
					var password_to_confirm_delete = document.forms["deleteYourAccount"]["password_to_confirm_delete"].value;
					if (password_to_confirm_delete == null || password_to_confirm_delete == "") {
						alert("Password required to delete account.");
						return false;
					}
					var confirmation = confirm("Click OK to delete your account.");
					//return confirmation;
					return betaFeatureDialog();
				}

				function betaFeatureDialog() {
					alert("This feature is still under development.\nOur appologies for the inconvenience.")
					return false;
				}
		</script>
	</head>
	<body class="theme-dark-secondary">
<?php include '../snippets/header.php'; ?>
















		<section>
			<button class="tablink Preferences" onclick="focusTab('Preferences')" id="Preferences">Preferences</button>
			<button class="tablink Profile" onclick="focusTab('Profile')" id="Profile">Profile</button>
			<button class="tablink Data" onclick="focusTab('Data')" id="Data">Data</button>
			<button class="tablink Security" onclick="focusTab('Security')" id="Security">Security</button>

			<div id="PreferencesContent" class="tabcontent Preferences">
				<div class="card">
					<form name="selectYourTheme" action="" method="post">
						<fieldset>
							<legend><h4>Select Your Theme</h4></legend>
							  <select id="theme" name="theme" size="6">
							    <option value="theme0" style="background: #121212; color: #EEEEEE;">Theme</option>
							    <option value="theme1" style="background: #242424; color: #EEEEEE;">Theme</option>
							    <option value="theme2" style="background: #FFFFFF; color: #000000;">Theme</option>
							    <option value="theme3" style="background: #36342b; color: #c76312;">Theme</option>
									<option value="theme4" style="background: #143D59; color: #F4B41A;">Theme</option>
							    <option value="theme5" style="background: #293250; color: #6DD47E;">Theme</option>
							  </select><br><br>
							<input type="submit" value="Set Theme">
						</fieldset>
					</form>
				</div>
				<div class="card">
					<form name="selectYourFontSize" action="" method="post">
						<fieldset>
							<legend><h4>Select Your Font Size</h4></legend>
								<select id="font" name="font" size="4">
									<option value="10" style="font-size: 10pt;">10 pt</option>
									<option value="12" style="font-size: 12pt;">12 pt</option>
									<option value="16" style="font-size: 16pt;">16 pt</option>
									<option value="22" style="font-size: 22pt;">22 pt</option>
									<option value="26" style="font-size: 26pt;">26 pt</option>
									<option value="34" style="font-size: 34pt;">34 pt</option>
								</select><br><br>
							<input type="submit" value="Set Font Size">
						</fieldset>
					</form>
				</div>
			</div>

			<div id="ProfileContent" class="tabcontent Profile">
<?
				$user_email = $_SESSION["email"];
				$user_que = "SELECT * FROM Users WHERE user_email = '$user_email';";
				$user_res = $db->query($user_que);
				if ($user_res->num_rows == 0) {
					$_SESSION['handoff'] .= "Could not load profile: database access failed.";
				}
				else
				{
				$user_row = $user_res->fetch_assoc();
				$user_created = $user_row['user_created'];
				$user_alias = $user_row['user_alias'];
				$user_email = $user_row['user_email'];

				$user_image = $user_row['user_image'];

?>
				<div class="card">
					<img style="float:right" src="<?=$user_image?>" height="90" width="90" alt="Profile Image">
					<h3>Your Profile</h3>
					<p>Username: <?=$user_alias?></p>
					<p>Email: <?=$user_email?></p>

					<p>Account Created: <?=$user_created?></p>
				</div>
<?php } ?>
				<div class="card">
					<form name="changeProfilePicture" action="" enctype="multipart/form-data" method="post">
						<fieldset>
							<legend><h4>Change Profile Picture</h4></legend>
							<table>
								<tr><td><input type="file" name="image"></td></tr>
								<tr><td><input type="submit" value="Upload New Profile Picture"></td></tr>
							</table>
						</fieldset>
					</form>
				</div>
			</div>




			<div id="DataContent" class="tabcontent Data">
				<div class="card">
					<form name="downloadYourData" action="" onsubmit="return betaFeatureDialog()" method="post">
						<fieldset>
							<legend><h4>Download Your Data</h4></legend>
							<table>
								<tr><td><input type="submit" value="Download My Data"></td></tr>
							</table>
						</fieldset>
					</form>
				</div>
				<div class="card">
					<form name="deleteYourAccount" action="" onsubmit="return confirmDeleteAccountDialog()" method="post">
						<fieldset>
							<legend><h4>Delete Account</h4></legend>
							<table>
								<tr><td><input size="20" name="password_to_confirm_delete" type="password" placeholder="Enter password to confirm"></td></tr>
								<tr><td></td></tr>
								<tr><td><input type="submit" value="Delete Account"></td></tr>
							</table>
						</fieldset>
					</form>
				</div>
			</div>




			<div id="SecurityContent" class="tabcontent Security">
				<div class="card">
					<form name="changePasswordForm" action="" onsubmit="return validateNewPasswordForm()" method="post">
						<fieldset>
							<legend><h4>Change Password</h4></legend>
							<table>
								<tr>
									<td>Old Password</td>
									<td><input size="20" name="pswrd0" type="password" placeholder="Old Password" value="<?=$pswrd0?>"></td>
								</tr>
								<tr><td></td><td></td></tr>
								<tr>
									<td>New Password</td>
									<td><input size="20" name="pswrd1" type="password" placeholder="New Password" value="<?=$pswrd1?>"></td>
								</tr>
								<tr>
									<td>Verification</td>
									<td><input size="20" name="pswrd2" type="password" placeholder="Verification" value="<?=$pswrd2?>"></td>
								</tr>
								<tr>
									<td><input type="submit" value="Change Password"></td>
								</tr>
							</table>
						</fieldset>
					</form>
				</div>
			</div>


		</section>







<?php include '../snippets/footer.php'; $db->close(); ?>
	<script>
		var tabToFocus;
		if (window.location.hash != "") { tabToFocus = window.location.hash.substring(1);
		} else { tabToFocus = "Preferences"; } document.getElementById(tabToFocus).click();
	</script>
	</body>
</html>
