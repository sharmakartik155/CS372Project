<?php
$db = new mysqli("localhost", "pko319", "secure99", "pko319");
if ($db->connect_error) { die ("Database connection failed: " . $db->connect_error); }
?>
