<?php 
	session_start();

	$db = new mysqli("localhost", "", "", ""); //sql stuff goes here
   if ($db->connect_error)
   {
       die ("Connection failed: " . $db->connect_error);
   }
	$email = $_SESSION["email"];
	
	$q = "UPDATE user SET logged_in = 'false' WHERE email = '$email'";
       
	$r = $db->query($q);
	$_SESSION = array();
	session_destroy();
	
	header("Location: homepage.php"); //change to homepage
	exit();
?>


 <table>
            <tr>
               <td rowspan="2">
                  <img src="<?php echo $logged_in_user["avatar"]; ?>" alt="image" class="avatar" />
               </td>
              	<td><?php echo $logged_in_user["username"];?></td>
            </tr>
			<tr>
			<form id="logout" method="post" action="logout.php">
				<td><input type="submit" name="logout" value="Logout" style="float:left"/></td>
			</form>
			</tr>
         </table>