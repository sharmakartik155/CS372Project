//copy.js

function copy(event) {
	var temp = document.createElement("input");
	temp.setAttribute('type','text');
	temp.setAttribute('value', event.currentTarget.value);
	temp.setAttribute('display', 'none');
	document.body.appendChild(temp);
	
	temp.select();
	document.execCommand("copy");
	temp.parentElement.removeChild(temp);
	event.currentTarget.blur();
	
	var x = document.getElementById("sexy_notification");
	x.innerHTML = "Text copied to clipboard";
	x.classList.add("show");
	setTimeout(function(){ x.classList.remove("show"); }, 5000);
}
