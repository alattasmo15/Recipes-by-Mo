<?php
//Restrict access and redirect if necessary
require('logincheck.php');

//Connect to the database
require('mysqli_connect.php');

//Initialize error flag and error message
$error = false;
$errorMsg = "";

//Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	//Read the posted data from the form into local variables:
    $old = mysqli_real_escape_string($dbc, $_POST['oldPasswd']);
    $new = mysqli_real_escape_string($dbc, $_POST['user_Password']);
    
	//Read the session data into local variables:
    $uid = $_SESSION['user_ID'];

	//Check validity of user's current (old) password
	$q1 = "SELECT user_ID FROM users_Table WHERE user_ID='$uid' AND user_Password=SHA1('$old')";
	$r1 = @mysqli_query($dbc, $q1);
	
	//Check the result:
	if (mysqli_num_rows($r1) == 1)
	{
		//Update the password in the database:
		$q2 = "UPDATE users_Table SET user_Password=SHA1('$new') WHERE user_ID='$uid'";
		$r2 = @mysqli_query($dbc, $q2);

    	//Free record sets and close database connections
		mysqli_free_result($r1);
		mysqli_close($dbc);

    	//Redirect:
    	redirect_user('main.php');
	}
	else //Invalid old password
	{
		//Set error flag
		$error = true;
			
		$errorMsg = "Invalid current password. Please re-enter and try again.";
	}
	
	//Free record sets
	mysqli_free_result($r1);
}

//Close database connections
mysqli_close($dbc);
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Registration Form</title>
<link href="cis231.css" rel="stylesheet" type="text/css">
<style>
.error {
	font-weight: bold;
	color: #C00;
}
</style>
<!--JavaScript code to verify the two password fields match -->
<script type="text/javascript">
function checkPasswd()
{
    //Store the password field objects into variables
    var passwd1 = document.getElementById("user_Password");
    var passwd2 = document.getElementById("user_Password2");
	
    //Store the Confimation Message Object
    var message = document.getElementById("confirmMessage");
	
    //Set the colors we will be using
    var goodColor = "#66cc66";
    var badColor = "#ff6666";
	
    //Compare the values in the password field 
    //and the confirmation field
    if (passwd1.value == passwd2.value) //The passwords match 
    {
        //Set the color to the good color and
        //inform the user that they have entered the correct password 
        passwd2.style.backgroundColor = goodColor;
        message.style.color = goodColor;
        message.innerHTML = "Passwords match!"
    }
    else //The passwords do not match
    {
        //Set the color to the bad color and
        //notify the user
        passwd2.style.backgroundColor = badColor;
        message.style.color = badColor;
        message.innerHTML = "Passwords must match!"
    }
}
</script>
</head>

<body>
<div class="center">
  <p class="center"><img src="logo.png" width="808" height="146" alt="logo"></p>
  <h2 class="center">Welcome <?php echo $_SESSION['first_Name']; ?>!</h2>
  <h3 class="center">Reset your password here.</h3>
</div>
<div class="center">
  <p>Please confirm your credentials by entering your current password.  And then enter a new password. It must be between 6 and 12 characters, and include at least 1 upper case letter, 1 lowercase letter, 1 number and 1 of the special characters ! @ # $ & *. All fields are required.</p>
</div>
<?php
//If there were upload errors
if ($error)
{
	echo "<p class=\"center error\">$errorMsg</p>";
}
?>
<form action="passwordreset.php" method="post">
  <table>
    <tbody>
      <tr>
        <td class="right">
          <label for="oldPasswd">Confirm Old Password:</label>
        </td>
        <td class="left">
          <input type="password" name="oldPasswd" id="oldPasswd" size="12" maxlength="12" required autofocus></td>
      </tr>
      
      <tr>
        <td class="right">
          <label for="user_Password">New Password:</label>
        </td>
        <td class="left">
          <input type="password" name="user_Password" id="user_Password" value="" size="12" pattern="^(?=.*[A-Z])(?=.*[!@#$&*])(?=.*[0-9])(?=.*[a-z]).{6,12}$" title="The password must be between 6 and 12 characters, and include at least 1 upper case letter, 1 lowercase letter, 1 number and 1 of the special characters ! @ # $ & *" maxlength="12" required>
        </td>
      </tr>
      
      <tr>
        <td class="right">
        	<label for="user_Password2">Re-enter New Password:</label>
        </td>
        <td class="left">
          <input type="password" name="user_Password2" id="user_Password2" value="" size="12" min="6" maxlength="12" required onkeyup="checkPasswd(); return false;">
          <span id="confirmMessage" class="confirmMessage"></span>
        </td>
      </tr>
      
      <tr>
        <td class="right">
       	  <input type="reset" name="reset" id="reset" value="Reset">
        </td>
        <td class="left">
          <input type="submit" name="submit" id="submit" value="Submit">
        </td>
      </tr>
    </tbody>
  </table>
</form>
<p class="center">Return to the <a href="main.php">Home Page</a>.</p>
</div>
</body>
</html>