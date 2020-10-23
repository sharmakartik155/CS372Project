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






<?php //IF INPUT VALIDATES, DATABASE UPDATE, password OR image
	
	if ((isset($_POST['pswrd0']) && $_POST['pswrd0']) || (isset($_POST['pswrd1']) && $_POST['pswrd1']) || (isset($_POST['pswrd2']) && $_POST['pswrd2'])) {
		$pswrd0 = trim($_POST['pswrd0']);
		$pswrd1 = trim($_POST['pswrd1']);
		$pswrd2 = trim($_POST['pswrd2']);
		
		echo "You are trying to change your password. Logic not yet implemented.";
	}
	
	if (isset($_FILES['image']['name'])) {
		if (!$_FILES['image']['name']) { $_SESSION['handoff'] .= "No file selected.<br>"; header("Location: " . $_SERVER['HTTP_REFERER']); exit(); }
		
		$target_dir 	= "../users/"; //. $input_alias . "/"; if (!file_exists($target_dir)) { mkdir($target_dir); chmod($target_dir, 0777);}
		$target_file = $target_dir . $_SESSION["alias"] . "_" . time() . "_" . basename($_FILES["image"]["name"]) ;
		
		$image_ok = true;
		
		
		//8192 KB
		$max_size = 8388608;
		$file_size = $_FILES["image"]["size"];
		$percent_above = (($file_size * 100) / $max_size) - 100;
		$image_type = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		
		
		//IF CAN'T GET IMAGE SIZE
		if (!getimagesize($_FILES["image"]["tmp_name"])) { $image_ok = false; $_SESSION['handoff'] .= "No profile picture selected.<br>"; }
		
		//IF FILE ALREADY EXISTS
		elseif (file_exists($target_file)) { $image_ok = false; $_SESSION['handoff'] .= "File already exists. Try again.<br>"; }
		
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
				$_SESSION['handoff'] .= "Error uploading profile picture :(.<br>";
			}
		}
		
		if ($image_ok && $upload_ok) {			
			$user_id = $_SESSION['user_id'];
			$update = "UPDATE Users SET user_image='$target_file' WHERE user_id='$user_id';";
			
			$db = new mysqli("localhost", "pko319", "M7#rh6Et", "pko319");
			if ($db->connect_error) { die ("Database connection failed: " . $db->connect_error); }
			$db_update = $db->query($update);
			$db->close();
		
			$_SESSION["image"] = $target_file;
			$_SESSION['handoff'] .= "Image changed successfully!";	
		}
		else { $_SESSION['handoff'] .= "Kept old profile image.<br>"; }
	
		header("Location: account.php");
		exit();
	}
	
	if (isset($_GET['settings']) && $_GET['settings']) {
		$valid_get_settings = true;
		if ($_GET['settings'] == "password") {
?>	<section>
			<h1>Change Password</h1>
			<div class="settings">
			<form method="post" action="" id="change_pswrd">			
						
				<p>Old Password:</p><br>
					<input size="20" name="pswrd0" type="password"><br><br><br>
					
				<p>New Password:</p><br>
					<input size="20" name="pswrd1" type="password"><br>
					<label id="login_pswrd_message" class="error_message"></label>
					
				<p>Verify:</p><br>
					<input size="20" name="pswrd2" type="password"><br>
					<label id="login_pswd2_message" class="error_message"></label><br>
					
				<input type="submit" value="Change Password">
					<script type="text/javascript"  src="../js/validate_pswrd.js"></script>
					<script type="text/javascript"  src="../js/register_pswrd.js"></script>
					
			</form>
			</div>
					<?php
		}
		elseif ($_GET['settings'] == "image") {
?>	
		<section>
			<h1>Change Profile Picture</h1>
			<div class="settings">
				<form method="post" action="" id="change_pswrd" enctype="multipart/form-data">			
					<p>New profile picture: </p><br>
					<input type="file" name="image"><br><br>
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
			exit();
		}
		else { 
			header("Location: account.php");
			exit();
		}
	}
?>







