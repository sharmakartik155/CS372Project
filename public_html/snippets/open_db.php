<?php
$db = new mysqli("localhost", "soren200", "Asdfasdf", "soren200");
if ($db->connect_error) { die ("Database connection failed: " . $db->connect_error); }
?>
