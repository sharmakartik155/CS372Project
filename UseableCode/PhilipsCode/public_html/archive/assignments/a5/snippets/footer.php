		<footer>
			<div class=nav>
				<h3><a href="index.php"> Homepage </a></h3>
				<h3><a href="view.php"> Random Question </a></h3>
<?php if (isset($_SESSION["email"]) && $_SESSION["email"]) { ?>
				<h3><a href="account.php"> Your Account </a></h3>
				<h3><a href="create.php"> Ask Question </a></h3>
<?php } else { ?>
				<h3><a href="login.php"> Login </a></h3>
				<h3><a href="signup.php"> Register </a></h3>
<?php } ?>
			</div>
		</footer>
		<div id="sexy_notification" class="noselect">Test Notification</div>
<?php
	if (isset($_SESSION["handoff"]) && $_SESSION["handoff"]) {
		$handoff = $_SESSION["handoff"];
		unset($_SESSION["handoff"]);
?>
		<script type="text/javascript">
			if (<?="\"" . $handoff . "\""?> != "") {
				var x = document.getElementById("sexy_notification");
				x.innerHTML = <?="\"" . $handoff . "\""?>;
				x.classList.add("show");
				setTimeout(function(){ x.classList.remove("show");  }, 5000);
			}
		</script>
<?php } //x.remove(); ?>
