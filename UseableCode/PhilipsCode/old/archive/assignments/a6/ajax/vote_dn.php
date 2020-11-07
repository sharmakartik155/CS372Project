<?php
	session_start();
	if (isset($_POST["post_id"]) && $_POST["post_id"] && isset($_POST["vote_reply_id"]) && $_POST["vote_reply_id"]) {
		$_SESSION['post_restore'] = $_POST["post_id"];
		$vote_reply_id = $_POST["vote_reply_id"];
		$email = $_SESSION["email"];
		$user_query = "SELECT user_id FROM Users WHERE user_email = $email";
		$user_result = $db->query($user_query);
		if ($user_result->num_rows > 0) {
			$user_row = $user_result->fetch_assoc();
			$vote_user_id = $user_row['user_id'];
		} else {$vote_user_id = 0;} //BAD RESULT
		
		$vote_query = "SELECT vote_id FROM Votes WHERE vote_user_id = $vote_user_id AND vote_reply_id = $vote_reply_id";
		$vote_result = $db->query($vote_query);
		if ($user_result->num_rows > 0) {
			$user_row = $user_result->fetch_assoc();
			$vote_id = $user_row['vote_id'];
			$vote_update = "UPDATE Votes SET vote_up='1', vote_dn='0' WHERE vote_id = $vote_id";
		} else {
			$vote_insert = "INSERT INTO Votes (vote_user_id, vote_reply_id, vote_up) VALUES ($vote_user_id, $vote_reply_id, 1);";
		}
		
		header("Location: ../pages/view.php");
		exit();
	} else {
		header("Location: ../pages/index.php");
		exit();
	}
?>
