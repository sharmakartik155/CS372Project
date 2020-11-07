<?php session_start(); ?>
<?php if (!(isset($_SESSION["email"]) && $_SESSION["email"])) { header("Location: login.php"); exit(); }?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Ask Question</title>
<?php include '../snippets/head.php'; ?>
	</head>
	<body>
<?php include '../snippets/header.php'; ?>
		<section>
		</section>
<?php include '../snippets/footer.php'; ?>
	</body>
</html>
