<!DOCTYPE html>
<html lang="en">

	<head>
		<title>Hey! SUBMIT</title>
		<style>
			table, th, td {
				border: 1px solid black;
				border-collapse: collapse;
			}
		</style>
		<?php include '../html_snippets/default_head.php'; ?>
	</head>

	<body>
		<?php include '../html_snippets/header.php'; ?>
		
		
		
		<section>
			<p>
			<?php
				$target_dir = "../uploads/";
				$target_file = $target_dir . basename($_FILES["profile_img"]["name"]);
				$uploadOk = 1;
				$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			
				// Check if image file is a actual image or fake image
				if(isset($_POST["submit"])) {
					echo "TEST";
					$check = getimagesize($_FILES["profile_img"]["tmp_name"]);
					if($check !== false) {
						echo "File is an image - " . $check["mime"] . ".";
						$uploadOk = 1;
					} else {
						echo "File is not an image. ";
						$uploadOk = 0;
					}
				}
				// Check if file already exists
				if (file_exists($target_file)) {
					echo "The file already exists! ";
					$uploadOk = 0;
				}
				// Check file size
				if ($_FILES["profile_img"]["size"] > 500000) {
					echo "Sorry, your file is too large. ";
					$uploadOk = 0;
				}
				// Allow certain file formats
				if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
					echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed. ";
					$uploadOk = 0;
				}
				// Check if $uploadOk is set to 0 by an error
				if ($uploadOk == 0) {
					echo "It was not uploaded again. ";
				// if everything is ok, try to upload file
				} else {
					if (move_uploaded_file($_FILES["profile_img"]["tmp_name"], $target_file)) {
						echo "The file \"". basename( $_FILES["profile_img"]["name"]). "\" has been uploaded. ";
					} else {
						echo "Sorry, there was an error uploading your file.";
					}
				}
			?>
			</p>
			<table>
				<tr><td rowspan=3><img src=<?=$target_file?> height="160" alt=<?=$target_file?>></td></tr>
				<tr><td>Alias:</td><td><?=$_POST["alias"]?></td></tr>
				<tr><td>Email:</td><td><?=$_POST["email"]?></td></tr>
			</table>
		</section>
		<?php include '../html_snippets/footer.php'; ?>
	</body>
</html>









