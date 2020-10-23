//login_signup_validate.js

function login_signup_validate(event) {
	
	var input_email = event.currentTarget.email.value;
	var input_alias = event.currentTarget.alias.value;
	var input_birthdate = event.currentTarget.birthdate.value;
	var input_password = event.currentTarget.password.value;
	var input_password2 = event.currentTarget.password2.value;

 	var result = true;  
 
	var email_v	= /^([a-zA-Z0-9][._]?)*[a-zA-Z0-9]@([a-zA-Z0-9][._-]?)*[a-zA-Z0-9]\.[a-zA-Z]{2,3}$/;
	var alias_v = /^(([a-zA-Z0-9][_]?)*[a-zA-Z0-9])?$/;
	var date_v1	= /^[0-9]{4}-[0-9]{2}-[0-9]{2}$/;
	var date_v2	= /^((19[0-9][0-9])|(20[0-1][0-9]))-((0[1-9])|(1[0-2]))-((0[1-9])|([1-2][0-9])|(3[01]))$/;
	var pswd_v1 = /^[A-Za-z0-9!#$%^&*()_-]+$/;
	var pswd_v2 = /\S*[0-9!#$%^&*()_-]\S*/;
	
	document.getElementById("signup_email_message").innerHTML = "";
	document.getElementById("signup_alias_message").innerHTML = "";
	document.getElementById("signup_birthdate_message").innerHTML = "";
	document.getElementById("signup_password_message").innerHTML = "";
  document.getElementById("signup_password2_message").innerHTML = "";
 
//Email validation
	if (input_email == null || input_email == ""){
		document.getElementById("signup_email_message").innerHTML = "Email is empty. ";
		result = false;
	}
	else {
		if (email_v.test(input_email) == false){
			document.getElementById("signup_email_message").innerHTML = "Email format is invalid. ";
			result = false;
		}
	}
	
//Screen name validation
	if (input_alias == null || input_alias == ""){
		document.getElementById("signup_alias_message").innerHTML = "Alias is empty. ";
		result = false;
	}
	else {
		if (alias_v.test(input_alias) == false){
			document.getElementById("signup_alias_message").innerHTML = "Alias format is invalid. ";
			result = false;
		}
	}
	
//Birthdate validation
	if (input_birthdate == null || input_birthdate == ""){
		document.getElementById("signup_birthdate_message").innerHTML = "Birthdate is empty. ";
		result = false;
	}
	else {
		if (date_v1.test(input_birthdate) == false)
		{
			document.getElementById("signup_birthdate_message").innerHTML = "Use format \"YYYY-MM-DD\". ";
			result = false;
		} else if (date_v2.test(input_birthdate) == false)
		{
			document.getElementById("signup_birthdate_message").innerHTML = "Date is invalid. ";
			result = false;
		}
	}
	
//Password validation
	if (input_password == null || input_password == ""){  
		document.getElementById("signup_password_message").innerHTML="Password is empty. ";
		result = false;
	}
	else {
		if (pswd_v2.test(input_password) == false){  
			document.getElementById("signup_password_message").innerHTML="Password requires non-alpha character. ";
			result = false;
		}
		else if (pswd_v1.test(input_password) == false){  
			document.getElementById("signup_password_message").innerHTML="Password format is invalid. ";
			result = false;
		}
		if ((input_password.length < 8)) {
			document.getElementById("signup_password_message").innerHTML+="Password must be at least 8 characters long. ";
			result = false;
		}
	}
	
//Confirm password match
	if (input_password2 != input_password){
		document.getElementById("signup_password2_message").innerHTML="Passwords do not match. ";
		result = false;
	}
	
//test result
	if (result == false)	{
		event.preventDefault();
	}
}

