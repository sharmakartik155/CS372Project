//login_header_validate.js

function login_header_validate(event) {

	var input_email = event.currentTarget.email.value;
	var input_password = event.currentTarget.password.value;

 	var result = true;  
 
	var email_v	= /^([a-zA-Z0-9][._]?)*[a-zA-Z0-9]@([a-zA-Z0-9][._-]?)*[a-zA-Z0-9]\.[a-zA-Z]{2,3}$/;
	var pswd_v1 = /^[A-Za-z0-9!#$%^&*()_-]+$/;
	var pswd_v2 = /\S*[0-9!#$%^&*()_-]\S*/
	
	document.getElementById("email_message").innerHTML = "";
	document.getElementById("password_message").innerHTML = ""; 
    
 
//Email validation
	if (input_email == null || input_email == ""){
		document.getElementById("email_message").innerHTML = "Email is empty. ";
		result = false;
	}
	else {
		if (email_v.test(input_email) == false){
			document.getElementById("email_message").innerHTML = "Email format is invalid. ";
			result = false;
		}
	}
	
//Password validation
	if (input_password == null || input_password == ""){  
		document.getElementById("password_message").innerHTML="Password is empty. ";
		result = false;
	}
	else {
		if (pswd_v2.test(input_password) == false){  
			document.getElementById("password_message").innerHTML="Password requires non-alpha character. ";
			result = false;
		}
		else if (pswd_v1.test(input_password) == false){  
			document.getElementById("password_message").innerHTML="Password format is invalid. ";
			result = false;
		}
		if ((input_password.length < 8)) {
			document.getElementById("password_message").innerHTML+="Password must be at least 8 characters long. ";
			result = false;
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
