<?php
//Restrict access and redirect if necessary
require('logincheck.php');

//Connect to the database
require('mysqli_connect.php');


if (isset($_GET['recipe_ID'])) {
    $recipe = $_GET['recipe_ID'];

    $q = "SELECT r.recipe_ID, r.title, r.ingredients, r.instructions, r.cook_time, r.image_url, r.date_Added, 
    c.category_Name, u.first_Name AS author
    FROM recipes_Table r
    LEFT JOIN categories_Table c ON r.category_ID = c.category_ID
    LEFT JOIN users_Table u ON r.user_ID = u.user_ID
    WHERE r.recipe_ID = $recipe";

    $r = @mysqli_query($dbc, $q);
    if (mysqli_num_rows($r) == 1) {
        $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
    } else {
        echo "<p>Recipe not found.</p>";
        exit;
    }
} else {
    echo "<p>No recipe selected.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
.recipe-container {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  gap: 20px;
}

.recipe-text {
  flex: 1;
}

.recipe-img {
  max-width: 300px;
  border-radius: 8px;
}

    </style>
  <meta charset="UTF-8">
  <title><?php echo $row['title']; ?> - Recipe Details</title>
  <link rel="stylesheet" href="cis231.css">
</head>
<body>
<h2 class="center"><?php echo $row['title']; ?></h2>

<div class="recipe-container">
  <div class="recipe-text">
    <p><strong>Author:</strong> <?php echo $row['author']; ?></p>
    <p><strong>Category:</strong> <?php echo $row['category_Name']; ?></p>
    <p><strong>Cook Time:</strong> <?php echo $row['cook_time']; ?></p>
    <p><strong>Date Added:</strong> <?php echo $row['date_Added']; ?></p>
    <p><strong>Ingredients:</strong><br><?php echo nl2br($row['ingredients']); ?></p>
    <p><strong>Instructions:</strong><br><?php echo nl2br($row['instructions']); ?></p>
  </div>

  <img src="images/<?php echo $row['image_url']; ?>" alt="Recipe image for <?php echo $row['title']; ?>" class="recipe-img">
</div>

<h3>Leave a Comment:</h3>
<form action="comments.php" method="post">
  <input type="hidden" name="recipe_ID" value="<?php echo $row['recipe_ID']; ?>">
  <label for="comment_Text">Comment:</label><br>
  <textarea name="comment_Text" rows="4" cols="60" id="comment_Text" required></textarea><br>
  <br>
  <input type="submit" value="Post Comment">
</form>


<p class="center">
  <a href="comments.php?recipe_ID=<?php echo $row['recipe_ID']; ?>">View/Add Comments</a>
</p>

<h3>Comments:</h3>
<?php
$q2 = "SELECT comment_Text, comment_Date, u.first_Name 
       FROM comments_Table c 
       JOIN users_Table u ON c.user_ID = u.user_ID 
       WHERE c.recipe_ID = $recipe
       ORDER BY comment_Date DESC";
$r2 = mysqli_query($dbc, $q2);

if (mysqli_num_rows($r2) == 0) {
    echo "<p>No comments yet. Be the first to comment!</p>";
} else {
    while ($row2 = mysqli_fetch_array($r2, MYSQLI_ASSOC)) {
        echo "<p><strong>{$row2['first_Name']}</strong> on {$row2['comment_Date']}<br>{$row2['comment_Text']}</p><hr>";
    }
}
?>


<p class="center"><a href="main.php">Return to Home Page</a></p>
</body>
</html>

<?php
mysqli_free_result($r);
mysqli_close($dbc);
?>
