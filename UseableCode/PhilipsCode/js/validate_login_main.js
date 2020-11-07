//validate_login_main.js

function validate_login_main(event) {
	document.getElementById("login_main_form").addEventListener("input", validate_login_main, false);

	var input_email = event.currentTarget.email.value;
	var input_pswrd = event.currentTarget.pswrd.value;

 	var result = true;  
 
	var email_v	= /^([a-zA-Z0-9][._]?)*[a-zA-Z0-9]@([a-zA-Z0-9][._-]?)*[a-zA-Z0-9]\.[a-zA-Z]{2,3}$/;
	var pswd_v1 = /^[A-Za-z0-9!#$%^&*()_-]+$/;
	var pswd_v2 = /\S*[0-9!#$%^&*()_-]\S*/;
	
	document.getElementById("login_email_message").innerHTML = "";
	document.getElementById("login_pswrd_message").innerHTML = "";
 
//Email validation
	if (input_email == null || input_email == ""){
		document.getElementById("login_email_message").innerHTML = "Email is empty. ";
		result = false;
	}
	else {
		if (email_v.test(input_email) == false){
			document.getElementById("login_email_message").innerHTML = "Email format is invalid. ";
			result = false;
		}
	}
	
//Password validation
	if (input_pswrd == null || input_pswrd == ""){  
		document.getElementById("login_pswrd_message").innerHTML="Password is empty. ";
		result = false;
	}
	else {
		if (pswd_v2.test(input_pswrd) == false){  
			document.getElementById("login_pswrd_message").innerHTML="Password requires non-alpha character. ";
			result = false;
		}
		else if (pswd_v1.test(input_pswrd) == false){  
			document.getElementById("login_pswrd_message").innerHTML="Password format is invalid. ";
			result = false;
		}
		if ((input_pswrd.length < 8)) {
			document.getElementById("login_pswrd_message").innerHTML+="Password must be at least 8 characters long. ";
			result = false;
		}
	}
	if (result == false)	{	event.preventDefault();	}
}

