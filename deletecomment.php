<?php
//Restrict access and redirect if necessary
require('logincheck.php');

//Connect to the database
require('mysqli_connect.php');

//Get user_ID from session data and save as local variable
$uid = $_SESSION['user_ID'];

//Check to make sure comment_ID exists
if ((isset($_SESSION['comment_ID'])) && ($_SESSION['comment_ID'] != "")) {
    
    //Get comment_ID from session data
    $comid = $_SESSION['comment_ID'];
    
    //Delete comment
    $q1 = "DELETE FROM comments_Table WHERE comment_ID = $comid";
    $r1 = mysqli_query($dbc, $q1);

    //Set Boolean flag for success
    $delete = true;
} else {
    //Set Boolean flag for failure
    $delete = false;
}
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Deletion Confirmation</title>
<link href="cis231.css" rel="stylesheet" type="text/css">
</head>

<body>
<h2 class="center">Welcome <?php echo $_SESSION['first_Name']; ?>!</h2>

<?php
if ($delete) {
    echo "<h3 class=\"center\">Your comment was deleted.</h3>";
} else {
    echo "<h3 class=\"center\">Your comment was not deleted.</h3>";
}
?>

<p class="center">
    Return to <a href="commentsearch.php">My Comments</a> |
    Or return to the <a href="main.php">Home Page</a>.
</p>

</body>
</html>
