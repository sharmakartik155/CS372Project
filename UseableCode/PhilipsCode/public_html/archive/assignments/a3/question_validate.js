//question_validate.js

function question_validate(event) {
	
	var input_question = event.currentTarget.ask_question.value;

 	var result = true;  
 
	document.getElementById("character_counter").innerHTML = input_question.length + " of 200";

 
//Password validation
	if (input_question == null || input_question == ""){  
		document.getElementById("question_message").innerHTML="Quesiton is empty. ";
		result = false;
	}
	else {
			if ((input_question.length > 200)) {
			document.getElementById("question_message").innerHTML="Question must be under 200 characters long!";
			result = false;
		} else {
			document.getElementById("question_message").innerHTML="";
		}
	}

	
//test result
	if (result == false)	{
		console.log("result failed");  
		event.preventDefault();
	} else {
		console.log("result succeeded");
		event.preventDefault();//temp because don't want to submit yet
	}
}

