<?php
//Restrict access and redirect if necessary
require('logincheck.php');

//Connect to the database
require('mysqli_connect.php');

$search = "";
$numRows1 = 0;
$r1 = null;

//Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['searchText'])) {
        $search = mysqli_real_escape_string($dbc, trim($_POST['searchText']));

        $q1 = "SELECT recipe_ID, title, cook_time, instructions, image_url FROM recipes_Table WHERE title LIKE '%$search%' ORDER BY title ASC";

        $r1 = @mysqli_query($dbc, $q1);
        $numRows1 = mysqli_num_rows($r1);
    }
}
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Recipe Search</title>
<link href="cis231.css" rel="stylesheet" type="text/css">
</head>

<body>

<h2 class="center">Welcome <?php echo $_SESSION['first_Name']; ?>!</h2>

<form action="recipesearch.php" method="post">
  <div class="center">
    <p>
      <label for="searchText">Search for a recipe title that contains:</label><br>
      <input type="text" name="searchText" id="searchText" size="50" maxlength="100" value="<?php echo htmlspecialchars($search); ?>" autofocus>
    </p>
    <p>
      <input type="submit" name="submit" value="Search">
      <input type="reset" value="Clear">
    </p>
  </div>
</form>

<!-- Search Results -->
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($search)) {
        echo '<h2 class="center">Please enter something to search.</h2>';
    } elseif ($numRows1 == 0) {
        echo '<h2 class="center">No recipes match search criteria &quot;' . htmlspecialchars($search) . '&quot;.</h2>';
    } else {
?>
    <h2 class="center">Recipes matching &quot;<?php echo htmlspecialchars($search); ?>&quot;:</h2>
    <div class="center">
    <table border="1">
      <thead>
        <tr>
          <th width="250">Recipe Title</th>
          <th width="150">Cook Time</th>
          <th width="400">Instructions</th>
          <th width="400">Recipe Image</th>
        </tr>
      </thead>
      <tbody>
<?php
        while ($row1 = mysqli_fetch_array($r1, MYSQLI_ASSOC)) {
?>
      <tr>
        <td><a href="recipedetails.php?recipe_ID=<?php echo $row1['recipe_ID']; ?>"><?php echo $row1['title']; ?></a></td>
        <td><?php echo $row1['cook_time']; ?></td>
        <td><?php echo $row1['instructions']; ?></td>
        <td><img src="images/<?php echo $row1['image_url']; ?>" alt="Recipe image for '<?php echo $row1['title']; ?>'" width="150"></td>
      </tr>
<?php
        }
?>
      </tbody>
    </table>
    </div>
<?php
    }
}
?>

<p class="center">Return to the <a href="main.php">Home Page</a>.</p>
</body>
</html>

<?php
if ($r1) {
    mysqli_free_result($r1);
}
mysqli_close($dbc);
?>
