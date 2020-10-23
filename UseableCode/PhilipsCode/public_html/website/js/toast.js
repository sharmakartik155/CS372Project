//toast.js

function toast(string) {
	var x = document.getElementById("sexy_notification");
	x.innerHTML = string;
	x.classList.add("show");
	setTimeout(function(){ x.classList.remove("show"); }, 5000);
}
