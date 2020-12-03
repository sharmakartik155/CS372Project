<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

	<head>
		<title>Hey! SUBMIT</title>
		<?php include '../snippets/default_head.php'; ?>
	</head>

	<body>
		<?php include '../snippets/header.php'; ?>
		<section>
			$_POST
			<table>
				<?php foreach ($_POST as $k0 => $v0) { ?>
				<tr><td><?php echo $k0 . ": " . $v0; ?></td></tr>
				<?php } ?>
			</table><br /><br />

			$_FILES
			<table>
				<?php foreach ($_FILES as $k1 => $v1) { ?>
				<tr><td><?php echo $k1 . ": " . $v1; ?></td></tr>
				<?php } ?>
			</table><br /><br />

			$_FILES(PROPERTIES)
			<?php foreach($_FILES as $k2 => $v2) { ?>
				<table>
					<?php foreach ($v2 as $k3 => $v3) { ?>
					<tr><td><?php echo $k3 . ": " . $v3; ?></td></tr>
					<?php } ?>
				</table><br /><br />
			<?php } ?>

			$_COOKIE
			<table>
				<?php foreach ($_COOKIE as $k4 => $v4) { ?>
				<tr><td><?php echo $k4 . ": " . $v4; ?></td></tr>
				<?php } ?>
			</table><br /><br />

			$_ENV
			<table>
				<?php foreach ($_ENV as $k5 => $v5) { ?>
				<tr><td><?php echo $k5 . ": " . $v5; ?></td></tr>
				<?php } ?>
			</table><br /><br />

			$_GET
			<table>
				<?php foreach ($_GET as $k6 => $v6) { ?>
				<tr><td><?php echo $k6 . ": " . $v6; ?></td></tr>
				<?php } ?>
			</table><br /><br />

			$_REQUEST
			<table>
				<?php foreach ($_REQUEST as $k7 => $v7) { ?>
				<tr><td><?php echo $k7 . ": " . $v7; ?></td></tr>
				<?php } ?>
			</table><br /><br />

			$_SERVER
			<table>
				<?php foreach ($_SERVER as $k8 => $v8) { ?>
				<tr><td><?php echo $k8 . ": " . $v8; ?></td></tr>
				<?php } ?>
			</table><br /><br />

			$_SESSION
			<table>
				<?php foreach ($_SESSION as $k9 => $v9) { ?>
				<tr><td><?php echo $k9 . ": " . $v9; ?></td></tr>
				<?php } ?>
			</table><br /><br />
		</section>
		<?php include '../snippets/footer.php'; ?>
	</body>
</html>

