<?php
session_start();


require('mysqli_connect.php');
require('login_functions.php');

if (isset($_SESSION['user_ID'])) {
    $uid = $_SESSION['user_ID'];

    
$q = "UPDATE users_Table SET last_Login = NOW() WHERE user_ID = '$uid'";
@mysqli_query($dbc, $q);
}


$_SESSION = [];


session_destroy();


mysqli_close($dbc);


redirect_user('login_page.php');
?>
