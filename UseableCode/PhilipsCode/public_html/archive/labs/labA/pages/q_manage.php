<?php session_start(); ?>
<!DOCTYPE html>
<!-- html 5 -->
<!-- PROPERTY OF PHILIP OTTENBREIT. © 2019. DO NOT COPY WITHOUT WRITTEN PERMISSION. CONTACT: pko319@uregina.ca.  -->

<html lang="en">
	<head>
		<title>Hey! Manage Account</title>
		<?php include '../snippets/default_head.php'; ?>
	</head>
	
	<body>

		<?php include '../snippets/header.php'; ?>

		<section>
			<h1>Manage Your Profile</h1>
			<div class=profile>
				<img style="float:right" src="../images/profile_pko319.png" height="160" alt="image">
				<h1>Philip Ottenbreit&nbsp;</h1>
				<p class=profile_item>Email:&nbsp;&nbsp;&nbsp;&nbsp;pko319@uregina.ca</p><br/>
				<p class=profile_item>Alias:&nbsp;&nbsp;&nbsp;&nbsp;aquaigni</p><br/>
				<p class=profile_item>Birthday:&nbsp;1999-03-06</p><br/>
				<p class=profile_item>Username:&nbsp;philipottenbreit</p><br/>
				<button type="submit">Change password</button>
				<button type="submit">Change photo</button>
			</div>
		</section>

		<section>
			<div class=q_manage>
				<h1>Manage Your Questions</h1>
				
				<div class=userpost>

					<div class=userpost-head>
						<div class=userpost-head-left>
							<h3> <img src="../images/profile_pko319.png" height="32" alt="Profile Picture"> You (2019-02-03 22:32:07) <button type="submit">Edit "q_001"</button></h3>
							<h1> <a href="q_001.php"> How come this webpage is greyscale? </a> </h1>
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
				<div class=userpost>
	
					<div class=userpost-head>
						<div class=userpost-head-left>
							<h3> <img src="../images/profile_pko319.png" height="32" alt="Profile Picture"> You (2019-02-03 22:32:07) <button type="submit">Edit "q_002"</button></h3>
							<h1> <a href="q_002.php"> What's the point of this site? </a> </h1>
						</div>
						<div class=userpost-head-right>
							<h1>7</h1>
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
		<?php include '../snippets/footer.php'; ?>
	</body>
</html>

