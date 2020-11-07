//validate_login_header.js

function validate_login_header(event) {

	var input_email = event.currentTarget.email.value;
	var input_pswrd = event.currentTarget.pswrd.value;

 	var result = true;  
 
	var email_v	= /^([a-zA-Z0-9][._]?)*[a-zA-Z0-9]@([a-zA-Z0-9][._-]?)*[a-zA-Z0-9]\.[a-zA-Z]{2,3}$/;
	var pswd_v1 = /^[A-Za-z0-9!#$%^&*()_-]+$/;
	var pswd_v2 = /\S*[0-9!#$%^&*()_-]\S*/
	
	var error_message = "";
    
 
//Email validation
	if (input_email == null || input_email == ""){
		error_message += "Email is empty.<br>";
		result = false;
	}
	else {
		if (email_v.test(input_email) == false){
			error_message += "Email format is invalid.<br>";
			result = false;
		}
	}
	
//Password validation
	if (input_pswrd == null || input_pswrd == ""){  
		error_message += "Password is empty.<br>";
		result = false;
	}
	else {
		if (pswd_v2.test(input_pswrd) == false){  
			error_message += "Password requires non-alpha character.<br>";
			result = false;
		}
		else if (pswd_v1.test(input_pswrd) == false){  
			error_message += "Password format is invalid.<br>";
			result = false;
		}
		if ((input_pswrd.length < 8)) {
			error_message += "Password must be at least 8 characters long.<br>";
			result = false;
		}
	}
	
//test result
	if (result == false)	{
		event.preventDefault();
		toast(error_message);
	}
}




