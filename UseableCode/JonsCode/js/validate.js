function SignUpForm(event){ 

    var elements = event.currentTarget;
      
	var a = elements[0].value;
	var b = elements[1].value;
	var c = elements[2].value;
	var d = elements[3].value;
	var e = elements[4].value;
    
    var result = true;    

    var email_v = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/; 
    var Uname_v = /^[a-zA-Z0-9_-]+$/;
    var pswd_v = /^(?=.*\d).{8,}$/;
   
    document.getElementById("email_msg").innerHTML ="";
    document.getElementById("uname_msg").innerHTML ="";
    document.getElementById("pswd_msg").innerHTML ="";
    document.getElementById("pswdr_msg").innerHTML ="";
	document.getElementById("photo_msg").innerHTML ="";
    
    if (a==null || a==""||!email_v.test(a))
        {	   
	   document.getElementById("email_msg").innerHTML="Email is empty or invalid(example: cs215@uregina.ca)";
           result = false;
        }

	if (b==null || b==""||!Uname_v.test(b))
        {	   
	   document.getElementById("uname_msg").innerHTML="Username is empty or invalid";
           result = false;
	}

	if (c==null || c==""||!pswd_v.test(c))
        {	   
	   document.getElementById("pswd_msg").innerHTML="Invalid password format (8 characters long at least one non-letter)";
           result = false;
	}

	if (d==null || d==""|| c != d)
        {	   
	   document.getElementById("pswdr_msg").innerHTML="Password and confirmed password must match";
           result = false;
	}
	if (e==null || e=="")
	{
		document.getElementById("photo_msg").innerHTML="Please upload a photo";
		result = false;
	}

    if(result == false )
        {    
            event.preventDefault();
        }
     else{
	alert("Successful sign up!");
		}
}

function ResetForm(event)
{
    document.getElementById("email_msg").innerHTML ="";
    document.getElementById("uname_msg").innerHTML ="";
    document.getElementById("pswd_msg").innerHTML ="";
    document.getElementById("pswdr_msg").innerHTML ="";
}

function LoginForm(event){
	
    var elements = event.currentTarget;
      
	var a = elements[0].value;
	var b = elements[1].value;
	
	var result = true;
	
	var email_v = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/;
    var pswd_v = /^(?=[a-z!@#$%^&*()\d]*[!@#$%^&*()\d])[a-z!@#$%^&*()\d]{8}$/i;	

	document.getElementById("email_msg").innerHTML ="";
    document.getElementById("pswd_msg").innerHTML ="";

	if (a==null || a==""||!email_v.test(a))
		{	   
		document.getElementById("email_msg").innerHTML="Invalid email";
		result = false;
		}
	
	if (b==null || b==""||!pswd_v.test(b))
		{	   
			document.getElementById("pswd_msg").innerHTML="Invalid password";
			result = false;
		}
	if(result == false )
        {    
            event.preventDefault();
        }
    else{
			alert("Successful login");
		}
}

function AccessForm(event) {
	
	var a = document.forms.Access.access.value;
	
	document.getElementById("access_msg").innerHTML ="";
	
	if (a.length != 6){
		document.getElementById("access_msg").innerHTML ="Access code must be 6 characters";
		event.preventDefault();
	}	
}

function MessageForm(event) {
	
	var elements = event.currentTarget;
	
	var a = elements[0].value;
	var b = elements[1].value;
	var c = elements[2].value;
	var d = elements[3].value;
	
	var result = true;
	
	var access_v = /^[a-zA-Z0-9]{6}$/;
	
	document.getElementById("message_msg").innerHTML ="";
    document.getElementById("access_msg").innerHTML ="";
    document.getElementById("date_msg").innerHTML ="";
	document.getElementById("time_msg").innerHTML ="";
	
	if (a==null || a=="") {	   
		document.getElementById("message_msg").innerHTML="Message is empty.";
		result = false;
    }

	if (b==null || b==""||!access_v.test(b)) {	   
	   document.getElementById("access_msg").innerHTML="Access code is empty or invalid";
       result = false;
	}
	if (c==null || c=="") {	   
	   document.getElementById("date_msg").innerHTML="Empty or invalid date format.";
       result = false;
	}
	if (d==null || d=="") {
		document.getElementById("time_msg").innerHTML="Empty or invalid time format.";
		result = false;
	}
	if(result == false ){    
            event.preventDefault();
        }
}


















