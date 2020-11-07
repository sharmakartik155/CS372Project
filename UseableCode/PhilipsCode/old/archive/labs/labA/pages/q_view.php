<?php session_start(); ?>
<!DOCTYPE html>
<!-- html 5 -->
<!-- PROPERTY OF PHILIP OTTENBREIT. © 2019. DO NOT COPY WITHOUT WRITTEN PERMISSION. CONTACT: pko319@uregina.ca.  -->

<html lang="en">

	<head>
		<title>Hey! Manage Account</title>
		<?php include '../snippets/default_head.php'; ?>
		<script type="text/javascript" src="../js/answer_validate.js"></script>  
	</head>
	
	<body>

		<?php include '../snippets/header.php'; ?>

		<section>
			<div class=q_manage>
				<h1>q_001</h1>
				<div class=userpost>

					<div class=userpost-head>
						<div class=userpost-head-left>
							<h3> <img src="../images/profile_pko319.png" height="32" alt="Profile Picture"> "Anonymous" (2019-02-03 22:32:07)</h3>
							<h1>How come this webpage is greyscale?</h1>
						</div>
						<div class=userpost-head-right>
							<h1>3</h1>
						</div>
					</div>

					<div class=userpost-comment>
						<div class=userpost-comment-left>
							<h3> <img src="../images/profile_pko319.png" height="32" alt="Profile Picture"> Peter Ottenbreit </h3>
							<p>I think this page is greyscale to impose a professional trust, which is gently eased by the subtle use of transitions and a bold but calming passive green.</p>
							<br><p>(2019-02-03 22:32:07)</p>
						</div>
						<div class=userpost-comment-right>
							<img src="../images/updown.png" height="50" alt="Profile Picture">
						</div>
						<div class=userpost-comment-right>
							<h3 class=votes-up> <a href="vote_up.code">   2   </a></h3>
							<h3 class=votes-dn> <a href="vote_dn.code">   5   </a></h3>
						</div>
					</div>
					
					<div class=userpost-comment>
						<div class=userpost-comment-left>
							<h3> <img src="../images/profile_pko319.png" height="32" alt="Profile Picture"> Peter Ottenbreit </h3>
							<p>I think this page is greyscale to impose a professional trust, which is gently eased by the subtle use of transitions and a bold but calming passive green.</p>
							<br><p>(2019-02-03 22:32:07)</p>
						</div>
						<div class=userpost-comment-right>
							<img src="../images/updown.png" height="50" alt="Profile Picture">
						</div>
						<div class=userpost-comment-right>
							<h3 class=votes-up> <a href="vote_up.code">   2   </a></h3>
							<h3 class=votes-dn> <a href="vote_dn.code">   5   </a></h3>
						</div>
					</div>

				</div>
			</div>
		</section>

		<section>
			<h1>Post Answer</h1>
			<div class=submission>
				<form id="answer_create" method="post">
					<p>Question:&nbsp;<textarea name="answer_question" rows="6" cols="60"></textarea></p><p id="character_counter">0 of 1500</p><br/>
					<p id="answer_message" style="color:red;"></p><br />
					<p>Post As:</p><br/>
						<input type="radio" name="post-as" value="Alias" checked> Alias<br/>
 						<input type="radio" name="post-as" value="Username"> Username<br/>
 						<input type="radio" name="post-as" value="Anonymous"> Anonymous<br/>
					<br/>			
					<button type="submit" onclick="">Post Question</button>
					<script type = "text/javascript"  src = "../js/answer_register.js" ></script>
				</form>
			</div>
		</section>
		<?php include '../snippets/footer.php'; ?>
	</body>
</html>

