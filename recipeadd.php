<?php
//Restrict access and redirect if necessary
require('logincheck.php');

//Initialize error flag and error message
$error = false;
$errorMsg = "";

//Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	//Check for an uploaded file:
	if (isset($_FILES['image']))
	{
		//Build array of allowable MIME types
		$allowed = ['image/gif', 'image/pjpeg', 'image/jpeg', 'image/JPG', 'image/X-PNG', 'image/PNG', 'image/png', 'image/x-png'];
		
		//Validate the type. Should be GIF, JPEG, or PNG.
		if (in_array($_FILES['image']['type'], $allowed))
		{
			// Move the file over.
			if (move_uploaded_file($_FILES['image']['tmp_name'], "images/{$_FILES['image']['name']}"))
			{
				//Save image filename in session data:
				$_SESSION['image_url'] = $_FILES['image']['name'];
				
				//Redirect user to next page for remainder of recipe info:
    			redirect_user('recipeinfo.php');
			} // End of move IF.
		}
		else //Invalid type.
		{ 
			//Set error flag
			$error = true;
			$errorMsg = "Please upload a GIF, JPEG, or PNG image.<br>";
		}
	} //End of isset($_FILES['image']) IF.

	//Check for an error:
	if ($_FILES['image']['error'] > 0)
	{
		//Set error flag
		$error = true;
			
		$errorMsg .= "The file could not be uploaded because: <strong>";
		// Print a message based upon the error.
		switch ($_FILES['image']['error']) {
			case 1:
				$errorMsg .= "The file exceeds the upload_max_filesize setting in php.ini.";
				break;
			case 2:
				$errorMsg .= "The file exceeds the MAX_FILE_SIZE setting in the HTML form.";
				break;
			case 3:
				$errorMsg .= "The file was only partially uploaded.";
				break;
			case 4: //No file was uploaded
				//Set the filename in session data to NULL:
				$_SESSION['image_url'] = "";
				//Redirect user to next page for remainder of recipe info:
				redirect_user('recipeinfo.php');
				break;
			case 6:
				$errorMsg .= "No temporary folder was available.";
				break;
			case 7:
				$errorMsg .= "Unable to write to the disk.";
				break;
			case 8:
				$errorMsg .= "File upload stopped.";
				break;
			default:
				$errorMsg .= "A system error occurred.";
				break;
		} // End of switch.
		$errorMsg .= "</strong>";
	} // End of error IF.
	
	// Delete the file if it still exists:
	if (file_exists($_FILES['image']['tmp_name']) && is_file($_FILES['image']['tmp_name']))
	{
		unlink($_FILES['image']['tmp_name']);
	}
} //End of the POST If.
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Add a Recipe: Upload an Optional Image</title>
<style>
.error {
	font-weight: bold;
	color: #C00;
}
</style>
</head>
<body>
<h2 class="center">Welcome <?php echo $_SESSION['first_Name']; ?>!</h2>
<h2 class="center">Add a Recipe!</h2>
<h3 class="center">Select an optional GIF, JPEG, or PNG image (2MB or smaller) for your recipe.</h3>
<?php
//If there were upload errors
if ($error)
{
	echo "<p class=\"center error\">$errorMsg</p>";
}
?>
<form enctype="multipart/form-data" action="recipeadd.php" method="post">
  <div class="center">
    <input type="hidden" name="MAX_FILE_SIZE" value="2097152">
    <p>
      <label for="image">Choose an image file to upload:</label> 
      <input type="file" name="image" id="image">
    </p>
  </div>
  <div class="center">
    <input type="submit" name="submit" id="submit" value="Next">
  </div>
</form>
</body>
</html>
