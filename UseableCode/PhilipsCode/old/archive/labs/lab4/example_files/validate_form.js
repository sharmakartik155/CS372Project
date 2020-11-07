function validateForm() {

    var empty = "";
    var warn = "";
    var rt = true;
    var str_user_inputs = "";

    //-----------------Firstname --------------------------

    var fname = document.forms.myForm.fname.value;

    // validating the input textbox of Firstname

    if (fname == null || fname == "") {

        empty += " * First name\n";
        rt = false;

    }
    else if (fname.length > 50) {
        warn += "First name must be less than 50 characters long.";
        rt = false;

    }
    else { // if everything is okay, then collect Firstname

        str_user_inputs += "First name: " + fname + "\n";

    }

    

    //--------------------Lastname-------------------------
    // add code here for the Lastname
    // validating the input textbox of Lastname

    var lname = document.forms.myForm.lname.value;

    // validating the input textbox of Firstname

    if (lname == null || lname == "") {

        empty += " * Last name\n";
        rt = false;

    }
    else if (lname.length > 5) {
        warn += "Last name must be less than 5 characters long.";
        rt = false;

    }
    else { // if everything is okay, then collect Firstname

        str_user_inputs += "Last name: " + lname + "\n";

    }







    //-------------------Gender radio -------------------
    // add code here to collect radio button

    var  gender = document.forms.myForm.gender;
    var  gen_val = "";

    for (var i=0; i < gender.length;i++)
    {
      if (gender[i].checked){
        gen_val=gender[i].value;
        break;
      }
    }
    
    if(i>=gender.length)
    {
      empty += " * Gender\n";
      warn += " * select a gender \n";
      rt= false;
    }
    else
    {
      str_user_inputs +="Gender: "+gen_val+"\n";
    }






    // -----------------Nationality-----------------------

    // add code here for the drop down list Nationality

    
    var dplst_e = document.forms.myForm.nationality;

    var s_index = dplst_e.selectedIndex;

    // Comparison value 
    if(s_index==0)
    { 
      empty += " * Nationality \n";             
      warn += " * select a nationality \n";
      rt = false;

    }
    else
    {
      //  Obtain the value of the selected option
      var strUser = dplst_e.options[s_index].value;

      str_user_inputs +="Nationality: "+strUser+"\n";
    }








    //------------------Address---------------------------

    var x = document.forms.myForm.address.value;

    // validating the input textbox of address







    //---------------Medical History-----------------

    // add code here to do the following
    // step1: validate checkbox, display warning if invalid
    // step2: if pass validation, collect user choices



    // step1: validate checkbox
    var med = document.forms.myForm.med_chk;

    //validate checkbox 

    for (var i=0;i < med.length;i++){
      if (med[i].checked){
        break;
      }
    }
    if(i>=med.length)
    {
     empty += " * Medical History \n";
     warn += " * Please select N/A if you have no Medical History to report \n";
     rt = false;
    }


    else {//if pass validation, then collect user choices

           
     str_user_inputs +="Medical History: ";
     for (var j=0; j<med.length; j++){
       
  	if (med[j].checked){
          	
  		str_user_inputs +=med[j].value+" ";
         	}//if
     }//for

     str_user_inputs +="\n";
    }//else










   













    //--------------Current Medication--------------------
    // check current medication radio buttons

    var med = document.forms.myForm.CurrentMed;

    for (var i = 0; i < med.length; i++) {
        if (med[i].checked) {
            break;
        }
    }

    if (i >= med.length) {
        empty += " * Are you currently taking any medication?\n";
        warn += " * select Yes or No for your current medication.\n";
        rt = false;
    }

    else {

        str_user_inputs += "Are you currently taking any medication? " + med[i].value + "\n";

    }



    // Check medication history textarea 

    // add if statement here to:

    // If taking medication is checked Yes, display Medication history can't be empty. 

    var x = document.forms.myForm.medicationNotes.value;
    console.log('testing...');
    if (med[0].checked && (x == null || x == ""))
    {   
    	empty += " * Medication list empty\n";
    	warn += " * list your medications\n";
    	rt = false;
    }








    // add code here to: 

    // If taking medication is checked No, current medication must be empty.
    if (med[1].checked && (x != null && x != ""))
    {   
    	empty += " * You said no medications, but list is not empty\n";
    	warn += " * click yes if you are taking medications, or empty the list\n";
    	rt = false;
    }

    
    if (x != null && x != "")
    {
    	str_user_inputs += "Medications: " + x;
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
            message += "Please also fix the following errors:\n" + warn + "\n";
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
