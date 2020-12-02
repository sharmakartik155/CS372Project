<?php
	if (isset($_GET['doc_id'])) {
		$db = new mysqli("localhost", "soren200", "Asdfasdf", "soren200");
		if ($db->connect_error) {
			die ("Connection failed: " . $db->connect_error);
		}
		$doc_id = $_GET['doc_id'];
		
		$q = "SELECT * FROM Docs WHERE doc_id = '$doc_id'";
		$r = $db->query($q);
		$blah = $r->fetch_assoc();
		$editor_id = $blah['doc_editor'];
		
		$array[0] = array('editor_id' => $editor_id);
		echo json_encode($array);
	}
?>