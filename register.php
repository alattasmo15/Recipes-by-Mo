

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
<meta charset="UTF-8">
<title>Register</title>
<link href="cis231.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="center">
  <h1>Register</h1>
  <form action="register_process.php" method="post">
    <p>
    <label for="user_ID">User Name:</label>
    <input name="user_ID" id="user_ID" type="text" size="15" maxlength="15"
    pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{4,15}$"
    title="The user ID must be between 4 and 15 characters, start with a letter, and contain only letters and numbers"
    required autofocus>
    </p>

    <p>
    <label for="first_Name">First Name:</label>
    <input type="text" name="first_Name" id="first_Name" pattern=".{2,20}"
    title="First name must be between 2 and 20 characters" required>
    </p>

    <p>
    <label for="last_Name">Last Name:</label>
    <input type="text" name="last_Name" id="last_Name" pattern=".{2,20}"
    title="Last name must be between 2 and 20 characters" required>
    </p>
    <p>
    <label for="email_Address">Email:</label>
    <input type="email" name="email_Address" id="email_Address" required>
    </p>

    <p>
    <label for="bio">Bio:</label>
    <textarea name="bio" id="bio" rows="4" cols="40" maxlength="100"></textarea>
    </p>
    <p>
    <label for="userPasswd">Password:</label>
    <input name="userPasswd" id="userPasswd" type="password" size="12" maxlength="12"
    pattern="^(?=.*[A-Z])(?=.*[!@#$&*])(?=.*[0-9])(?=.*[a-z]).{6,12}$"
    title="The password must be between 6 and 12 characters, and include at least 1 upper case letter, 1 lowercase letter, 1 number and 1 of the special characters ! @ # $ & *"
    required>
    </p>
    <p>
      <label for="userPasswd2">Re-enter Password:</label>
      <input name="userPasswd2" id="userPasswd2" type="password" size="12" maxlength="12" required>
    </p>

    <p>
      <input type="submit" value="Register">
    </p>
  </form>
</div>
</body>
</html>
