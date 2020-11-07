//answer_validate.js

function answer_validate(event) {
	var input_answer = event.currentTarget.answer_question.value;
 	var result = true;  
	document.getElementById("character_counter").innerHTML = input_answer.length + " of 1500";
 
//Password validation
	if (input_answer == null || input_answer == ""){  
		document.getElementById("answer_message").innerHTML="Answer is empty. ";
		result = false;
	}
	else {
			if ((input_answer.length > 1500)) {
			document.getElementById("answer_message").innerHTML="Answer must be under 1500 characters long!";
			result = false;
		} else {
			document.getElementById("answer_message").innerHTML="";
		}
	}

	
//test result
	if (result == false)	{
		console.log("result failed");  
		event.preventDefault();
	} else {
		console.log("result succeeded");
	}
}

