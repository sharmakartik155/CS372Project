<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

	<head>
		<title>Hey! SUBMIT</title>
		<style> table, th, td { border: 1px solid black; border-collapse: collapse; } </style>
		<?php include '../snippets/default_head.php'; ?>
	</head>

	<body>
		<?php include '../snippets/header.php'; ?>
		
		<section>
			<p><?php
				$user_email 					= $_POST['email'];
				$user_alias 					= $_POST['alias'];
				$user_birthdate 			= $_POST['birthdate'];
				$user_password				= $_POST['password'];
				$user_password2				= $_POST['password2'];
				
				$user_check = true;
				
				$db = new mysqli("localhost", "pko319", "M7#rh6Et", "pko319");
				if ($db->connect_error) { die ("Connection failed: " . $db->connect_error); }
				
				$user_query = "SELECT * FROM Users WHERE user_alias = '$user_alias';";
				$user_result = $db->query($user_query);
				if ($user_result->num_rows > 0) {
					$user_check = false;
					$_SESSION['duplicate_alias'] = true;
				} else { unset($_SESSION['duplicate_alias']); }
				$user_query = "SELECT * FROM Users WHERE user_email = '$user_email';";
				$user_result = $db->query($user_query);
				if ($user_result->num_rows > 0) {
					$user_check = false;
					$_SESSION['duplicate_email'] = true;
				} else {unset ($_SESSION['duplicate_email']); }
				
				if ($user_check == false) {
					header("Location: info.php");
					exit();
				}
				
				
				$target_dir 	= "../users/";
				//. $user_alias . "/";
				//if (!file_exists($target_dir)) { mkdir($target_dir); chmod($target_dir, 0777);}
				$target_file = $target_dir . $user_alias . "_" . time() . "_" . basename($_FILES["profile_img"]["name"]) ;
				$uploadOk = true;
				$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
				
				//Check if image file is a actual image or fake image
				//if(isset($_POST["submit"])) {
					$check = getimagesize($_FILES["profile_img"]["tmp_name"]);
					if($check !== false) {
						echo "File type is \"" . $check["mime"] . "\". ";
						$uploadOk = true;
					} else {
						echo "File is not an image. ";
						$uploadOk = false;
					}
				//}
				
				// Check if file already exists
				if (file_exists($target_file)) { echo "The file already exists! "; $uploadOk = false; }
				// Check file size
				if ($_FILES["profile_img"]["size"] > 1000000) {
					echo "Sorry, your file is too large. ";
					$uploadOk = false;
				}
				// Allow certain file formats
				if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
					echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed. ";
					$uploadOk = false;
				}
				// Check $uploadOk
				if ($uploadOk == false) {
					echo "File was not uploaded. ";
				// if everything is ok, try to upload file
				} else {
					if (move_uploaded_file($_FILES["profile_img"]["tmp_name"], $target_file)) {
						echo "The file \"". basename( $_FILES["profile_img"]["name"]). "\" has been uploaded. ";					
					} else {
						echo "There was an error uploading your file. ";
						$uploadOk = FALSE;
					}
				}
				if ($uploadOk == false) {
					echo "Your account was created with a default profile picture. ";
					$target_file = "../users/_default.png";
				}
				$insert = "INSERT INTO Users (user_email, user_alias, user_birthdate, user_password, user_img_url) VALUES ('$user_email', '$user_alias', '$user_birthdate', '$user_password', '$target_file');";
				$db_ins = $db->query($insert);
				$db->close();

			?></p>
			<table>
				<tr><td rowspan=3><img src="<?=$target_file?>" height="160" alt="Uploaded Image"></td></tr>
				<tr><td>Alias:</td><td><?=$_POST["alias"]?></td></tr>
				<tr><td>Email:</td><td><?=$_POST["email"]?></td></tr>
			</table>
		</section>
		<?php include '../snippets/footer.php'; ?>
	</body>
</html>





