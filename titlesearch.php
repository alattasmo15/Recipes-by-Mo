<?php
//Restrict access and redirect if necessary
require('logincheck.php');
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Search Recipes by Title</title>
<link href="cis231.css" rel="stylesheet" type="text/css">
</head>

<body>
<p class="center"><img src="logo.png" alt="logo" width="808" height="146"></p>
<h2 class="center">Welcome <?php echo $_SESSION['first_Name']; ?>!</h2>
<form action="recipesearch.php" method="post">
  <div class="center">
    <p>
      <label for="searchText">Search for a recipe with a title that contains:</label>
      <br>
      <input type="text" name="searchText" id="searchText" size="50" maxlength="100" autofocus>
    </p>
    <p>
      <input type="reset" name="reset" id="reset" value="Clear">
      <input type="submit" name="submit" id="submit" value="Search">
    </p>
  </div>
</form>
<p>&nbsp;</p>
<p class="center">Return to the <a href="main.php">Home Page</a>.</p>
</body>
</html>