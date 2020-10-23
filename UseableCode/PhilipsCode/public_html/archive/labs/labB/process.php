<?php
	$db = new mysqli("localhost","pko319","M7#rh6Et","pko319");
	if ($db->connect_error) { die ("Connection failed: " . $db->connect_error); }
	
	$query = "SELECT";
