<?php
	if (isset($_GET['editor_id']) && ($_GET['requestor_id']) && ($_GET['doc_id'])) {
		include '../snippets/open_db.php';
		if ($db->connect_error) {
			die ("Connection failed: " . $db->connect_error);
		}
		
		$editor_id = $_GET['editor_id'];
		$requestor_id = $_GET['requestor_id'];
		$doc_id = $_GET['doc_id'];
		
		$q = "UPDATE Docs SET doc_requestor = '$requestor_id' WHERE doc_id = '$doc_id'";
		$r = $db->query($q);
	}
?>