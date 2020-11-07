<?php

session_start();

if (!(isset($_SESSION["email"]) && $_SESSION["email"])) {
	header("Location: demo.php");
	exit();
} else {
	header("Location: editor.php");
}

?>
