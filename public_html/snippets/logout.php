<?php
	session_start();
	$handoff = $_SESSION["handoff"];
	$_SESSION = array();
	session_destroy();

	session_start();
	$_SESSION["handoff"] = $handoff;
	header("Location: ../pages/login.php");
	exit();
?>
