<?php session_start(); ?>
<!DOCTYPE html>
<!-- html 5 -->
<!-- PROPERTY OF PHILIP OTTENBREIT. © 2019. DO NOT COPY WITHOUT WRITTEN PERMISSION. CONTACT: pko319@uregina.ca.  -->

<html lang="en">

	<head>
		<title>Hey! Manage Account</title>
		<?php include '../snippets/default_head.php'; ?>
		<script type="text/javascript" src="../js/post_validate.js"></script>
		<script type="text/javascript" src="../js/copy.js"></script>  
	</head>
	
	<body>
		<?php include '../snippets/header.php'; ?>
		<?php
		
		
			if (isset($_GET['post']) && $_GET['post']) {
				$_POST['post_id'] = $_GET['post'];
			}
			
			if (isset($_SESSION['post_restore']) && $_SESSION['post_restore']) {
				$_POST['post_id'] = $_SESSION['post_restore'];
				unset($_SESSION['post_restore']);
			}
			
			$db = new mysqli("localhost", "pko319", "M7#rh6Et", "pko319");
			if ($db->connect_error) { die ("Database connection failed: " . $db->connect_error); }
			if (isset($_POST['post_id']) && $_POST['post_id']) {
				$post_id = $_POST['post_id'];
			} else {
				$post_query = "SELECT post_id FROM Questions ORDER BY RAND() LIMIT 1;";
				$post_result = $db->query($post_query);
				if ($post_result->num_rows > 0) {
					$post_row = $post_result->fetch_assoc();
					$post_id = $post_row['post_id'];
				} else {
					$post_found = 0;
				}
			}
									if (isset($_POST["input_body"]) && $_POST["input_body"]) {
				
										//echo get_magic_quotes_gpc();
										$input_body = addslashes(trim($_POST["input_body"]));
										$input_user = $_POST["post_as"];
										$input_ok = true;
		
										if (strlen($input_body) > 2040) {
											$input_ok = false;
											$_SESSION['handoff'] .= "Input body is too long.";
										}
		
										if (!$input_ok) {
											$_SESSION['handoff'] .= "Invalid input. Turn on JavaScript... Face palm.";
										}
		
										//IF JAVASCRIPT CHECKS CLEAR
										else {
											if ($input_user == "user") { $reply_user_id = $_SESSION["user_id"]; }
											else { $reply_user_id = "0"; }
											$insert_post = "INSERT INTO Answers (reply_user_id, reply_post_id, reply_content_body) VALUES ('$reply_user_id', '$post_id', '$input_body');";
											$db = new mysqli("localhost", "pko319", "M7#rh6Et", "pko319");
											if ($db->connect_error) { die ("Connection failed: " . $db->connect_error); }
											$db->query($insert_post);
											
											
											//find post in database
											//set the appropriate_POST
											//redirect to /view.php
											
											$db->close();
										}
									}
									$input_body = $_POST["input_body"];
			
			
			
			
			
			
			
			
			
			
			
			
			
			if ($post_id == 0) { ?><section><h1>There are no questions in the database.</h1></section><?php } else {
				$post_query = "SELECT * FROM Questions WHERE post_id = '$post_id'";
				$post_result = $db->query($post_query);
				if ($post_result->num_rows == 0) {
				?>
					<section><h1>Question <?=$post_id?> was not found in the database.</h1></section>
				<?php } else {
				
				$post_row = $post_result->fetch_assoc();
				$post_timestamp = $post_row['post_timestamp'];
				$post_user_id = $post_row['post_user_id'];
				$post_content_head = $post_row['post_content_head'];
				$post_content_body = $post_row['post_content_body'];
				
				$copy_id = "\"" . "copy_post_" . $post_id . "\"";
				$copy_link = "\"" . "http://www2.cs.uregina.ca/~pko319/assignments/a5/pages/view.php?post=" . $post_id . "\"";
				?>
					<section>
						<div class=q_manage>
							<h1 style="display:inline-block;">Question <?=$post_id?></h1>
							<button style="display:inline-block;" id=<?=$copy_id?> value=<?=$copy_link?>>Copy Permalink</button>
							<script type="text/javascript">document.getElementById(<?=$copy_id?>).addEventListener("click", copy, false);</script>
				<?php
				
				$n_reply_query = "SELECT COUNT(reply_id) AS n_replies FROM Answers WHERE reply_post_id = $post_id;";
				$n_reply_result = $db->query($n_reply_query);
				if ($n_reply_result->num_rows > 0) { $n_reply_row = $n_reply_result->fetch_assoc(); $n_replies = $n_reply_row['n_replies']; } else { $n_replies = 0; }
				
				$user_query = "SELECT user_alias, user_img_url FROM Users WHERE user_id = '$post_user_id';";
				$user_result = $db->query($user_query);
				if ($user_result->num_rows > 0) {
					$user_row = $user_result->fetch_assoc();
					$user_alias = $user_row['user_alias'];
					$user_img_src = $user_row['user_img_url'];
				} else {
					$user_alias = "Anonymous";
					$user_img_src = "../users/_default.png";
				}
				
				
				?>
				<div class=userpost>
					<div class=userpost-head>
						<div class=userpost-head-left>
							<h1><img src="<?=$user_img_src?>" height="32" width="32" alt="Profile Picture"> <?=$post_content_head?></h1>
							<h3>By "<?=$user_alias?>" (<?=$post_timestamp?>)</h3><br>
							<h3><?=$post_content_body?></h3>
						</div>
						<div class=userpost-head-right>
							<h1><?=$n_replies?></h1>
						</div>
					</div>
				<?php
					$reply_query = "SELECT * FROM Answers WHERE reply_post_id = '$post_id';";
					$reply_result = $db->query($reply_query);
					for ($i = 0; $i < $n_replies; $i++) {
						$reply_row = $reply_result->fetch_assoc();
						$reply_id = $reply_row['reply_id']; 
						$reply_timestamp = $reply_row['reply_timestamp']; 
						$reply_content_body = $reply_row['reply_content_body'];
						$reply_user_id = $reply_row['reply_user_id'];
						$user_query = "SELECT user_alias, user_img_url FROM Users WHERE user_id = '$reply_user_id';";
						$user_result = $db->query($user_query);
						if ($user_result->num_rows > 0) {
							$user_row = $user_result->fetch_assoc();
							$user_alias = $user_row['user_alias'];
							$user_img_src = $user_row['user_img_url'];
						} else {
							$user_alias = "Anonymous";
							$user_img_src = "../users/_default.png";
						}
					?>
						<div class="userpost-comment">
							<div class="userpost-comment-left">
								<h3> <img src="<?=$user_img_src?>" height="32" alt="Profile Picture"> From "<?=$user_alias?>"</h3>
								<p><?=$reply_content_body?></p>
								<br><p><?=$reply_timestamp?></p>
							</div>
							<div class="userpost-comment-right">
								<img src="../snippets/updown.png" height="50" alt="Up-Down">
							</div>
					<?php if (isset($_SESSION["email"]) && $_SESSION["email"]) { ?>
							<?php 
								$vote_query = "";
								$vote_result = "";
							
							
							?>
							<div class="userpost-comment-right">
							<form id=vote_up_<?=$reply_id?> method="post" action="../snippets/vote_up.php">
								<input type="submit" value="<?=$i?>" class="votes-up">
								<input type="hidden" name="post_id" value="<?=$post_id?>">
								<input type="hidden" name="vote_reply_id" value="<?=$reply_id?>">
							</form>
							<form id=vote_dn_<?=$reply_id?> method="post" action="../snippets/vote_dn.php">
								<input type="submit" value="<?=$i?>" class="votes-dn">
								<input type="hidden" name="post_id" value="<?=$post_id?>">
								<input type="hidden" name="vote_reply_id" value="<?=$reply_id?>">
							</form>
						</div>
					</div>
				<?php } else { ?>
							<div class="userpost-comment-right">
								<form action="javascript: return false;">
									<input type="submit" value="<?=$i?>"class="votes-up">
								</form>
								<form action="javascript: return false;">
									<input type="submit" value="<?=$i?>"class="votes-dn">
								</form>
							</div>
						</div>
				<?php } } ?>
			</div>
		</div>
	</section>
		<?php if (isset($_SESSION["email"]) && $_SESSION["email"]) { ?>
			<section>
				<h1>Post Answer</h1>
				<div class=submission>
					<form id="create_post" method="post">
						<textarea name="input_body" rows="6"><?=$input_body?></textarea><br>
						<div class="info_box">
							<p id="body_counter">0</p><p>&nbsp;of 2000</p><br>
							<p id="body_message" class="error_message"></p><br>
						</div>
						<p>Reply As:</p><br/>
							<input type="radio" name="post_as" value="user" checked="checked"> <?=$_SESSION['alias']?><br/>
	 						<input type="radio" name="post_as" value="anonymous"> Anonymous<br/>
						<br/>			
						<button type="submit" onclick="">Post Question</button>
						<script type = "text/javascript"  src = "../js/answer_register.js" ></script>
					</form>
				</div>
			</section>
		<?php } } } $db->close();?>
		<?php include '../snippets/footer.php'; ?>
	</body>
</html>