<?php
	if (!(isset($_POST['alias']) && $_POST['alias'])) {	$_POST['alias'] = $_SESSION['alias'];	}
	if (isset($_GET['alias']) && $_GET['alias']) { $_POST['alias'] = $_GET['alias']; }
	if ($_POST['alias'] == $_SESSION['alias']) { $is_self = true; } else { $is_self = false; }
	$user_alias = $_POST['alias'];
	
	$possessive = $user_alias . "'s"; if ($is_self) { $possessive = "Your"; }

	$db = new mysqli("localhost", "pko319", "M7#rh6Et", "pko319");
	if ($db->connect_error) { die ("Database connection failed: " . $db->connect_error); }
	
	$user_query = "SELECT * FROM Users WHERE user_alias = '$user_alias'";
	$user_result = $db->query($user_query);
	if ($user_result->num_rows == 0)
	{ 
		?><h1>User "<?=$user_alias?>" does not exist.</h1><?php 
	}
	
	else
	{
		$user_row = $user_result->fetch_assoc();
		$user_id = $user_row['user_id'];
		$user_alias = $user_row['user_alias'];
		$user_image = $user_row['user_image'];
		$user_email = $user_row['user_email'];
		$user_birth = $user_row['user_birth'];
?>		
		<section>
			<h1><?=$possessive?> Profile</h1>
			<div class="profile">
				<img class="hide_phone" style="float:right" src="<?=$user_image?>" height="140" max-width=140 alt="Profile Image">
				<h1><?=$user_alias?></h1>
				<p class="profile_item">Email:&nbsp;&nbsp;&nbsp;&nbsp;<?=$user_email?></p><br>
				<p class="profile_item">Birthday:&nbsp;<?=$user_birth?></p><br><br>
<?php if ($is_self) { ?>
				<form action="account.php" style="display:inline-block;"><input type="submit" value="Change password"><input type="hidden" name="settings" value="password"></form>
				<form action="account.php" style="display:inline-block;"><input type="submit" value="Change image">		<input type="hidden" name="settings" value="image"></form>
<?php } else { ?>
			<br><br>
<?php } ?>
			</div>
<?php

		$post_query = "SELECT * FROM Questions WHERE post_user_id = '$user_id' ORDER BY post_timestamp DESC";
		$post_result = $db->query($post_query);
		if ($post_result->num_rows == 0)
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
		
			while ($post_row = $post_result->fetch_assoc()) {
			
				$post_id = $post_row['post_id'];
				$form_id = "view_post_" . $post_id;
				$n_reply_query = "SELECT COUNT(reply_id) AS n_replies FROM Answers WHERE reply_post_id = $post_id;";
				$n_reply_result = $db->query($n_reply_query);
				
				if ($n_reply_result->num_rows  > 0) { $n_reply_row = $n_reply_result->fetch_assoc(); $n_replies = $n_reply_row['n_replies']; } else { $n_replies = 0; }
		
				$post_timestamp = $post_row['post_timestamp'];
				$post_user_id = $post_row['post_user_id'];
				$post_content_head = $post_row['post_content_head'];
				$post_content_body = $post_row['post_content_body'];

				$copy_id = "\"" . "copy_post_" . $post_id . "\"";
				$copy_link = "\"" . "http://www2.cs.uregina.ca/~pko319/assignments/a5/pages/view.php?post=" . $post_id . "\"";

				$n_reply_query = "SELECT COUNT(reply_id) AS n_replies FROM Answers WHERE reply_post_id = $post_id;";
				$n_reply_result = $db->query($n_reply_query);
				if ($n_reply_result->num_rows > 0) { $n_reply_row = $n_reply_result->fetch_assoc(); $n_replies = $n_reply_row['n_replies']; } else { $n_replies = 0; }

				$user_query = "SELECT user_alias, user_image FROM Users WHERE user_id = '$post_user_id';";
				$user_result = $db->query($user_query);
				if ($user_result->num_rows > 0) {
					$user_row = $user_result->fetch_assoc();
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
							<h1><?=$post_row["post_content_head"];?></h1>
							<h3><img src="<?=$user_image?>" height="32" width="32" alt="Profile Picture">By "<?=$user_alias?>" (<?=$post_row['post_timestamp']?>)</h3>
							<form id="<?=$form_id?>" method="get" action="view.php">
								<input type="hidden" name="post" value="<?=$post_row["post_id"]?>">
								<button type="submit">View "Question <?=$post_row["post_id"]?>"</button>
							</form>
						</div>
						<div class=userpost-head-right>
							<h1><?=$n_replies?></h1>
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











