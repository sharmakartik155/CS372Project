//validate_head.js

function validate_head(event) {
	
	var input_head = event.currentTarget.parentNode.input_head.value;
 	var result = true;  
	var message = document.getElementById("head_message");
	
	document.getElementById("head_counter").innerHTML = input_head.length;
	
	if (input_head == null || input_head == ""){  
		message.innerHTML="Head is empty. ";
		result = false;
	}
	else {
			if ((input_head.length > 200)) {
			message.innerHTML="You have exceeded the character limit. ";
			result = false;
		} else {
			message.innerHTML="";
			result = true;
		}
	}
	if (result == false) { event.preventDefault(); }
}
