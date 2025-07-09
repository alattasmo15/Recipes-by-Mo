<?php
session_start(); 

require('mysqli_connect.php'); 
require('login_functions.php'); 
if (!isset($_SESSION['user_ID'])) {
    redirect_user('login_page.php');
}
?>


<!doctype html>
<html lang="en">
<head>
<style>
     h1 {
  text-align: center;
}
     @font-face { font-family: 'myFirstFont';
      src: url("css/Poppins-SemiBold.ttf");}

    body { background-image: url("css/background.jpg");
    background-size: cover;
    font-family: 'myFirstFont', sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh; }

  .center { max-width: 700px;
    width: 90%;
    background: white;
    padding: 20px;
    text-align: center;
    border-radius: 10px;
    box-shadow: 0 0 15px rgba(0,0,0,0.1);  }
  table { margin: 0 auto;
    width: 100%;
    border-collapse: collapse; }
  th, td { padding: 12px;
    text-align: center; }
  a {color: purple;
text-decoration: none;
font-weight: bold;}
     a:hover {text-decoration: underline;}
  p { margin: 10px 0;}
</style>
<meta charset="utf-8">
<title>Welcome to the Forum</title>
</head>

<body>
<div class="center">
  
  <h2>Welcome <?php echo $_SESSION['first_Name']; ?>!</h2>
<?php 
//Determine if there is a last_Login or if new user
if($_SESSION['last_Login'] == NULL)
{ 
	echo "<p>Thank you for being a new user!</p>";
}
else
{
?>
  <p>Last login on <?php echo($_SESSION['last_Login']); ?></p>
<?php
}

//Query the database for categories
//WILL CHANGE WHEN I HAVE DATA IN THE DATABASE !!!
$q = "SELECT category_ID, category_Name, category_Description FROM categories_Table 
ORDER BY  CASE category_Name WHEN 'Breakfast' THEN 1 WHEN 'Lunch' THEN 2 WHEN 'Dinner' THEN 3 WHEN 'Dessert' THEN 4 ELSE 5 END";

$r = @mysqli_query($dbc, $q);
$numRows = mysqli_num_rows($r);

//Determine if there are any categories to diplay
if ($numRows == 0) //No existing categories in database table
{
?>
  <p>&nbsp;</p>
  <h2 class="center">There are no categories established yet.</h2>
<?php
} 
else //There are categories to display
{
?>
  <p>&nbsp;</p>
  <p>See all recipes from one of the following categories:</p>
  <table width="600" border="1" align="center">
    <thead>
      <tr>
        <th width="200">Category</th>
        <th width="400">Description</th>
      </tr>
    </thead>
    <tbody>
<?php

//WILL CHANGE WHEN I HAVE DATA IN THE DATABASE !!!
while($row = mysqli_fetch_array($r))
{
?>
      <tr>
      <td><a href="recipesbymo.php?category_ID=<?php echo $row['category_ID']; ?>"><?php echo $row['category_Name']; ?></a></td>
      <td><?php echo $row['category_Description']; ?></td>
      </tr>
<?php
}  //End while loop to build table body
?>
    </tbody>
  </table>
  <p>or</p>
<?php
} //End "categories" if
//WILL CHANGE WHEN I HAVE DATA IN THE DATABASE !!!
?>
  <p><a href="recipesearch.php">Search Recipes by Title</a><br>
    <a href="recipeadd.php">Add a Recipe</a><br>
    <a href="commentsearch.php">Search all my Comments</a><br>
    <a href="editprofile.php">Edit my Profile</a><br>
    <a href="logout.php">Log out</a></p>
</div>
</body>
</html>

<?php
//Free record sets and close database connections
mysqli_free_result($r);
mysqli_close($dbc);
?>