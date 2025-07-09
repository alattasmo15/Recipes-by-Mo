<?php
session_start();

require_once('login_functions.php');

if (!isset($_SESSION['user_ID'])) {
    redirect_user('index.php');
}
?>
