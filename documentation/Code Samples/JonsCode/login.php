<?php

$validate = true;
$reg_Email = "/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/";
$reg_Pswd = "/^(\S*)?\d+(\S*)?$/";

$email = "";
$error = "";

if (isset($_POST["email"]) && $_POST["password"])
{
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    
    $db = new mysqli("localhost", "", "", ""); //sql stuff goes here
    if ($db->connect_error)
    {
        die ("Connection failed: " . $db->connect_error);
    }

	$q = "SELECT * FROM user where email = '$email' AND password = '$password'";
       
    $r = $db->query($q);
    $row = $r->fetch_assoc();
    if($email != $row["email"] && $password != $row["password"])
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
        
        $pswdLen = strlen($password);
        $passwordMatch = preg_match($reg_Pswd, $password);
        if($password == null || $password == "" || $pswdLen < 8 || $passwordMatch == false)
        {
            $validate = false;
        }
    }

    if($validate == true)
    {

        session_start();
		
        $_SESSION["email"] = $row["email"];

		$q = "UPDATE user SET logged_in = 'true' WHERE email = '$email'";
       
		$r = $db->query($q);

        header("Location: homepage.php"); //CHANGE THIS TO HOME PAGE
        $db->close();
        exit();
    }
    else 
    {
        $error = "The email/password was incorrect";
        $db->close();
    }
}
?>


<form id ="Login" method="post">
	<input type="hidden" name="submitted" value="1"/>
        <table>
          <tr>
            <th>Email</th>
            <th>Password</th>
            <th>
              <a href="signup.php">Sign Up</a>
            </th>
          </tr>
          <tr>
            <td>
              <input type="text" name="email" size="12" />
            </td>
            <td>
              <input type="password" name="password" size="12" />
            </td>
            <td>
              <input type="submit" value="Login" />
            </td>
          </tr>
		  <tr>
		  <td  class="err_msg" colspan="3" style="text-align:left"><?php echo $error; ?></td>
		  </tr>
        </table>
      </form>
      <script type="text/javascript" src="js/Login-r.js"></script>