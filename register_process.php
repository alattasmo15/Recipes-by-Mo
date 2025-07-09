
<?php

require('mysqli_connect.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  
    $user_ID = mysqli_real_escape_string($dbc, trim($_POST['user_ID']));
    $first_Name = mysqli_real_escape_string($dbc, trim($_POST['first_Name']));
    $last_Name = mysqli_real_escape_string($dbc, trim($_POST['last_Name']));
    $email_Address = mysqli_real_escape_string($dbc, trim($_POST['email_Address']));
    $bio = mysqli_real_escape_string($dbc, trim($_POST['bio']));
    $password1 = trim($_POST['userPasswd']);
    $password2 = trim($_POST['userPasswd2']);

   
    if ($password1 !== $password2) {
        echo "<h2 style='color:red;'>Error: Passwords do not match.</h2>";
        echo "<p><a href='register.php'>Return to Registration</a></p>";
        exit;
    }


    $hashedPassword = sha1($password1);

   
    $q = "INSERT INTO users_Table (user_ID, user_Password, first_Name, last_Name, email_Address, bio, date_Joined)
          VALUES ('$user_ID', '$hashedPassword', '$first_Name', '$last_Name', '$email_Address', '$bio', NOW())";

    $r = @mysqli_query($dbc, $q);

    if ($r) {
        echo "<h2>Thank you for registering, $first_Name!</h2>";
        echo "<p><a href='login_page.php'>Proceed to login</a></p>";
    } else {
        echo "<h2 style='color:red;'>System Error: Could not register you.</h2>";
        echo "<p>" . mysqli_error($dbc) . "</p>";
        echo "<p><a href='register.php'>Try Again</a></p>";
    }

  
    mysqli_close($dbc);
} else {
    echo "<h2>Error: Invalid access.</h2>";
}
?>
