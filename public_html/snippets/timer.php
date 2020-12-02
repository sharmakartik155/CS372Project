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
		$requestor_id = $blah['doc_requestor'];
		
		$q2 = "SELECT * FROM Users WHERE user_id = '$requestor_id'";
		$r2 = $db->query($q2);
		$blah2 = $r2->fetch_assoc();
		$requestor_alias = $blah2['user_alias'];
		
		if ($requestor_id != 'NULL' && $requestor_id != 0) {
			$array[0] = array('user_alias' => $requestor_alias, 'user_id' => $requestor_id);
			echo json_encode($array);
		}
	}
?>