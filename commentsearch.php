<?php
//Restrict access and redirect if necessary
require('logincheck.php');

//Connect to the database
require('mysqli_connect.php');

//Get user_ID from session
$uid = $_SESSION['user_ID'];

//Query for user's recipe comments
$q1 = "SELECT comment_ID, comment_Text, DAYNAME(comment_Date) AS day, MONTHNAME(comment_Date) AS month, DAY(comment_Date) AS date, YEAR(comment_Date) AS year, title, image_url FROM comments_Table JOIN recipes_Table ON comments_Table.recipe_ID = recipes_Table.recipe_ID WHERE comments_Table.user_ID='$uid' ORDER BY comment_Date DESC";
$r1 = mysqli_query($dbc, $q1);
$numRows1 = mysqli_num_rows($r1);
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>My Comments</title>
<link href="cis231.css" rel="stylesheet" type="text/css">
</head>

<body>
<h2 class="center">Here is all your comments, <?php echo $_SESSION['first_Name']; ?>!</h2>
<?php if ($numRows1 == 0): ?>
<h2 class="center">You have not posted any comments.</h2>
<p class="center">Please return to the <a href="main.php">Home Page</a>.</p>
<?php else: ?>
<h3 class="center">Most-recent comments you have posted:</h3>
<form action="updatecomment.php" method="post">
  <table class="center" border="1">
    <thead>
      <tr>
        <th width="499">Comment</th>
        <th width="370">Recipe</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row1 = mysqli_fetch_array($r1, MYSQLI_ASSOC)): ?>
      <tr>
        <td class="left">
          <input type="radio" name="comment_ID" id="<?php echo $row1['comment_ID']; ?>" value="<?php echo $row1['comment_ID']; ?>" required>
          <label for="<?php echo $row1['comment_ID']; ?>"><strong><?php echo substr($row1['comment_Text'], 0, 40); ?>...</strong></label><br>
          <?php echo $row1['day'] . ", " . $row1['month'] . " " . $row1['date'] . ", " . $row1['year']; ?>
        </td>
        <td class="center">
          <em><?php echo $row1['title']; ?></em><br>
          <img src="images/<?php echo $row1['image_url']; ?>" width="100">
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
  <table width="349" class="center">
    <tbody>
      <tr>
        <td width="148">
          <input type="radio" name="action" value="edit" id="edit" required>
          <label for="edit">Edit Comment</label>
        </td>
        <td width="185">
          <input type="radio" name="action" value="delete" id="delete" required>
          <label for="delete">Delete Comment</label>
        </td>
      </tr>
    </tbody>
  </table>
  <p class="center">
    <input type="reset" value="Reset">
    <input type="submit" value="Submit">
  </p>
</form>
<p class="center">Return to the <a href="main.php">Home Page</a>.</p>
<?php endif; ?>
<?php mysqli_free_result($r1); mysqli_close($dbc); ?>
</body>
</html>
