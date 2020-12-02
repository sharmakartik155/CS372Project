<?php session_start(); ?>
<?php	if (!isset($_SESSION["email"]) && !$_SESSION["email"]) { header("Location: login.php"); exit(); } ?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Edit</title>
<?php include '../snippets/head.php'; ?>
	</head>
	<body class="theme-dark-secondary">
<?php include '../snippets/header.php'; ?>

<?php 
	$validate = true;
		
	$db = new mysqli("localhost", "soren200", "Asdfasdf", "soren200");
	if ($db->connect_error) { die ("Database connection failed: " . $db->connect_error); }
		
	$email = $_SESSION["email"];
	$q = "SELECT * FROM Users where user_email = '$email'";
	$r = $db->query($q);
	$user = $r->fetch_assoc();	

	if ((isset($_POST["title"]) && $_POST["title"]) && (isset($_POST["content"]) && $_POST["content"])){

		$title = trim($_POST["title"]);
		$content = trim($_POST["content"]);

		if($content == null || $content == "" || $title == null || $title == "") {
				$validate = false;
			}

		if($validate == true){
			$user_id = $user["user_id"];
			
			if (isset($_GET['id'])){
				$doc_id = $_GET['id'];
				
						/*$id = $_GET['id'];
						
						$email = $_SESSION["email"];
						$q1 = "SELECT user_id FROM Users where user_email = '$email'";
						$r1 = $db->query($q1);
						$blah = $r1->fetch_assoc();
						$my_id = $blah['user_id'];
						
						$q9 = "SELECT * FROM Access WHERE access_doc = '$id' AND access_user = '$my_id'";
						$r9 = $db->query($q9);
						$blah2 = $r9->fetch_assoc();
						
						
						if ($blah2 == 0) {
							header("Location: ../pages/docs.php");
							exit();
						}*/
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				$q2 = "UPDATE Docs SET doc_content = '$content', doc_title = '$title' WHERE doc_id = '$doc_id'";
				$r2 = $db->query($q2);
				
				if($r2 === true) {
						header("Location: ../pages/docs.php");
						$db->close();
						exit();
				}
			}
			else {
				$q2 = "INSERT INTO Docs (doc_creator, doc_editor, doc_title, doc_content) VALUES ('$user_id', '$user_id', '$title', '$content')";
				$r2 = $db->query($q2);
				$doc_id = $db->insert_id;
	
				if ($r2 === true) {
					$q3 = "INSERT INTO Access (access_doc, access_user) VALUES ('$doc_id', '$user_id')";
					$r3 = $db->query($q3);
					
					if($r3 === true) {
						header("Location: ../pages/docs.php");
						$db->close();
						exit();
					}
				}
			}
		}
		else{
			$db->close();
		}
	}
?>
		<section>
			<div class="w3-container w3-margin-top">
				<?php
					if (isset($_GET['id'])) {
					$id = $_GET['id'];
					$q6 = "SELECT * FROM Docs where doc_id = '$id'";
					$r6 = $db->query($q6);
					$edit_doc = $r6->fetch_assoc();
					$edit_content = $edit_doc["doc_content"];
					$edit_title = $edit_doc["doc_title"];
					}
					
					
				?>
				<form  id="docForm" method="post">
					<input name="title" type=text class="doc-title theme-dark-primary" value="<?php echo $edit_title;?>"placeholder="Document Title">
					<textarea name="content" class="theme-dark-primary textarea-main w3-margin-top" placeholder="Type here to get started!" value="sdf" type="text" form="docForm"><?php echo $edit_content;?></textarea>
					<div class="w3-quarter">
						<p>Last auto-upload 3 seconds ago</p>
						<p>Next auto-upload in 2 seconds</p>
					</div>
					<button id="save-button" class="w3-button theme-dark-primary w3-section w3-quarter w3-margin-left w3-margin-right w3-padding edit-buttons" type="submit" value="save">Save</button>
				</form>
				<button id="release-button" class="w3-button theme-dark-primary w3-section w3-quarter w3-margin-left w3-margin-right w3-padding edit-buttons">Release Control</button>
				<div id="requestor" name=></div>	
				<script>
					var doc_id = <?php echo $id;?>;
					var requestor_id;
					var timerVar = setInterval(timer, 3000);
					timer(doc_id);
					
					function timer(doc_id) {
						var element = document.getElementById("requestor");
						
						var xmlhttp = new XMLHttpRequest();
						xmlhttp.open("GET", "../snippets/timer.php?doc_id=" + doc_id, true);
						xmlhttp.send();
								
						xmlhttp.onreadystatechange = function() {
							if (this.readyState == 4 && this.status == 200) {
								var results = JSON.parse(this.responseText);
								alert(results[0].user_alias + " requested control.");
								element.setAttribute("name", results[0].user_id);
							}
						}
						requestor_id = document.getElementById("requestor").getAttribute('name');
					}
				</script>
				<script type="text/javascript" src="../js/lock.js"></script>
				<script type="text/javascript" src="../js/register_lock.js"></script>
				<div class="w3-right-align">
					<p>3 current viewers</p>
					<p>1 request for edit control</p>
				</div>
			</div>
			<?php 
				if (isset($_GET['id'])) {
					if ((isset($_POST["share_email"]) && $_POST["share_email"])){
						$share_email = trim($_POST["share_email"]);
						$q4 = "SELECT * FROM Users where user_email = '$share_email'";
						$r4 = $db->query($q4);
						$share_user = $r4->fetch_assoc();
						$share_id = $share_user["user_id"];
						$doc_id = $_GET['id'];
						$q5 = "INSERT INTO Access (access_doc, access_user) VALUES ('$doc_id', '$share_id')";
						$r5 = $db->query($q5);
					}
			?>
			<form id="share" class="w3-margin" method="post">
				<input type="text" name="share_email" class="theme-dark-primary share" id="share" placeholder="Enter the email address here">
				<button class="w3-button theme-dark-primary w3-margin-left edit-buttons" type="submit" value="save">Share</button>
			</form>
			<?php }?>		
		</section>
<?php include '../snippets/footer.php'; ?>
	</body>
</html>