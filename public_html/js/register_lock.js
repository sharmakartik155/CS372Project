//document.getElementById("title").addEventListener("change", updateTitle);
//document.getElementById("content").addEventListener("change", updateContent);
if (window.location.href.indexOf("edit.php") > 0) {
	document.getElementById("release-button").addEventListener("click", release);
}

if (window.location.href.indexOf("view.php") > 0) {
	document.getElementById("request-button").addEventListener("click", request);
}
//document.getElementById("save-button").addEventListener("click", saveDoc);