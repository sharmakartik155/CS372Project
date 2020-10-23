<?php session_start(); ?>
<?php if (!(isset($_SESSION["email"]) && $_SESSION["email"])) { header("Location: login.php"); exit(); }?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Ask Question</title>
<?php include '../snippets/head.php'; ?>
	</head>
	<body>
<?php include '../snippets/header.php'; ?>



<?php //IF INPUT VALIDATES, DATABASE INSERT
	
	if (isset($_POST["input_head"]) && $_POST["input_head"] && isset($_POST["input_body"]) && $_POST["input_body"]) {
		$input_head = addslashes(trim($_POST["input_head"]));
		$input_body = addslashes(trim($_POST["input_body"]));
		$input_post_as = $_POST["post_as"];
		$input_ok = true;
		
		if (strlen($input_head) > 240) {
			$input_ok = false;
			$_SESSION['handoff'] .= "Input head is too long.";
		}
		
		if (strlen($input_body) > 2040) {
			$input_ok = false;
			$_SESSION['handoff'] .= "Input body is too long.";
		}
		
		if (!$input_ok) {
			$_SESSION['handoff'] .= "Invalid input. Turn on JavaScript... Face palm.";
		}
		
		//IF JAVASCRIPT CHECKS CLEAR
		else {
			if ($input_post_as == "user") { $post_user_id = $_SESSION["user_id"]; }
			else { $post_user_id = "0"; }
			$insert_post = "INSERT INTO Questions (post_user_id, post_content_head, post_content_body) VALUES ('$post_user_id', '$input_head', '$input_body');";
			$db = new mysqli("localhost", "pko319", "M7#rh6Et", "pko319");
			if ($db->connect_error) { die ("Connection failed: " . $db->connect_error); }
			$db->query($insert_post);
			$db->close();
			Header("Location: account.php");
			exit();
		}
	}
	$input_head = "\"" . $_POST["input_head"] . "\"";
	$input_body = $_POST["input_body"];
?>




		<section>
			<h1>Post Question</h1>
			<div class=submission>
				<form id="create_post" method="post">
					<script type="text/javascript" src="../js/post_validate.js"></script>  
					<p>Head:&nbsp;</p><br>
					<input type="text" name="input_head" value=<?=$input_head?>>
					<div class="info_box">
						<p id="head_counter">0</p><p>&nbsp;of 200</p><br>
						<p id="head_message" class="error_message"></p><br>
					</div>
					<p>Body:&nbsp;</p><br>
					<textarea name="input_body" rows="6"><?=$input_body?></textarea><br>
					<div class="info_box">
						<p id="body_counter">0</p><p>&nbsp;of 2000</p><br>
						<p id="body_message" class="error_message"></p><br>
					</div>
					
					<p>Post As:</p><br/>
						<input type="radio" name="post_as" value="user" checked="checked"> <?=$_SESSION['alias']?><br/>
 						<input type="radio" name="post_as" value="anonymous"> Anonymous<br>
					
					<br><button type="submit" onclick="">Post Question</button>
					<script type = "text/javascript"  src = "../js/question_register.js" ></script>
				</form>
			</div>
		</section>
		<?php include '../snippets/footer.php'; ?>
	</body>
</html>

