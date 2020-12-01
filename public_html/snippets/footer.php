		<script type="text/javascript" src="../js/toast.js"></script>
		<div id="sexy_notification" class="noselect">Test Notification</div>
<?php
	if (isset($_SESSION["handoff"]) && $_SESSION["handoff"]) {
		$handoff = $_SESSION["handoff"];
		unset($_SESSION["handoff"]);
?>
		<script type="text/javascript"> toast(<?="\"" . $handoff . "\""?>); </script>
<?php } ?>