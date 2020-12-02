<?php
	if (isset($_GET['requestor_id']) && ($_GET['doc_id'])) {
		$db = new mysqli("localhost", "soren200", "Asdfasdf", "soren200");
		if ($db->connect_error) {
			die ("Connection failed: " . $db->connect_error);
		}
		
		$requestor_id = $_GET['requestor_id'];
		$doc_id = $_GET['doc_id'];
		
		$q = "UPDATE Docs SET doc_editor = '$requestor_id', doc_requestor = NULL WHERE doc_id = '$doc_id'";
		$r = $db->query($q);
	}
?>