<?php
//Restrict access and redirect if necessary
require('logincheck.php');

//Connect to the database
require('mysqli_connect.php');

//Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    //Read the posted data from the form into local variables:

    $text = mysqli_real_escape_string($dbc, trim($_POST['comment_Text']));
	
    //Read the session data into local variables:
    $uid = $_SESSION['user_ID'];
	$recipe_ID = intval($_POST['recipe_ID']);

    //Add the new comment to the database:
    $q1 = "INSERT INTO comments_Table (user_ID, recipe_ID, comment_Text) VALUES ('$uid', $recipe_ID, '$text')";
    $r1 = @mysqli_query($dbc, $q1);
	
	//Reload page:
	$page = 'comments.php?recipe_ID=' . $recipe_ID;
    redirect_user($page);
}

//Query the database for recipes matching the chosen category
$recipe = "";
$title = "No";

if (isset($_GET['recipe_ID']))
{
    //Get the recipe ID from the URL and add to session data
	$recipe = $_GET['recipe_ID'];
	$_SESSION['recipe_ID'] = $recipe;

    //Query database for recipe information based on recipe_ID
	$q2 = "SELECT title, category_ID, cook_Time, image_url FROM recipes_Table WHERE recipe_ID=$recipe";
    $r2 = @mysqli_query($dbc, $q2);
    $row2 = mysqli_fetch_array($r2, MYSQLI_ASSOC);
	
	//Extract recipe information to local variables
	$title = $row2['title'];
	$cat = $row2['category_ID'];
	$cook_Time = $row2['cook_Time'];
	$image_url = $row2['image_url'];
	
	//Query database to find comments based on recipe_ID, with comments in chronological date order
	$q3 = "SELECT user_ID, comment_Text, MONTHNAME(comment_Date) AS month, DAY(comment_Date) AS day, YEAR(comment_Date) AS year FROM comments_Table WHERE recipe_ID=$recipe ORDER BY comment_Date ASC";
    $r3 = @mysqli_query($dbc, $q3);
    $numRows3 = mysqli_num_rows($r3);
	
	 //Query database for category name based on category_ID
	$q4 = "SELECT category_Name FROM categories_Table WHERE category_ID=$cat";
    $r4 = @mysqli_query($dbc, $q4);
    $row4 = mysqli_fetch_array($r4, MYSQLI_ASSOC);
	
	//Extract category name to local variable
	$category_Name = $row4['category_Name'];
}
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title><?php echo $title; ?> Comments</title>
<link href="cis231.css" rel="stylesheet" type="text/css">
</head>

<body>

<?php
if ($recipe == "") //No data from URL append (GET)
{
?>
<h2 class="center">No recipe selected.</h2>
<p class="center">Please return to the <a href="main.php">Home Page</a> to make a selection.</p>
<?php
}
else //Data exists from URL append
{
?>
<p>&nbsp;</p>
<?php
	if ($numRows3 == 0) //No comments according to recipe selection
	{
?>
<h3 class="center">There are no comments on <em><?php echo $title; ?></em> (Cook Time: <?php echo $cook_Time; ?>)</h3>
<?php
	}
	else //There are comments
	{
?>
<h3 class="center">Most-recent comments on <em><?php echo $title; ?></em> (Cook Time: <?php echo $cook_Time; ?>)</h3>
<p>&nbsp;</p>
<table border="1">
  <thead>
    <tr>
      <th width="362">User</th>
      <th width="460">Comment</th>
    </tr>
  </thead>
  <tbody>
    <?php
while ($row3 = mysqli_fetch_array($r3, MYSQLI_ASSOC))
{
?>
    <tr>
  <td>
    <?php echo $row3['user_ID']; ?><br>
    Posted On:<br>
    <?php echo $row3['month']; ?> <?php echo $row3['day']; ?>, <?php echo $row3['year']; ?>
  </td>
  <td>
    <?php echo nl2br($row3['comment_Text']); ?>
  </td>
</tr>
    <?php
}
?>
  </tbody>
</table>
<?php
}
?>
<p>&nbsp;</p>
<form action="comments.php" method="post"> 
       <input type="hidden" name="recipe_ID" value="<?php echo $recipe; ?>">
  <table>
    <tbody>
      <tr>
      </tr>
      <tr>
  
        <td class="right"><label for="comment_Text">Add another comment:</label></td>
        <td class="left"><textarea name="comment_Text" id="comment_Text" cols="80" rows="10"></textarea></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td class="left"><input type="submit" value="Add a Comment"></td>
        
      </tr>
    </tbody>
  </table>
</form>
<p>&nbsp;</p>
<p class="center">Please return to the <a href="recipesbymo.php?category_ID=<?php echo $cat; ?>">&quot;<?php echo $category_Name; ?>&quot; category</a> to make a different recipe selection. | Or return to the <a href="main.php">Home Page</a>.</p>
<?php
}
?>
</body>
</html>
<?php
//Free record sets and close database connections
if ($recipe != "") //There was data from URL append (GET)
{
	mysqli_free_result($r2);
	mysqli_free_result($r3);
	mysqli_free_result($r4);
}

mysqli_close($dbc);
?>