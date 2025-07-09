<?php
//This page defines two functions used by the login/logout process.


/* This function determines an absolute URL and redirects the user there.
 * The function takes one argument: the page to be redirected to.
 * The argument defaults to index.php.
 */


function redirect_user($page = 'index.php')
{
   

    //Start defining the URL...
    //URL is http:// plus the host name plus the current directory:
    $url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
    
    //Remove any trailing slashes:
    $url = rtrim($url, '/\\');
    
    //Add the page:
    $url .= '/' . $page;
    
    //Redirect the user:
    header("Location: $url");
    exit(); //Quit the script.

} //End of redirect_user() function.


/*********************************************************************/


/* This function validates the form data (the username and password).
 * If both are present, the database is queried.
 * The function requires a database connection.
 * The function returns an array of information, including:
 *    - a TRUE/FALSE variable indicating success
 *    - an array of either errors or the database results
 */

function check_login($dbc, $uid = '', $user_Password = '')
{
    $errors = []; //Initialize error array.
    
    //Validate the username:
    if (empty($uid))
    {
        $errors[] = 'You forgot to enter your username.';
    }
    else
    {
        $id = mysqli_real_escape_string($dbc, trim($uid));
    }
    
    //Validate the password:
    if (empty($user_Password))
    {
        $errors[] = 'You forgot to enter your password.';
    }
    else
    {
        $p = mysqli_real_escape_string($dbc, trim($user_Password));
    }
    
    if (empty($errors)) //If everything is OK.
    {
        //Retrieve the username, first name, and date of last login for that username/password combination:
        $q = "SELECT user_ID, first_Name , DAYNAME(last_Login ) AS dayName, MONTHNAME(last_Login ) AS month, DAY(last_Login ) AS day, YEAR(last_Login ) AS year FROM users_Table WHERE user_Id='$id' AND user_Password=SHA1('$p')";
        $r = @mysqli_query($dbc, $q); //Run the query.
        
        //Check the result:
        if (mysqli_num_rows($r) == 1)
        {
            //Fetch the record:
            $row = mysqli_fetch_array($r, MYSQLI_ASSOC);

            //Return true and the record:
            return [true, $row];
        }
        else //Not a match!
        {
            $errors[] = 'The username and password entered do not match those on file.';
        }
    } //End of empty($errors) IF.
    
    //Return false and the errors:
    return [false, $errors];
	
} //End of check_login() function.

?>