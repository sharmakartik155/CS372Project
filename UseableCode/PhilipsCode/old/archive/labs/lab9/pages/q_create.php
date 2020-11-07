<!DOCTYPE html>
<!-- html 5 -->
<!-- PROPERTY OF PHILIP OTTENBREIT. © 2019. DO NOT COPY WITHOUT WRITTEN PERMISSION. CONTACT: pko319@uregina.ca.  -->

<html lang="en">

	<head>
		<title>Hey! Create Question</title>
		<?php include '../html_snippets/default_head.php'; ?>
		<script type="text/javascript" src="../js/question_validate.js"></script>  
	</head>
	
	<body>

		<?php include '../html_snippets/header.php'; ?>
		
		<section>
			<h1>Post Question</h1>
			<div class=submission>
				<form id="question_create" method="post">
					<p>Question:&nbsp;<textarea name="ask_question" rows="6" cols="60"></textarea></p><p id="character_counter">0 of 200</p><br/>
					<p id="question_message" style="color:red;"></p><br />
					<p>Post As:</p><br/>
						<input type="radio" name="post-as" value="Alias" checked> Alias<br/>
 						<input type="radio" name="post-as" value="Username"> Username<br/>
 						<input type="radio" name="post-as" value="Anonymous"> Anonymous<br/>
					<br/>			
					<button type="submit" onclick="">Post Question</button>
					<script type = "text/javascript"  src = "../js/question_register.js" ></script>
				</form>
			</div>
		</section>
		<?php include '../html_snippets/footer.php'; ?>
	</body>
</html>

