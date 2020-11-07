<?php session_start(); ?>
<?php if (!(isset($_SESSION["email"]) && $_SESSION["email"])) { header("Location: login.php"); exit(); }?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Your Account</title>
<?php include '../snippets/head.php'; ?>
	</head>
	<body>
<?php include '../snippets/header.php'; ?>








<?php
	//OPEN DATABASE FOR ENTIRE PAGE
	$db = new mysqli("localhost", "pko319", "M7#rh6Et", "pko319");
	if ($db->connect_error) { die ("Database connection failed: " . $db->connect_error); }
	
	
	
	if (isset($_GET['directory']) && $_GET['directory']) {
		$valid_get_settings = true;
		if ($_GET['directory'] === "view") {
?>
		<section>
<?php
				$user_que = "SELECT * FROM Users ORDER BY user_timestamp DESC;";
				$user_res = $db->query($user_que);
				if ($user_res->num_rows == 0) { ?><h1>There are no users in the database.</h1><?php }
				
?>
			<h1>All Profiles</h1>
<?php
		while ($user_row = $user_res->fetch_assoc()) {
			
			$user_timestamp = $user_row['user_timestamp'];
			$user_alias = $user_row['user_alias'];
			$user_image = $user_row['user_image'];
?>
				<div class=profile>
					<img style="float:left;" src="<?=$user_image?>" height="140" width=140 alt="Profile Image">
					<h1><?=$user_alias?></h1>
					<h3>Joined <?=$user_timestamp?></h3>
					<form method="get" action="account.php">
						<input type="hidden" name="user" value="<?=$user_alias?>">
						<input type="submit" value="View Profile">
					</form>
				</div>
<?php } ?>
		</section>
<?php include '../snippets/footer.php'; ?>
	</body>
</html>
<?php
			$db->close(); exit();
		}
		else {
			$db->close(); header("Location: account.php"); exit();
		}
	}
?>









