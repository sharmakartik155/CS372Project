<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Ask Question</title>
<?php include '../snippets/head.php'; ?>
	</head>
	<body>
<?php include '../snippets/header.php'; ?>
		<section>
		</section>
<?php include '../snippets/footer.php'; ?>
	</body>
</html>



<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="w3.css">
        <link rel="stylesheet" href="style.css">
        <style>html, body, h1, h2, h3, h4, h5, h6 {font-family: "Times New Roman", serif;}</style>
        <title>OutlineR</title>
    </head>
    <body class="w3-dark-grey">
        <div class="w3-bar w3-black">
            <a href="outliner.html"><img src="logo.png" class="w3-bar-item w3-hover-opacity" style="width:70px; height:auto;"></a>
            <div class="w3-bar-item bar-font-size">OutlineR</div>
            <button onclick="document.getElementById('registerId').style.display='block'" class="w3-bar-item bar-font-size w3-button w3-right">Register</button>
            <div id="registerId" class="w3-modal">
                <div class="w3-modal-content w3-card-4 w3-animate-zoom w3-dark-grey" style="max-width:600px">
                    <div class="w3-center">
                        <span onclick="document.getElementById('registerId').style.display='none'" class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>
                        <img src="default_avatar.png" alt="Avatar" style="width:30%" class="w3-circle w3-margin-top">
                    </div>
                    <form class="w3-container" action="/action_page.php">
                        <div class="w3-section">
                            <label><b>Email</b></label>
                            <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Enter Email" name="email" required>
                            <label><b>Username</b></label>
                            <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Enter Username" name="usrname" required>
                            <label><b>Password</b></label>
                            <input class="w3-input w3-border w3-margin-bottom" type="password" placeholder="Enter Password" name="psw" required>
                            <label><b>Confirm Password</b></label>
                            <input class="w3-input w3-border w3-margin-bottom" type="password" placeholder="Confirm Password" name="pswconfirm" required>
                            <label><b>Upload Avatar</b></label>
                            <input type="file" name="avatar" id="avatar">
                            <button class="w3-button w3-block w3-grey w3-section w3-padding" type="submit">Register</button>
                            <input class="w3-check w3-margin-top" type="checkbox" checked="checked"> Remember me
                        </div>
                    </form>
                    <div class="w3-container w3-border-top w3-padding-16 w3-dark-grey">
                        <button onclick="document.getElementById('registerId').style.display='none'" type="button" class="w3-button w3-grey">Cancel</button>
                        <span class="w3-right w3-padding w3-hide-small">Already have an account?<a href="#"> Login here.</a></span>
                    </div>
                </div>
            </div>
            <button onclick="document.getElementById('loginId').style.display='block'" class="w3-bar-item bar-font-size w3-button w3-right">Login</button>
            <div id="loginId" class="w3-modal">
                <div class="w3-modal-content w3-card-4 w3-animate-zoom w3-dark-grey" style="max-width:600px">
                    <div class="w3-center">
                        <span onclick="document.getElementById('loginId').style.display='none'" class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>
                        <img src="default_avatar.png" alt="Avatar" style="width:30%" class="w3-circle w3-margin-top">
                    </div>
                    <form class="w3-container" action="/action_page.php">
                        <div class="w3-section">
                            <label><b>Username</b></label>
                            <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Enter Username" name="usrname" required>
                            <label><b>Password</b></label>
                            <input class="w3-input w3-border" type="password" placeholder="Enter Password" name="psw" required>
                            <button class="w3-button w3-block w3-grey w3-section w3-padding" type="submit">Login</button>
                            <input class="w3-check w3-margin-top" type="checkbox" checked="checked"> Remember me
                        </div>
                    </form>
                    <div class="w3-container w3-border-top w3-padding-16 w3-dark-grey">
                        <button onclick="document.getElementById('loginId').style.display='none'" type="button" class="w3-button w3-grey">Cancel</button>
                        <span class="w3-right w3-padding w3-hide-small"><a href="#">Forgot password?</a></span>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>