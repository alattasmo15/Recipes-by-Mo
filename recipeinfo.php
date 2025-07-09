<?php
//Restrict access and redirect if necessary
require('logincheck.php');

//Connect to the database
require('mysqli_connect.php');

//Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    //Read the posted data from the form into local variables:
    $title = mysqli_real_escape_string($dbc, trim($_POST['title']));
    $ingredients = mysqli_real_escape_string($dbc, trim($_POST['ingredients']));
    $instructions = mysqli_real_escape_string($dbc, trim($_POST['instructions']));
    $cookTime = mysqli_real_escape_string($dbc, trim($_POST['cook_time']));
	$categoryID = $_POST['category_ID'];

	//Read the session data into local variables
	$userID = $_SESSION['user_ID'];
	$image = $_SESSION['image_url'];

	//Add the new recipe to the database:
    $q1 = "INSERT INTO recipes_Table (user_ID, title, ingredients, instructions, cook_time, category_ID, image_url) VALUES ('$userID', '$title', '$ingredients', '$instructions', '$cookTime', $categoryID, '$image')";
    $r1 = @mysqli_query($dbc, $q1);

	//Send user back to Home Page:
	redirect_user('main.php');
}

//Query the database for categories
$q2 = "SELECT category_ID, category_Name FROM categories_Table ORDER BY CASE category_Name WHEN 'Breakfast' THEN 1 WHEN 'Lunch' THEN 2 WHEN 'Dinner' THEN 3 
WHEN 'Dessert' THEN 4 ELSE 5 END";
       $r2 = @mysqli_query($dbc, $q2);
$numRows2 = mysqli_num_rows($r2);
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Add a Recipe: Recipe Information</title>
<link href="cis231.css" rel="stylesheet" type="text/css">
</head>

<body>
<div class="center">

  <h2 class="center">Welcome <?php echo $_SESSION['first_Name']; ?>!</h2>
  <h3 class="center">Complete the following information for the recipe you want to add.</h3>
</div>
<p>&nbsp;</p>
<form action="recipeinfo.php" method="post">
  <table class="center">
    <tbody>
    <tr>
      <td class="right">
        <label for="title">Recipe Title:</label>
      </td>
      <td class="left">
      	<input type="text" name="title" id="title" value="" size="40" maxlength="100" autofocus>
      </td>
    </tr>
    <tr>
      <td class="right">
        <label for="category_ID">Category:</label>
      </td>
      <td class="left">
        <select name="category_ID" id="category_ID">
<?php 
while($row = mysqli_fetch_array($r2))
{
?>
          <option value="<?php echo $row['category_ID']; ?>" ><?php echo $row['category_Name']; ?></option>
<?php
}  //End while loop to build select
?>
        </select>
      </td>
    </tr>
    <tr>
      <td class="right">
        <label for="cook_time">Cook Time:</label>
      </td>
      <td class="left">
        <input type="text" name="cook_time" id="cook_time" value="" size="10">
      </td>
    </tr>
    <tr>
      <td class="right">
        <label for="ingredients">Ingredients:</label>
      </td>
      <td class="left">
        <textarea name="ingredients" id="ingredients" cols="80" rows="5"></textarea>
      </td>
    </tr>
    <tr>
      <td class="right">
        <label for="instructions">Instructions:</label>
      </td>
      <td class="left">
        <textarea name="instructions" id="instructions" cols="80" rows="8"></textarea>
      </td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td class="left">
        <input type="submit" id="submit" value="Add Recipe">
      </td>
    </tr>
    </tbody>
  </table>
</form>
<p>&nbsp;</p>
</body>
</html>

<?php
//Free record sets and close database connections
mysqli_free_result($r2);
mysqli_close($dbc);
?>
