//validate_body.js

function validate_body(event) {

	var input_body = event.currentTarget.parentNode.input_body.value;
 	var result = true;  
	var message = document.getElementById("body_message");
	
	document.getElementById("body_counter").innerHTML = input_body.length;
	
	if (input_body == null || input_body == ""){  
		message.innerHTML="Text is empty. ";
		result = false;
	}
	else {
			if ((input_body.length > 2000)) {
			message.innerHTML="You have exceeded the character limit. ";
			result = false;
		} else {
			message.innerHTML="";
			result = true;
		}
	}
	if (result == false) { event.preventDefault(); }
}
