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
	include '../snippets/open_db.php';

	$email = $_SESSION["email"];
	$q1 = "SELECT * FROM Users where user_email = '$email'";

	$r1 = $db->query($q1);
	$user = $r1->fetch_assoc();

	$id = $user["user_id"];

	//$share_only_once = true;

	$q2 = "SELECT Docs.doc_id, Docs.doc_title, Docs.doc_creator, Docs.doc_modified FROM Docs INNER JOIN Access ON Docs.doc_id = Access.access_doc WHERE Access.access_user = '$id' ORDER BY Docs.doc_modified DESC;";
	$r2 = $db->query($q2);
	while($doc_row = $r2->fetch_assoc()) {
		$doc_id = $doc_row["doc_id"];
		$doc_title = $doc_row["doc_title"];
		$doc_creator = $doc_row["doc_creator"];
		$doc_modified = $doc_row["doc_modified"];

		$q3 = "SELECT * FROM Users where user_id = '$doc_creator'";
		$r3 = $db->query($q3);

		$creator = $r3->fetch_assoc();
		$creator_email = $creator["user_email"];

		?>
		<a href="../pages/view.php?id=<?php echo $doc_id ?>" class="bar-font-size theme-dark-primary w3-left-align w3-block w3-margin w3-button">
			<table class="doc_links" style="width:100%;">
				<tr>
					<td style="text-align:left;"><?php echo $doc_title?></td>
					<td style="text-align:right;">Created By: <?php echo $creator_email?></td>
					<td style="text-align:right;">Last Modified: <?php echo $doc_modified?></td>
				</tr>
			</table>
		</a>
<?php
	}
?>


			</div>
		</section>
	<?php include '../snippets/footer.php'; ?>
	</body>
</html>
