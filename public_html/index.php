<?php

session_start();

if (!(isset($_SESSION["email"]) && $_SESSION["email"])) {
	header("Location: /demo.php");
} else {
	header("Location: /editor.php");
}
exit();

?>
