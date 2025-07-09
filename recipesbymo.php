<?php
//Restrict access and redirect if necessary
require('logincheck.php');

//Connect to the database
require('mysqli_connect.php');

//Query the database for recipes matching the chosen category
$recipe = "";
$categoryName = "No";

if (isset($_GET['category_ID']))
{
    $recipe = $_GET['category_ID'];

    $q1 = "SELECT category_Name FROM categories_Table WHERE category_ID=$recipe";
    $r1 = @mysqli_query($dbc, $q1);
    $row1 = mysqli_fetch_array($r1, MYSQLI_ASSOC);
	$categoryName = $row1['category_Name'];
	
	$q2 = "SELECT recipe_ID, title, cook_time, ingredients, image_url FROM recipes_Table WHERE category_ID=$recipe ORDER BY title ASC";
    $r2 = @mysqli_query($dbc, $q2);
    $numRows2 = mysqli_num_rows($r2);
}
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title><?php echo $categoryName; ?> Recipes</title>
<link href="cis231.css" rel="stylesheet" type="text/css">
</head>

<body>

<h2 class="center">Welcome <?php echo $_SESSION['first_Name']; ?>!</h2>
<?php
if ($recipe == "") //No data from URL append (GET)
{
?>
    <h2 class="center">No category selected.</h2>
    <p class="center">Please return to make a <a href="main.php">category selection</a>.</p>
<?php
}
elseif ($numRows2 == 0) //No recipes according to category selection
{
?>
    <h2 class="center">No recipes in category &quot;<?php echo $categoryName; ?>&quot;.</h2>
    <p class="center">Please return to make a different <a href="main.php">category selection</a>.</p>
<?php
}
else //There are results
{
?>
    <h2 class="center">Here are the recipes that match the category &quot;<?php echo $categoryName; ?>&quot;</h2>
    <p>&nbsp;</p>
    <div class="center">
    <table border="1">
      <thead>
        <tr>
          <th width="250">Recipe Title</th>
          <th width="400">Ingredients</th>
          <th width="150">Cook Time</th>
          <th width="400">Recipe Image</th>
        </tr>
      </thead>
      
      <tbody>
<?php
while ($row2 = mysqli_fetch_array($r2, MYSQLI_ASSOC))
{
?>
      <tr>
        <td><a href="recipedetails.php?recipe_ID=<?php echo $row2['recipe_ID']; ?>"><?php echo $row2['title']; ?></a></td>
        <td><?php echo $row2['ingredients']; ?></td>
        <td><?php echo $row2['cook_time']; ?></td>
        <td><img src="images/<?php echo $row2['image_url']; ?>" alt="recipe image for &apos;<?php echo $row2['title']; ?>&apos;"
        style="width:200px; height:200px; object-fit:cover;"
        ></td>
        
      </tr>
<?php
}
?>
      </tbody>
    </table>
    </div>
    <p>&nbsp;</p>
    <p class="center">Return to the <a href="main.php">Home Page</a>.</p>
<?php
}
?>
</body>
</html>

<?php
//Free record sets and close database connections
if ($recipe != "") //There was data from URL append (GET)
{
	mysqli_free_result($r1);
	mysqli_free_result($r2);
}

mysqli_close($dbc);
?>