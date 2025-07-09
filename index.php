    <?php
    //This page processes the login form submission.

    //Check if the form has been submitted:
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        //Need helper functions file:
        require('login_functions.php');
        
        //Need database connection:
        require('mysqli_connect.php');
        
        //Check the login:
        list($check, $data) = check_login($dbc, $_POST['user_ID'], $_POST['user_Password']);
        
        if ($check) //User was validated.
        {
            //Set the session data:
            session_start();
            $_SESSION['user_ID'] = $data['user_ID'];
            $_SESSION['first_Name'] = $data['first_Name'];
            $_SESSION['last_Login'] = $data['dayName'] . ", " . $data['month'] . " " . $data['day'] . ", " . $data['year'];
            
            //Update login information.
            $uid = $_SESSION['user_ID'];
            $q = "UPDATE users_Table SET last_Login=NOW() WHERE user_ID='$uid'";
            $r = @mysqli_query($dbc, $q);
            
            //Redirect:
            redirect_user('main.php');
        }
        else //Unsuccessful login!
        {
            //Assign $data to $errors for login_page.php:
            $errors = $data;
        }
        
        //Close the database connection.
        mysqli_close($dbc);
    } //End of the main submit conditional.

    //Create the login form page:
    include('login_page.php');
    ?>