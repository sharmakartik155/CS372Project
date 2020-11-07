	<header>
				<h1 class="title">Hey! Q&A</h1>
				<?php 
					if (isset($_SESSION["email"]) && $_SESSION["email"]) { //SHOULD BE $_SESSION, ONCE ADDED
						?>
							<div id="header_0" class="header_right">
								<form method="post" action="../snippets/logout.php">
									<button class="button" type="submit">Logout</button>
								</form>
							</div>

							<div id="header_1" class="header_right header_phone" style="margin-top:15px;">
								<label id="logged_in_message">Welcome, <?=$_SESSION["email"]?></label>
							</div>
						<?php } else { ?>			
							<div id="header_4" class="header_right header_tiny">
								<form method="post" action="signup.php">
									<button class="button" type="submit">Register</button>
								</form>
							</div>
				
							<div id="header_3" class="header_right header_mobile">
								<form method="post" action="login.php">
									<button class="button" type="submit">Login</button>
								</form>
							</div>
				
							<div id="header_2" class="header_right header_desktop">
								<form method="post" action="login.php" id="login_header">
									<p>Email:&nbsp;</p><input size="20" name="email" type="text">
									<p>&nbsp;</p>
									<p>Password:&nbsp;</p><input size="20" name="password" type="password">
									<p>&nbsp;</p>
									<button class="button" type="submit">Login</button>
								</form>
							</div>
				
							<div id="header_5" class="header_right header_desktop">
								<div class="login_messages" id="header_login_messages" style="display:none;">
									<label id="email_message" class="error_message"></label>
									<label id="password_message" class="error_message"></label>
								</div>
							</div>
						<?php	} ?>
				
				
				<script type = "text/javascript"  src = "../js/login_header_register.js" ></script>
			</header>