<?php
	//IF SETTINGS CHANGES VALIDATE, DATABASE UPDATE, password OR image
	if ((isset($_POST['pswrd0']) && $_POST['pswrd0']) || (isset($_POST['pswrd1']) && $_POST['pswrd1']) || (isset($_POST['pswrd2']) && $_POST['pswrd2']))
	{
		$pswrd0 = htmlspecialchars(strip_tags($db->real_escape_string(trim($_POST["pswrd0"]))));
		$pswrd1 = htmlspecialchars(strip_tags($db->real_escape_string(trim($_POST["pswrd1"]))));
		$pswrd2 = htmlspecialchars(strip_tags($db->real_escape_string(trim($_POST["pswrd2"]))));
		
		$pswd_v1 = "/^[A-Za-z0-9!#$%^&*()_-]+$/";
		$pswd_v2 = "/\S*[0-9!#$%^&*()_-]\S*/";
		
		//IF INPUTS WERE NOT EMPTY, CHECK CONTENTS
		if ($pswrd0 == null || $pswrd0 == "") { $js_ok = false; $_SESSION['handoff'] .= "Old password was empty.<br />"; }
		else
		{
			if (strlen($pswrd0) < 8) { $js_ok = false; $_SESSION['handoff'] .= "Old password must be >8 characters.<br />"; }
			else
			{
				if (preg_match($pswd_v1, $pswrd0) == false) { $js_ok = false; $_SESSION['handoff'] .= "Invalid characters in old password.<br />"; }
				if (preg_match($pswd_v2, $pswrd0) == false) { $js_ok = false; $_SESSION['handoff'] .= "Old password requires non-alpha character.<br />"; }
			}
		}
		
		if ($pswrd1 == null || $pswrd1 == "") { $js_ok = false; $_SESSION['handoff'] .= "New password was empty.<br />"; }
		else
		{
			if (strlen($pswrd1) < 8) { $js_ok = false; $_SESSION['handoff'] .= "New password must be >8 characters.<br />"; }
			else
			{
				if (preg_match($pswd_v1, $pswrd1) == false) { $js_ok = false; $_SESSION['handoff'] .= "Invalid characters in new password.<br />"; }
				if (preg_match($pswd_v2, $pswrd1) == false) { $js_ok = false; $_SESSION['handoff'] .= "New password requires non-alpha character.<br />"; }
			}
		}
		
		if ($pswrd2 == null || $pswrd2 == "") { $js_ok = false; $_SESSION['handoff'] .= "Verification was empty.<br />"; }
		else
		{
			if (strlen($pswrd2) < 8) { $js_ok = false; $_SESSION['handoff'] .= "Verification must be >8 characters.<br />"; }
			else
			{
				if (preg_match($pswd_v1, $pswrd2) == false) { $js_ok = false; $_SESSION['handoff'] .= "Invalid characters in verification.<br />"; }
				if (preg_match($pswd_v2, $pswrd2) == false) { $js_ok = false; $_SESSION['handoff'] .= "Verification requires non-alpha character.<br />"; }
			}
		}
		
		if ($pswrd1 !== $pswrd2)
		{
			$js_ok = false; $_SESSION['handoff'] .= "Verification does not match new password.<br />";
		}
		else
		{
			$input_pswrd = $pswrd1; $js_ok = true;
		}

		
		//IF JAVASCRIPT CHECKS FAIL PHP ENFORCEMENT
		if ($js_ok !== true)
		{
			//$_SESSION['handoff'] .= "Invalid input. Add JavaScript, Philip... Face palm.<br />";
		}
		
		else
		{
			$user_email = $_SESSION['email'];
			$user_que = "SELECT * FROM Users WHERE user_email = '$user_email';";
			
			if(!$user_res = $db->query($user_que))
			{
				$_SESSION['handoff'] .= "ERROR: DATABASE ACCESS FAILED.<br>" . $db->error;
				$db->close(); header("Location: login.php"); exit();
			}
			if ($user_res->num_rows !== 1) {
				echo "SESSION EMAIL NOT FOUND";
			}
			
			$user_row = $user_res->fetch_assoc();
			$user_salt = $user_row['user_salt'];
			$user_hash = $user_row['user_hash'];
			$input_hash = crypt($pswrd0, "\$6\$rounds=150000\$$user_salt\$");
			
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
				$user_que = "SELECT * FROM Users WHERE user_email = '$user_email' AND user_hash = '$input_hash';";
				if(!$user_res = $db->query($user_que))
				{
					$_SESSION['handoff'] .= "ERROR: DATABASE ACCESS FAILED.<br>" . $db->error;
					$db->close(); header("Location: account.php"); exit();
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
						$db->close(); header("Location: account.php"); exit();
					}
					$_SESSION['handoff'] = "Password changed successfully";
					$db->close(); header("Location: ../snippets/logout.php"); exit();
				}
			}
			else
			{
				$_SESSION['handoff'] .= "Old password was incorrect."; echo $compare;
			}
		}
		$_GET['settings'] = "password";
	}












	if (isset($_FILES['image']['name']))
	{
		if (!$_FILES['image']['name']) { $_SESSION['handoff'] .= "No file selected.<br />"; header("Location: " . $_SERVER['HTTP_REFERER']); exit(); }
		
		$target_dir 	= "../users/"; //. $input_alias . "/"; if (!file_exists($target_dir)) { mkdir($target_dir); chmod($target_dir, 0777);}
		$target_file = $target_dir . $_SESSION["alias"] . "_" . time() . "_" . basename($_FILES["image"]["name"]) ;
		
		$image_ok = true;
		
		
		//8192 KB
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
	
		$db->close(); header("Location: account.php"); exit();
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	if (isset($_GET['settings']) && $_GET['settings'])
	{
		$valid_get_settings = true;
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		if ($_GET['settings'] == "password") {
?>	<section>
			<h1>Change Password</h1>
			<div class="settings">
			<form method="post" action="" id="change_pswrd">			
						
				<p>Old Password:</p><br />
					<input size="20" name="pswrd0" type="password" value="<?=$pswrd0?>"><br /><br /><br />
					
				<p>New Password:</p><br />
					<input size="20" name="pswrd1" type="password" value="<?=$pswrd1?>"><br />
					<label id="login_pswrd_message" class="error_message"></label>
					
				<p>Verification:</p><br />
					<input size="20" name="pswrd2" type="password" value="<?=$pswrd2?>"><br />
					<label id="login_pswd2_message" class="error_message"></label><br />
					
				<input type="submit" value="Change Password">
					<script type="text/javascript"  src="../js/validate_pswrd.js"></script>
					<script type="text/javascript"  src="../js/register_pswrd.js"></script>
					
			</form>
			</div>
					<?php
		}
		
		
		
		
		
		
		
		
		
		
		elseif ($_GET['settings'] === "image") {
?>	
		<section>
			<h1>Change Profile Picture</h1>
			<div class="settings">
				<form method="post" action="" id="change_pswrd" enctype="multipart/form-data">			
					<p>New profile picture: </p><br />
					<input type="file" name="image"><br /><br />
					<input type="submit" value="Upload New Profile Picture">
				</form>
			</div>
<?php
		}
		else { $valid_get_settings = false; }
		
		if ($valid_get_settings) {
?>
		</section>
<?php include '../snippets/footer.php'; ?>
	</body>
</html>
<?php
			$db->close(); exit();
		}
		else { 
			$db->close(); header("Location: account.php"); exit();
		}
	}
?>







<?php
	if (!(isset($_POST['alias']) && $_POST['alias'])) {	$_POST['alias'] = $_SESSION['alias'];	}
	if (isset($_GET['user']) && $_GET['user']) { $_POST['alias'] = $_GET['user']; }
	if ($_POST['alias'] == $_SESSION['alias']) { $is_self = true; } else { $is_self = false; }
	$user_alias = $_POST['alias'];
	
	$possessive = $user_alias . "'s"; if ($is_self) { $possessive = "Your"; }
	
	$user_que = "SELECT * FROM Users WHERE user_alias = '$user_alias'";
	$user_res = $db->query($user_que);
	if ($user_res->num_rows == 0)
	{ 
?>
		<section><h1>User "<?=$user_alias?>" does not exist.</h1>
<?php 
	}
	
	else
	{
		$user_row = $user_res->fetch_assoc();
		$user_id = $user_row['user_id'];
		$user_alias = $user_row['user_alias'];
		$user_image = $user_row['user_image'];
		$user_email = $user_row['user_email'];
		$user_birth = $user_row['user_birth'];
?>		
		<section>
			<h1><?=$possessive?> Profile</h1>
			<div class="profile">
				<img class="hide_phone" style="float:right" src="<?=$user_image?>" height="140" width=140 alt="Profile Image">
				<h1><?=$user_alias?></h1>
				<p class="profile_item">Email:&nbsp;&nbsp;&nbsp;&nbsp;<?=$user_email?></p><br />
				<p class="profile_item">Birthday:&nbsp;<?=$user_birth?></p><br /><br />
<?php if ($is_self) { ?>
				<form method="get" action="account.php" style="display:inline-block;"><input type="submit" value="Change password">	<input type="hidden" name="settings" value="password"></form>
				<form method="get" action="account.php" style="display:inline-block;"><input type="submit" value="Change image">			<input type="hidden" name="settings" value="image"></form>
				<form method="get" action="account.php" style="display:inline-block;"><input type="submit" value="Explore profiles">	<input type="hidden" name="directory" value="view"></form>
<?php } ?>
			</div>
<?php
		
		$post_que = "SELECT * FROM Questions WHERE post_user_id = '$user_id' ORDER BY post_timestamp DESC";
		$post_res = $db->query($post_que);
		if ($post_res->num_rows == 0)
		{
?>
			<h1>"<?=$user_alias?>" has no posted questions</h1>
<?php 
		}
		
		else
		{
		?>
			<div class=q_manage>
				<h1 style="display:inline-block;"><?=$possessive?> Questions</h1>
<?php
		
			while ($post_row = $post_res->fetch_assoc()) {
			
				$post_id = $post_row['post_id'];
				$form_id = "view_post_" . $post_id;
				$n_reply_que = "SELECT COUNT(reply_id) AS n_replies FROM Answers WHERE reply_post_id = $post_id;";
				$n_reply_res = $db->query($n_reply_que);
				
				if ($n_reply_res->num_rows  > 0) { $n_reply_row = $n_reply_res->fetch_assoc(); $n_replies = $n_reply_row['n_replies']; } else { $n_replies = 0; }
		
				$post_timestamp = $post_row['post_timestamp'];
				$post_user_id = $post_row['post_user_id'];
				$post_content_head = $post_row['post_content_head'];
				$post_content_body = $post_row['post_content_body'];

				$copy_id = "\"" . "copy_post_" . $post_id . "\"";
				$copy_link = "\"" . "http://www2.cs.uregina.ca/~pko319/assignments/a5/pages/view.php?post=" . $post_id . "\"";

				$n_reply_que = "SELECT COUNT(reply_id) AS n_replies FROM Answers WHERE reply_post_id = $post_id;";
				$n_reply_res = $db->query($n_reply_que);
				if ($n_reply_res->num_rows > 0) { $n_reply_row = $n_reply_res->fetch_assoc(); $n_replies = $n_reply_row['n_replies']; } else { $n_replies = 0; }

				$user_que = "SELECT user_alias, user_image FROM Users WHERE user_id = '$post_user_id';";
				$user_res = $db->query($user_que);
				if ($user_res->num_rows > 0) {
					$user_row = $user_res->fetch_assoc();
					$user_alias = $user_row['user_alias'];
					$user_image = $user_row['user_image'];
				} else {
					$user_alias = "Anonymous";
					$user_image = "../users/_default.png";
				}


				?>
				<div class=userpost>
					<div class=userpost-head>
						<div class=userpost-head-left>
							<h1><img src="<?=$user_image?>" height="32" width="32" alt="Profile Picture"> <?=$post_row["post_content_head"];?></h1>
							<h3>By "<?=$user_alias?>" (<?=$post_row['post_timestamp']?>)</h3>
							<form id="<?=$form_id?>" method="get" action="view.php">
								<input type="hidden" name="post" value="<?=$post_row["post_id"]?>">
								<button type="submit">View "Question <?=$post_row["post_id"]?>"</button>
							</form>
						</div>
						<div class=userpost-head-right>
							<h1 class="noselect"><?=$n_replies?></h1>
						</div>
					</div>
				</div>
<?php } ?>
			</div>
<?php } } ?>
		</section>
<?php $db->close(); include '../snippets/footer.php'; ?>
	</body>
</html>











