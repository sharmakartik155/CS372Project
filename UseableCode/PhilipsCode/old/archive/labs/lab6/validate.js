//validate.js
//
//Imported from "http://www2.cs.uregina.ca/~temp8/..."
//Edited and completed by Philip Ottenbreit

function SignUpForm(event) {
	console.log("HEY!!");
	var elements = event.currentTarget;
	
	var a = elements[0].value;
	var b = elements[1].value;
	var c = elements[2].value;
	var d = elements[3].value;
	
 	var result = true;    
 
	var email_v	= /^([a-zA-Z0-9][._]?)*[a-zA-Z0-9]@([a-zA-Z0-9][._-]?)*[a-zA-Z0-9]\.[a-zA-Z]{2,3}$/;
	var uname_v	= /^([a-zA-Z0-9]_?)*[a-zA-Z0-9]{1}$/;
	var pswd_v = /^[A-Za-z0-9!#$%^&*()_-]+$/;
	var pswd_v2 = /\S*[0-9!#$%^&*()_-]\S*/

	document.getElementById("email_msg").innerHTML = "";
	document.getElementById("uname_msg").innerHTML = "";
	document.getElementById("pswd_msg").innerHTML = "";
	document.getElementById("pswdr_msg").innerHTML = "";
    
 
//Email validation
	if (a == null || a == ""){
		document.getElementById("email_msg").innerHTML += "Email is empty.";
		result = false;
	}
	else {
		if (email_v.test(a) == false){
			document.getElementById("email_msg").innerHTML += "Email format is invalid.";
			result = false;
		}
		if (a.length > 60) {
			if (document.getElementById("email_msg").innerHTML != "") {
				document.getElementById("email_msg").innerHTML += "<br/>";
			}
			document.getElementById("email_msg").innerHTML += "Email must shorter than 60 characters.";
			result = false;
		}
	}

//Username validation
	if (b == null || b == ""){  
		document.getElementById("uname_msg").innerHTML="Username is empty.";
		result = false;
	}
	else {
		if (uname_v.test(b) == false){  
			document.getElementById("uname_msg").innerHTML="Username format is invalid.";
			result = false;
		}
		if (b.length < 8) {
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
	}
	
//Password validation
	if (c == null || c == ""){  
		document.getElementById("pswd_msg").innerHTML="Password is empty.";
		result = false;
	}
	else {
		if (pswd_v2.test(c) == false){  
			document.getElementById("pswd_msg").innerHTML="Password requires non-alpha character.";
			result = false;
		}
		else if (pswd_v.test(c) == false){  
			document.getElementById("pswd_msg").innerHTML="Password format is invalid.";
			result = false;
		}
		if ((c.length != 8)) {
			if (document.getElementById("pswd_msg").innerHTML != "") {
				document.getElementById("pswd_msg").innerHTML += "<br/>";
			}
			document.getElementById("pswd_msg").innerHTML+="Password must be exactly 8 characters long.";
			result = false;
		}
	}

//Confirm password match
	if (d != c){
		document.getElementById("pswdr_msg").innerHTML="Passwords do not match.";
		result = false;
	}


	if (result == false)	{
		console.log("result failed");  
		event.preventDefault();
	} else {
		console.log("result succeeded"); 
		document.getElementById("display_info").innerHTML = "<h3>Your Information</h3>" + "<br/>" + "Email: " + a + "<br/>" + "Username: " + b + "<br/>" + "Password: " + c + "<br/>" + "Confirm Password: " + d + "<br/>";
	}
	event.preventDefault();//temp because we want to display info and not actually submit
}


function ResetForm(event)
{
	document.getElementById("email_msg").innerHTML ="";
	document.getElementById("uname_msg").innerHTML ="";
	document.getElementById("pswd_msg").innerHTML ="";
	document.getElementById("pswdr_msg").innerHTML ="";
}
