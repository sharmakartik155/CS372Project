<?php session_start(); ?>
<?php	if (!isset($_SESSION["email"]) && !$_SESSION["email"]) { header("Location: login.php"); exit(); } ?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>My Docs</title>
		<?php include '../snippets/head.php'; ?>
	</head>
	<body class="theme-dark-secondary">
		<?php include '../snippets/header.php'; ?>
		<section>
			<div class = "w3-container">
				<a href="../pages/edit.php" class="bar-font-size theme-dark-primary w3-margin w3-button">Create Document</a>
<?php 	
	$db = new mysqli("localhost", "soren200", "Asdfasdf", "soren200");
	if ($db->connect_error) { die ("Database connection failed: " . $db->connect_error); }
	
	$email = $_SESSION["email"];
	$q1 = "SELECT * FROM Users where user_email = '$email'";

	$r1 = $db->query($q1);
	$user = $r1->fetch_assoc();
	
	$id = $user["user_id"];

	//$share_only_once = true;
	
	$q2 = "SELECT * FROM Access WHERE access_user = '$id' ORDER BY access_added DESC;";
	$r2 = $db->query($q2);
	while($access_doc = $r2->fetch_assoc()) {
		$doc_id = $access_doc["access_doc"];
		
		$q4 = "SELECT * FROM Docs WHERE doc_id = '$doc_id'";
		$r4 = $db->query($q4);
		$doc = $r4->fetch_assoc();
		
		?>
		<a href="../pages/<?php 
			if ($doc["doc_editor"] == $id){
				echo "edit.php?id=$doc_id";
			}
			else {
				echo "view.php?id=$doc_id";
			}
		?> "class="bar-font-size theme-dark-primary w3-left-align w3-block w3-margin w3-button">
			<?php echo $doc["doc_title"] ?> Created by:
			<?php 
				$creatorId = $doc["doc_creator"];
				$q3 = "SELECT * FROM Users where user_id = '$creatorId'";

				$r3 = $db->query($q3);
				$creator = $r3->fetch_assoc();
				echo $creator["user_email"];
			?>
		</a>
<?php
	}
?>

				
			</div>
		</section>
	<?php include '../snippets/footer.php'; ?>
	</body>
</html>