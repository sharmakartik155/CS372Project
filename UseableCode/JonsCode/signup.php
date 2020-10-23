<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="../style.css">
    <title>SignUp Page</title>
    <script type="text/javascript" src="js/validate.js"></script>
    <style>
         .err_msg{ color:red;} //add this to css file?
</style>
  </head>
<?php
$validate = true;
$error = "";
$reg_Email = "/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/";  
$reg_Pswd = "/^(?=.*\d).{8,}$/"; //may want to change the Regex on this. currently it must be 8 characters with one number
$email = "";

if (isset($_POST["submitted"]) && $_POST["submitted"])
{
    $email = trim($_POST["email"]);
    $user = trim($_POST["uname"]);
    $password = trim($_POST["password"]);
       
    $db = new mysqli("localhost", "", "", ""); //need to add the proper username and password for the SQL stuff
    if ($db->connect_error)
    {
        die ("Connection failed: " . $db->connect_error);
    }
   
    $q1 = "SELECT * FROM user WHERE email = '$email'";
    $r1 = $db->query($q1);

   // if the email address is already taken.
    if($r1->num_rows > 0)
    {
        $validate = false;
    }
    else
    {
        $emailMatch = preg_match($reg_Email, $email);
        if($email == null || $email == "" || $emailMatch == false)
        {
            $validate = false;
        }
        
        $userMatch = preg_match($reg_User, $user);
        
        if($user == null || $user == "" || $userMatch == false)
        {
            $validate = false;
        }
         
        $pswdLen = strlen($password);
        $pswdMatch = preg_match($reg_Pswd, $password);
        if($password == null || $password == "" || $pswdLen< 8 || $pswdMatch == false)
        {
            $validate = false;
        }
        
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["avatar"]["name"]);
		echo $target_file;
        $avatar = $target_file;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["avatar"]["tmp_name"]);
            if($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
        }
        
        // Check if file already exists. May want to change this if we want people to be able to have the same picture
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }
        // Check file size
        if ($_FILES["avatar"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
                echo "The file ". basename( $_FILES["avatar"]["name"]). " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
    }
}
        
    }     
    if($validate == true)
    {
        $date = date("Y-m-d H:i:sa");

    $q2 = "INSERT INTO user (email, username, password, avatar, date_created)
    VALUES ('$email', '$user', '$password', '$avatar', '$date')";
       
        $r2 = $db->query($q2);
        
        if ($r2 === true)
        {
            header("Location: assignment.php");
            $db->close();
            exit();
        }
    }
    else
    {
        $error = "email address is not available. Signup failed.";
        $db->close();
    }
}

?>
  <body>
    <h1>Sign Up Page</h1>
    <form id="formSignup" method="post" enctype="multipart/form-data">
	<input type="hidden" name="submitted" value="1"/>
    <table>
      <tr>
        <td>
          <label id="email_msg" class="err_msg"></label>
        </td>
      </tr>
      <tr>
        <td>Email:</td>
        <td>
          <input type="text" name="email" size="30" />
        </td>
		<td><?php echo $error; ?></td>
      </tr>
      <tr>
        <td>
          <label id="uname_msg" class="err_msg"></label>
        </td>
      </tr>
      <tr>
        <td>Username:</td>
        <td>
          <input type="text" name="uname" size="30" />
        </td>
      </tr>
      <tr>
        <td>
          <label id="pswd_msg" class="err_msg"></label>
        </td>
      </tr>
      <tr>
        <td>Password:</td>
        <td>
          <input type="password" name="password" size="30" />
        </td>
      </tr>
      <tr>
        <td>
          <label id="pswdr_msg" class="err_msg"></label>
        </td>
      </tr>
      <tr>
        <td>Confirm Password:</td>
        <td>
          <input type="password" name="pwdr" size="30" />
        </td>
      </tr>
	   <tr>
		<td>Avatar:</td>
		<td>
			<input type="file" name="avatar" id="avatar">
		</td>
		<td>
			<label id="photo_msg" class="err_msg"></label>
		</td>
	  </tr>
    </table>
    <br />
    <input type="submit" value="Sign up" /> 
    <input type="reset" value="Reset" /></form>
    <script type="text/javascript" src="js/SignUp-r.js"></script>
    <p>
      <a href="">Back to home page</a> //need to add a link here
    </p>
  </body>
</html>
