<?php
//Restrict access and redirect if necessary
require('logincheck.php');

//Connect to the database
require('mysqli_connect.php');

//Read the session data into local variables:
$uid = $_SESSION['user_ID'];

//Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	//Read the posted data from the form into local variables:
    $fn = mysqli_real_escape_string($dbc, trim($_POST['first_Name']));
    $ln = mysqli_real_escape_string($dbc, trim($_POST['last_Name']));
	
	//Update the password in the database:
	$q1 = "UPDATE users_Table SET first_Name='$fn', last_Name='$ln' WHERE user_ID='$uid'";
	$r1 = @mysqli_query($dbc, $q1);

	//Free record sets and close database connections
	
	mysqli_close($dbc);

	//Redirect:
	redirect_user('main.php');
}
else  //Query the database to get data for the user
{
	//Query database for user information based on user_ID from session data
	$q2 = "SELECT first_Name, last_Name FROM users_Table WHERE user_ID='$uid'";
	$r2 = @mysqli_query($dbc, $q2);
	$row2 = mysqli_fetch_array($r2, MYSQLI_ASSOC);
	
	//Assign values to local variables
	$fn = $row2['first_Name'];
	$ln = $row2['last_Name'];
}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Edit your Profile</title>
<link href="cis231.css" rel="stylesheet" type="text/css">
</head>

<body>
<div class="center">

  <h2 class="center">Welcome <?php echo $_SESSION['first_Name']; ?>!</h2>
  <h3 class="center">Edit your profile here.</h3>
</div>
<div>
  <form action="editprofile.php" method="post">
    <table class="center">
      <tr>
        <td class="right">User ID:</td>
        <td class="left"><?php echo $uid; ?></td>
      </tr>
      
      <tr>
        <td class="right">
          <label for="first_Name">First Name:</label>
        </td>
        <td class="left">
          <input type="text" name="first_Name" id="first_Name" value="<?php echo $fn; ?>" size="10" maxlength="10" required>
        </td>
      </tr>
      
      <tr>
        <td class="right">
          <label for="last_Name">Last Name:</label>
        </td>
        <td class="left">
          <input type="text" name="last_Name" id="last_Name" value="<?php echo $ln; ?>" size="15" maxlength="15" pattern=".{3,15}" required>
        </td>
      </tr>
      
      <tr>
        <td>&nbsp;</td>
        <td class="left">
          <input type="submit" value="Update">
        </td>
      </tr>
     </tbody> 
    </table>
  </form>
  <p class="center">Click <a href="passwordreset.php">here</a> to reset your password. | Or return to the <a href="main.php">Home Page</a>.</p>
</div>
</body>
</html>
<?php
//Free record sets and close database connections
mysqli_free_result($r2);
mysqli_close($dbc);
?>