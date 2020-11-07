<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Homepage</title>
<?php include '../snippets/head.php'; ?>
	</head>
	<body>
<?php include '../snippets/header.php'; ?>
		<section>
<?php
				$post_query = "SELECT * FROM Questions ORDER BY post_timestamp DESC LIMIT 5;";
				$db = new mysqli("localhost", "pko319", "M7#rh6Et", "pko319");
				if ($db->connect_error) { die ("Connection failed: " . $db->connect_error); }
				$post_result = $db->query($post_query);
				if ($post_result->num_rows == 0) { ?><h1>There are no questions in the database.</h1><?php }
				else {
?>
			<h1>Recent Questions</h1>
<?php
					while ($post_row = $post_result->fetch_assoc()) {
						$post_id = $post_row['post_id'];
						$user_query = "SELECT * FROM Users WHERE user_id = '" . $post_row['post_user_id'] . "';";
						$user_result = $db->query($user_query);
						if ($user_result->num_rows  == 1) {
							$user_row = $user_result->fetch_assoc(); 
							$user_image = $user_row['user_image'];
							$user_alias = $user_row['user_alias'];
						}
						else {
							$user_image = "../users/_default.png";
							$user_alias = "Anonymous";
						}
						$form_id = "view_post_" . $post_id;
						$n_reply_query = "SELECT COUNT(reply_id) AS n_replies FROM Answers WHERE reply_post_id = $post_id;";
						$n_reply_result = $db->query($n_reply_query);
						if ($n_reply_result->num_rows  > 0) { $n_reply_row = $n_reply_result->fetch_assoc(); $n_replies = $n_reply_row['n_replies']; } else { $n_replies = 0; }
?>
			<div class=userpost>
				<div class=userpost-head>
					<div class=userpost-head-left>
						<h1><?=$post_row["post_content_head"];?></h1>
						<h3><img src="<?=$user_image?>" height="32" width="32" alt="Profile Picture">By "<?=$user_alias?>" (<?=$post_row['post_timestamp']?>)</h3>
						<form id="<?=$form_id?>" method="get" action="view.php">
							<input type="hidden" name="post" value="<?=$post_row["post_id"]?>">
							<button type="submit">View "Question <?=$post_row["post_id"]?>"</button>
						</form>
					</div>
					<div class=userpost-head-right>
						<h1><?=$n_replies?></h1>
					</div>
				</div>
			</div>
<?php } } ?>
		</section>
<?php $db->close(); include '../snippets/footer.php'; ?>
	</body>
</html>
















