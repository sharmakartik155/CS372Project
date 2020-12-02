<!DOCTYPE html>

<?php
session_start();
if (isset($_SESSION["email"]) || $_SESSION["email"])
{
	header("Location: docs.php");
	exit();
}
 ?>



<html lang="en">
	<head>
<?php include '../snippets/head.php'; ?>
	</head>
	<body class="theme-dark-secondary">
<?php include '../snippets/header.php'; ?>
        <div class="w3-margin left-element" style="width:600px;">
            <form action="/docs.php" >
                <textarea id="textarea" class="theme-dark-primary textarea-demo" placeholder="Type here to get started!"></textarea>
                <button class="w3-button w3-block theme-dark-primary w3-section w3-padding" style="width:600px;"type="submit" value="save">Save</button>
            </form>
            <h2 class="w3-center">Themes</h2>
            <button onclick="changeTheme(classList.item(0))" class="theme-dark-primary theme-button w3-section w3-padding" type="submit">1</button>
            <button onclick="changeTheme(classList.item(0))" class="theme-white theme-button w3-section w3-padding" type="submit">2</button>
            <button onclick="changeTheme(classList.item(0))" class="theme-grey-orange theme-button w3-section w3-padding" type="submit">3</button>
            <button onclick="changeTheme(classList.item(0))" class="theme-blue-yellow theme-button w3-section w3-padding" type="submit">4</button>
            <button onclick="changeTheme(classList.item(0))" class="theme-blue-green theme-button w3-section w3-padding" type="submit">5</button>
        </div>
        <script>
            function changeTheme(newTheme){
                document.getElementById('textarea').classList.replace(document.getElementById('textarea').classList.item(0), newTheme);
            }
        </script>
        <div class="w3-margin overview">
            <h1 class="w3-center">Real-time Collaboration Outliner</h1>
            OutlineR was created to enhance communication and support development. With this tool you can work on your projects while simultaneously communicating and improving the speed of project development!
            <h1 class="w3-center w3-margin-top">Features</h1>
            <ul>
                <li>Create and manage an account on the website</li>
                <li>Create, save, share, modify and export text documents</li>
                <li>See who is editing your document in real-time and see the edits in real time</li>
                <li>Logs of edits for each document</li>
                <li>Collapsing hierarchy structure inside of the text documents</li>
                <li>Create and use document templates</li>
                <li>Search tool to search for keywords in your document</li>
                <li>Receive notifications when your document has been edited by someone</li>
            </ul>
            <h2 class="w3-center">Register now to start!</h2>
        </div>
<?php include '../snippets/footer.php'; ?>
	</body>
</html>
