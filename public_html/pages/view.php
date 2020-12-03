<?php session_start(); ?>
<?php	if (!isset($_SESSION["email"]) && !$_SESSION["email"]) { header("Location: login.php"); exit(); } ?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>View</title>
<?php include '../snippets/head.php'; ?>
	</head>
	<body class="theme-dark-secondary">
<?php include '../snippets/header.php'; ?>
		<section>
			<div class="w3-container w3-margin-top">
				<?php
					include '../snippets/open_db.php';
					if ($db->connect_error) { die ("Database connection failed: " . $db->connect_error); }
					if (isset($_GET['id'])) {
						$id = $_GET['id'];

						$email = $_SESSION["email"];
						$q1 = "SELECT * FROM Users where user_email = '$email'";
						$r1 = $db->query($q1);
						$user = $r1->fetch_assoc();
						$my_id = $user['user_id'];

						$q9 = "SELECT * FROM Access WHERE access_doc = '$id' AND access_user = '$my_id'";
						$r9 = $db->query($q9);
						$user2 = $r9->fetch_assoc();

						if ($user2 == 0) {
							header("Location: ../pages/docs.php");
							exit();
						}


						$q = "SELECT * FROM Docs where doc_id = '$id'";
						$r = $db->query($q);
						$edit_doc = $r->fetch_assoc();
						$edit_content = $edit_doc["doc_content"];
						$edit_title = $edit_doc["doc_title"];

						$user_theme = $user["user_theme"];
						$user_font_size = $user["user_font_size"];
					}
				?>
				<p class="doc-title theme-dark-secondary" style="<?php echo $user_theme?> font-size: <?php echo $user_font_size?>px;""><?php echo $edit_title;?></p>
				<p id="textarea" class="theme-dark-primary view-doc w3-margin-top" style="<?php echo $user_theme?> font-size: <?php echo $user_font_size?>px;""><?php echo $edit_content;?></p>

				<?php
					$doc_editor = $edit_doc["doc_editor"];
					$doc_id = $id;

					$email = $_SESSION["email"];
					$q1 = "SELECT user_id FROM Users where user_email = '$email'";
					$r1 = $db->query($q1);
					
					$user_id = $r1->fetch_assoc();
					$my_id = $user['user_id'];

				?>
				<button id="request-button" class="w3-button theme-dark-primary w3-section  w3-padding edit-buttons" style="width:100%;">Request Control</button>
				<script type="text/javascript">
					var editor_id = <?php echo $doc_editor;?>;
					var requestor_id = <?php echo $my_id;?>;
					var doc_id = <?php echo $doc_id;?>;
				</script>
				<script type="text/javascript" src="../js/lock.js"></script>
				<script type="text/javascript" src="../js/register_request_button.js"></script>
				<script>
					var timerVar = setInterval(timer, 3000);

					function timer() {
					var xmlhttp = new XMLHttpRequest();
					xmlhttp.open("GET", "../snippets/request_timer.php?doc_id=" + doc_id, true);
					xmlhttp.send();


						xmlhttp.onreadystatechange = function() {
							if (this.readyState == 4 && this.status == 200) {
								var results = JSON.parse(this.responseText);

								if (results[0].editor_id == requestor_id) {
									window.location = "http://www2.cs.uregina.ca/~soren200/pages/edit.php?id=" + doc_id;
								}

							}
						}
					}
				</script>

			</div>
		</section>
<?php include '../snippets/footer.php'; ?>
	</body>
</html>
