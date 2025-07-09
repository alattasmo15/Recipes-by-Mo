<?php
//Restrict access and redirect if necessary
require('logincheck.php');

//Connect to the database
require('mysqli_connect.php');

//Create comment_ID variable
$comment_ID = "";

//Check to make sure comment_ID exists
if (!(isset($_SESSION['comment_ID'])) || ($_SESSION['comment_ID'] == ""))
{
    //Send user back to the main page:
    redirect_user('main.php');
}
else
{
    //Get comment_ID from session data
    $comment_ID = $_SESSION['comment_ID'];

    //Check if the form has been submitted:
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        //Read the posted data from the form into local variables:
        $text = mysqli_real_escape_string($dbc, trim($_POST['comment_Text']));

        //Update the comment in the database:
        $q1 = "UPDATE comments_Table SET comment_Text='$text' WHERE comment_ID=$comment_ID";
        $r1 = @mysqli_query($dbc, $q1);

        //Send user back to the comment search page:
        redirect_user('commentsearch.php');
    }
    else  //Query the database to get data for selected comment
    {
        $q2 = "SELECT comment_Text, DAYNAME(comment_Date) AS day, MONTHNAME(comment_Date) AS month, 
                      DAY(comment_Date) AS date, YEAR(comment_Date) AS year, title, image_url 
               FROM comments_Table 
               JOIN recipes_Table ON comments_Table.recipe_ID = recipes_Table.recipe_ID 
               WHERE comment_ID=$comment_ID";
        $r2 = @mysqli_query($dbc, $q2);
        $row2 = mysqli_fetch_array($r2, MYSQLI_ASSOC);
    }
}
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Edit My Comment</title>
<link href="cis231.css" rel="stylesheet" type="text/css">
</head>

<body>
<h2 class="center">Welcome <?php echo $_SESSION['first_Name']; ?>!</h2>
<p>&nbsp;</p>
<form action="editcomment.php" method="post">
  <table class="center">
    <tbody>
      <tr>
        <td colspan="2" class="center">
          <p><em><?php echo $row2['title']; ?></em><br>
          <img src="images/<?php echo $row2['image_url']; ?>" width="200"></p>
          <p>Comment originally added <?php echo $row2['day']; ?>, <?php echo $row2['month']; ?> <?php echo $row2['date']; ?>, <?php echo $row2['year']; ?></p>
        </td>
      </tr>
      <tr>
        <td class="right"><label for="comment_Text">Comment Text:</label></td>
        <td class="left"><textarea name="comment_Text" id="comment_Text" cols="80" rows="10"><?php echo $row2['comment_Text']; ?></textarea></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td class="left"><input type="submit" value="Update Comment"></td>
      </tr>
    </tbody>
  </table>
</form>
<p>&nbsp;</p>
<p class="center">Return to <a href="commentsearch.php">My Comments</a> | <a href="main.php">Home Page</a></p>
</body>
</html>

<?php
//Free record sets and close database connections
if ($comment_ID != "") {
    mysqli_free_result($r2);
}
mysqli_close($dbc);
?>
