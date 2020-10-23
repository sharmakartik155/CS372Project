<?php session_start(); ?>

<!DOCTYPE html>
<!-- html 5 -->
<!-- PROPERTY OF PHILIP OTTENBREIT. © 2019. DO NOT COPY WITHOUT WRITTEN PERMISSION. CONTACT: pko319@uregina.ca.  -->

<html lang="en">
	<head>
		<title>Hey! Q&A</title>
		<?php include '../snippets/default_head.php'; ?>
	</head>
	
	<body>
		<?php include '../snippets/header.php'; ?>
		<section>
			<?php
				$db = new mysqli("localhost", "pko319", "M7#rh6Et", "pko319");
				if ($db->connect_error) { die ("Connection failed: " . $db->connect_error); }
				$post_query = "SELECT * FROM Questions ORDER BY post_timestamp DESC LIMIT 5;";
				$post_result = $db->query($post_query);
				if ($post_result->num_rows > 0) {
					?><h1>Recent Questions</h1><?php
					$i = 0; //to enumerate form id's
					while ($post_row = $post_result->fetch_assoc()) {
						$i++;
						$user_query = "SELECT * FROM Users WHERE user_id = " . $post_row['post_user_id'];
						$user_result = $db->query($user_query);
						if ($user_result->num_rows  > 0) {
							$user_row = $user_result->fetch_assoc(); 
							$user_image_src = "../users/" . $user_row['user_img_url'];
							$user_alias = $row['user_alias'];
						}
						else {
							$user_image_src = "../images/default.png";
							$user_alias = "Anonymous";
						}
						$form_id = "view_post_" . $i;
						?>
						
							<div class=userpost>
								<div class=userpost-head>
									<div class=userpost-head-left>
										<h1>
											<?=$post_row["post_content_head"];?>
										</h1>

										<h3>
											<img src="<?=$user_image_src?>" height="32" width="32" alt="Profile Picture">
											By "<?=$user_alias?>" (<?=$post_row['post_timestamp']?>)
										</h3>
										<form id="<?=$form_id?>" method="post" action="q_view.php">
											<button type="submit">View "Question <?=$post_row["post_id"]?>"</button>
											<input type="hidden" name="id_user" value="<?=$post_row["id_post"];?>"/>
										</form>
									</div>
									<div class=userpost-head-right>
										<h1>3</h1>
									</div>
								</div>
							</div>
						<?php } } else { ?><h1>There are no questions in the database.</h1><?php } $db->close();?>
		</section>
		<?php include '../snippets/footer.php'; ?>
	</body>
</html>

