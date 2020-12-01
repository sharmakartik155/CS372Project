//validate_signup.js

function validate_signup(event) {
	document.getElementById("signup").addEventListener("input", validate_signup, false);
	var input_email = event.currentTarget.email.value;
	var input_alias = event.currentTarget.alias.value;
	var input_pswrd = event.currentTarget.pswrd.value;
	var input_pswd2 = event.currentTarget.pswd2.value;

 	var result = true;  
 
	var email_v	= /^([a-zA-Z0-9][._]?)*[a-zA-Z0-9]@([a-zA-Z0-9][._-]?)*[a-zA-Z0-9]\.[a-zA-Z]{2,3}$/;
	var alias_v = /^(([a-zA-Z0-9][_]?)*[a-zA-Z0-9])?$/;
	var pswd_v1 = /^[A-Za-z0-9!#$%^&*()_-]+$/;
	var pswd_v2 = /\S*[0-9!#$%^&*()_-]\S*/;
	
	var email_message = document.getElementById("signup_email_message");
	var alias_message = document.getElementById("signup_alias_message");
	var pswrd_message = document.getElementById("signup_pswrd_message");
	var pswd2_message = document.getElementById("signup_pswd2_message");
	
	email_message.innerHTML = "";
	alias_message.innerHTML = "";
	pswrd_message.innerHTML = "";
	pswd2_message.innerHTML = "";


//Email validation
	if (input_email == null || input_email == ""){
		email_message.innerHTML = "Email is empty. ";
		result = false;
	}
	else {
		if (email_v.test(input_email) == false){
			email_message.innerHTML = "Email format is invalid. ";
			result = false;
		}
	}
	
//Screen name validation
	if (input_alias == null || input_alias == ""){
		alias_message.innerHTML = "Alias is empty. ";
		result = false;
	}
	else {
		if (alias_v.test(input_alias) == false){
			alias_message.innerHTML = "Alias format is invalid. ";
			result = false;
		}
	}
	
//Password validation
	if (input_pswrd == null || input_pswrd == ""){  
		pswrd_message.innerHTML="Password is empty. ";
		result = false;
	}
	else {
		if (pswd_v2.test(input_pswrd) == false){  
			pswrd_message.innerHTML="Password requires non-alpha character. ";
			result = false;
		}
		else if (pswd_v1.test(input_pswrd) == false){  
			pswrd_message.innerHTML="Password format is invalid. ";
			result = false;
		}
		if ((input_pswrd.length < 8)) {
			pswrd_message.innerHTML+="Password must be at least 8 characters long. ";
			result = false;
		}
	}
	
//Confirm password match
	if (input_pswd2 != input_pswrd){
		pswd2_message.innerHTML="Passwords do not match. ";
		result = false;
	}
	
//test result
	if (result == false)	{
		event.preventDefault();
	}
}

