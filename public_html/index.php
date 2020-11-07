<?php

session_start();

if (!(isset($_SESSION["email"]) && $_SESSION["email"])) {
	header("Location: pages/demo.php");
} else {
	header("Location: pages/editor.php");
}
exit();

?>