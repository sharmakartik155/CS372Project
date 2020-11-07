function validateForm() {

    var empty = "";
    var warn = "";
    var rt = true;
    var same = false;
    var str_user_inputs = "";

//--NAME--//

    var fullname = document.forms.sign_up_form.fullname.value;

    if (fullname == null || fullname == "") {
        empty += " * Name\n";
        rt = false;
    }
    else if (fullname.length > 80) {
        warn += "Name must be less than 80 characters long.";
        rt = false;
    }
    else { // if everything is okay, then collect Firstname
        str_user_inputs += "Name: " + fullname + "\n";
    }
    
//--EMAIL--//

    var email = document.forms.sign_up_form.email.value;

    if (email == null || email == "") {
        empty += " * Email\n";
        rt = false;
    }
    else if (email.length > 60) {
        warn += "Email must be less than 60 characters long.";
        rt = false;
    }
    else { // if everything is okay, then collect Firstname
        str_user_inputs += "Email: " + email + "\n";
    }

//--ALIAS--//

    var alias = document.forms.sign_up_form.alias.value;

    if (alias == null || alias == "") {
        empty += " * Alias\n";
        rt = false;
    }
    else if (alias.length > 60) {
        warn += "Alias must be less than 20 characters long.";
        rt = false;
    }
    else { // if everything is okay, then collect Firstname
        str_user_inputs += "Alias: " + alias + "\n";
    }

//--USERNAME--//

    var username = document.forms.sign_up_form.username.value;

    if (username == null || username == "") {
        empty += " * Username\n";
        rt = false;
    }
    else if (username.length > 40) {
        warn += "Username must be less than 40 characters long.";
        rt = false;
    }
    else { // if everything is okay, then collect Firstname
        str_user_inputs += "Username: " + username + "\n";
    }
    
//--PASSWORD--//

    var password = document.forms.sign_up_form.password.value;

    if (password == null || password == "") {
        empty += " * Password\n";
        rt = false;
    }
    else if (password.length < 8) {
        warn += " * Password must be at least 8 characters long.";
        rt = false;
    }
    else {
        str_user_inputs += "Password: " + "********" + "\n";
    }

//--VERIFY--//

    var password2 = document.forms.sign_up_form.password2.value;

    if (password2 == null || password2 == "") {
        empty += " * Verify\n";
        rt = false;
    }

if (password == password2) {
	same = true;
} else {
	same = false;
	rt = false
}


    //--------------------warning---------------------

    if (rt == false) {
        var message = "";
        if (empty != "")
        {
            message += "The following fields need to be completed:\n" + empty + "\n";
        }
        if (warn != "")
        {
            message += "Please fix the following errors:\n" + warn + "\n";
        }
        if (same != true) {
        	message += " * Your password verification did not match.\n";
        }
        alert(message);
        return false;

    }
    else {

        // display the user inputs:

        alert(str_user_inputs);



        // when return true, we send an HTTP request 
        // and call the .php at the server side
        // Here, we return false, and do not send an HTTP request 
        // to the server, since we didn't learn PHP yet.  

        // should be: return true; when using PHP
        return false;

    }//end of else for warning

}//end of function validateForm()
