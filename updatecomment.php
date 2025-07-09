<?php
session_start();
require('login_functions.php');

// Save selected comment_ID
$_SESSION['comment_ID'] = $_POST['comment_ID'];

// Redirect based on action
if ($_POST['action'] == 'delete') {
    redirect_user('deletecomment.php');
} elseif ($_POST['action'] == 'edit') {
    redirect_user('editcomment.php');
}
?>
