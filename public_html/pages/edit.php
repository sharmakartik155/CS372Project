<?php session_start(); ?>
<?php	if (!isset($_SESSION["email"]) && !$_SESSION["email"]) { header("Location: login.php"); exit(); } ?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Login</title>
<?php include '../snippets/head.php'; ?>
	</head>
	<body class="theme-dark-secondary">
<?php include '../snippets/header.php'; ?>
		<section>
			<div class="w3-container w3-margin-top">
				<form action="../pages/docs.php" method="post">
					<input name="title"type=text class="doc-title theme-dark-primary left-element" placeholder="Document Title">
					<textarea id="textarea" class="theme-dark-primary textarea-main w3-margin-top" placeholder="Type here to get started!" type="text"></textarea>
					<div class="w3-quarter">
						<p>Last auto-upload 3 seconds ago</p>
						<p>Next auto-upload in 2 seconds</p>
					</div>
					<button class="w3-button theme-dark-primary w3-section w3-quarter w3-margin-left w3-margin-right w3-padding edit-buttons" type="submit" value="save">Save</button>
				</form>
				<button onclick="someFunction()" class="w3-button theme-dark-primary w3-section w3-quarter w3-margin-left w3-margin-right w3-padding edit-buttons">Release Control</button>
				<div class="w3-right-align">
					<p>3 current viewers</p>
					<p>1 request for edit control</p>
				</div>
			</div>
		</section>
<?php include '../snippets/footer.php'; ?>
	</body>
</html>


<!--pseudocode representation of what will be implemented in JavaScript on the Editor page


bool update = false;
unsigned delayTime = 3000; //3 seconds
string rawTextBox = "";
string lastHashEditBox = "";

while (true) {
	delay(delayTime);
	AJAX_Check();
	delay(delayTime);

	editBox = document.getElementById("editBox");
	editBoxHASH = hash(editBox);
	if (editBoxHASH != last_editBoxHASH) {
		last_editBoxHASH = editBoxHASH;
		NewFile = editBoxToJSON(editBox);
		AJAX_Send(true, NewFile);
	} else {
		AJAX_Send(false, "");
	}
}

void AJAX_Send (bool updated, string NewFile) {
	content = createJSON(updated)
    if (updated) {
			content.AppendElement(NewFile);
    }
	SendOverHTTP(content);
}


void AJAX_Check () {
	JSONcontent = RequestOverHTTP(status.php);
	while (temp = JSONcontent) {
		array[] += temp;
	}
	if (array[0] = TRUE) {
		handleRequestForControl();
	}
	if (array[1] = TRUE) {
		delayTime = delayTime * 1.5;
	}
} -->