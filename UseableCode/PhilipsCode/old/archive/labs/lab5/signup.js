//signup.js
//
//Edited and completed by Philip Ottenbreit
//
//Imported from "http://www2.cs.uregina.ca/~temp8/SignUp.js"


function SignUpForm() {
	var result = true;
	var a = document.forms.SignUp.email.value;
	var b = document.forms.SignUp.uname.value;
	var c = document.forms.SignUp.pswd.value;
	var d = document.forms.SignUp.pswdr.value;

	var email_v	= /^[a-zA-Z]+\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/;
	var uname_v	= /^[a-zA-Z]+[a-zA-Z0-9_-]+[a-zA-Z0-9]{1}$/;
	var pswd_v = /^(\S*)?\d+(\S*)?$/;
	
	
	//initialization of error messages to empty
	document.getElementById("email_msg").innerHTML = "";
	document.getElementById("uname_msg").innerHTML = "";
	document.getElementById("pswd_msg").innerHTML = "";
	document.getElementById("pswdr_msg").innerHTML = "";
	
	
	//verification of correct input formatting
	if (a==null || a =="" || email_v.test(a) == false){
		document.getElementById("email_msg").innerHTML += "Email must be \"{user}@{domain}.&lt;aa|aaa&gt;\"";
		result = false;
	}

	if (a.length > 60) {
		if (document.getElementById("email_msg").innerHTML != "") {
		document.getElementById("email_msg").innerHTML += "<br/>";
		}
		document.getElementById("email_msg").innerHTML += "Email must be less than 60 characters long.";
		result = false;
	}



	if (b==null || b=="" ||uname_v.test(b) == false){  
		document.getElementById("uname_msg").innerHTML="Bad username.";
		result = false;
	}
	if ((b.length < 8) || (b.length != 0)) {
		if (document.getElementById("uname_msg").innerHTML != "") {
			document.getElementById("uname_msg").innerHTML += "<br/>";
		}
		document.getElementById("uname_msg").innerHTML+="Username must be longer than 8 characters.";
		result = false;
	}
	if (b.length > 40) {
		if (document.getElementById("uname_msg").innerHTML != "") {
			document.getElementById("uname_msg").innerHTML += "<br/>";
		}
		document.getElementById("uname_msg").innerHTML += "Username must be shorter than 40 characters.";
		result = false;
	}
	
	
	
	if (c==null || c=="" ||pswd_v.test(c) == false){  
		document.getElementById("pswd_msg").innerHTML="Incorrect password format.";
		result = false;
	}
	if (c != d){  
		document.getElementById("pswdr_msg").innerHTML="Passwords do not match.";
		result = false;
	}
	
	
	// User Information is displayed if inputs validate.
	if (result == true) {
		document.getElementById("display_info").innerHTML = "<h3>Your Information</h3>" + "<br/>" + "Email: " + a + "<br/>" + "Username: " + b + "<br/>" + "Password: " + c + "<br/>" + "Confirm Password: " + d + "<br/>";
		document.getElementById("SignUp").reset();
	}
}

function ResetForm(){
	document.getElementById("email_msg").innerHTML ="";
	document.getElementById("uname_msg").innerHTML ="";
	document.getElementById("pswd_msg").innerHTML ="";
	document.getElementById("pswdr_msg").innerHTML ="";
	document.getElementById("display_info").innerHTML = ""
}




