<!-- This page prints any errors associated with logging in
     and it creates the complete login page, including the form,
     as well as the link to the registration page. -->

     <!DOCTYPE html>
<html lang="en">
<head>
<style>
    h1 {
  text-align: center;
}
     @font-face {
      font-family: 'myFirstFont';
      src: url("css/Poppins-SemiBold.ttf");
    }
body  {
  background-image: url("css/background.jpg");
  background-size: cover;
  font-family: 'myFirstFont', sans-serif;
}
.center {
  width: 400px;
  margin: 200px auto;
}

</style>
<head>
<meta charset="utf-8">
<title>Login Page</title>

<body>
<h1 style="margin-top: 80px;">Recipes by Mo</h1>

<div class="center">
    <p></p>
    <?php
    //Print any error messages, if they exist:
    if (isset($errors) && !empty($errors))
    {
        echo "<h1>Error!</h1>";

        echo "<p>The following error(s) occurred:<br>";

        foreach ($errors as $msg)
        {
            echo " - $msg<br>\n";
        }

        echo "</p>";
        echo "<p>Please try again.</p>";
    }
    ?>

    <!-- Display the form -->
     
    <h1>Login:</h1>
    
    <form action="index.php" method="post">
        <p>
            <label for="user_ID">Username:</label>
            <input type="text" name="user_ID" id="user_ID" size="15" maxlength="15" autofocus>
        </p>
        <p>
            <label for="user_Password">Password:</label>
            <input type="password" name="user_Password" id="user_Password" size="32" maxlength="32">
        </p>
        <p>
            <input type="submit" name="submit" value="Login">
        </p>
        <p>Don't have an account? <a href="register.php" title="Create an account for the site!">Create a user today!</a></p>
    </form>
</div>
</body>
</html>