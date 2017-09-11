<?php
    session_start();

    //handling logout - deleting session and cookies
    if (array_key_exists("logout", $_GET)) {
        
        unset($_SESSION); //delete session
        setcookie("id", "", time() - 60*60); //delete cookie
        $_COOKIE["id"] = "";  
        session_destroy();
    
    // if session or cookies exists - relocates user to his userDiary page
    } else if ((array_key_exists("id", $_SESSION) AND $_SESSION['id']) OR (array_key_exists("id", $_COOKIE) AND $_COOKIE['id'])) {   
        header("Location: loggedinpage.php");   
    }

    //if user submit the form
    $error = "";
    if(array_key_exists("submit", $_POST)) {
        //connect to database
        include("link.php");

        //if there was a problem with connection to DB
        if (mysqli_connect_error())     
        die ("Database Connection Error");      

        //if email is missing
        if (!$_POST['email']) 
            $error .= 'Your email is missing';
        
        //if password is missing
        else if (!$_POST['password']) 
            $error .= 'Your password is missing';
    
        //if password and email arn't missing - checking if exist in DB
        else { 
            //----------  Login  ---------//
            if(array_key_exists('login', $_POST) && $_POST['login'] == '1') {
                $query = "SELECT * FROM `users` WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."'";
                $result = mysqli_query($link, $query);
                $row = mysqli_fetch_array($result);

                //check if user's email exists
                if($row['id'] < 1)
                    $error = "Email not exists";
                else {
                    $hashedPassword = md5(md5($row['id']).$_POST['password']);
                    if ($hashedPassword == $row['password']) {
                        //starting session
                        $_SESSION['id'] = $row['id'];
                        
                        //if user wants to be remembered - starting cookies
                        if (array_key_exists('stayLoggedIn', $_POST) && $_POST['stayLoggedIn'] == '1') {
                            setcookie("id", $row['id'], time() + 60*60*24*365);
                        }

                        header("Location: userDiary/userDiary.php");
                    }
                    
                    //if all details are currect
                    else {
                        $error = "Password isn't correct";
                    }
                }
            }
            //----------  Signup  ---------//
            else if($_POST['signup'] == 1) {
                //checks that user's email is in database
                $query = "SELECT * FROM `users` WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."'";
                $result = mysqli_query($link, $query);
                $row = mysqli_fetch_array($result);

                if($row['id'] > 0) {
                    $error = 'Email is already taken';
                }

                else {
                    $query = "INSERT INTO `users` (`email`, `password`) VALUES ('".mysqli_real_escape_string($link, $_POST['email'])."', '".mysqli_real_escape_string($link, $_POST['password'])."')";
                    
                    if (!mysqli_query($link, $query)) {
                        $error = "<p>Could not sign you up - please try again later.</p>";
                    
                    //updating users in DB
                    } else {
                        //encript the password, with salt and md5
                        $query = "UPDATE `users` SET password = '".md5(md5(mysqli_insert_id($link)).$_POST['password'])."' WHERE id = ".mysqli_insert_id($link)." LIMIT 1";
                        //update the database with the query
                        mysqli_query($link, $query);
                        $error = 'updated!';

                        //if user wants to be remembered - setting up session and cookies
                        $_SESSION['id'] = mysqli_insert_id($link); //setting up session
                        
                        if (array_key_exists ('stayLoggedIn', $_POST) && 
                        $_POST['stayLoggedIn'] == '1' ) { //setting up cookie
                            setcookie("id", mysqli_insert_id($link), time() + 60*60*24*365);
                        }

                        header("Location: userDiary/userDiary.php");
                    }
                }
            }   
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <? include ("header.php") ?>
    <style>
        .input-group-addon {
            width: 90px;
        }
        .toggleForm {
            cursor: pointer;
        }
    </style>
  </head>
  <body>

    <!-- Login form -->
    <div class="container" id="login">
        <h5>Log in</h5>
        <form method="post" >
            <label class="sr-only" for="inlineFormInputGroup">Email Adress</label>
            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                <div class="input-group-addon">Em@il</div>
                <input type="text" name="email" class="form-control" id="inlineFormInputGroup" placeholder="JohnDoe@gmail.com">
            </div>

            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                <div class="input-group-addon inputLabel">Password</div>
                <input type="text" name="password" class="form-control" id="inlineFormInputGroup">
            </div>

            <div class="form-check mb-2 mr-sm-2 mb-sm-0">
                <label class="form-check-label">
                <input type="hidden" name="login" value="1">
                <input class="form-check-input" name="stayLoggedIn" type="checkbox" value="1"> Remember me
                </label>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
        <p><a class="toggleForm">Signup</a></p>
        <?
            if($error) 
                echo '<p class="alert alert-danger" role="alert">'.$error.'</p>';
        ?>
    </div>

    <!-- Signup form -->
    <div class="container" style="display: none" id="signup">
        <h5>Sign up</h5>
        <form method="post">
            <label class="sr-only" for="inlineFormInputGroup">Email Adress</label>
            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                <div class="input-group-addon">Em@il</div>
                <input type="text" name="email" class="form-control" id="inlineFormInputGroup" placeholder="JohnDoe@gmail.com">
            </div>

            <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                <div class="input-group-addon inputLabel">Password</div>
                <input type="text" name="password" class="form-control" id="inlineFormInputGroup">
            </div>

            <div class="form-check mb-2 mr-sm-2 mb-sm-0">
                <label class="form-check-label">
                <input type="hidden" name="signup" value="1">
                <input class="form-check-input" name="stayLoggedIn" type="checkbox" value="1"> Remember me
                </label>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
        <p><a class="toggleForm">Log in</a></p>
        <?
            if($error) 
                echo '<p class="alert alert-danger" role="alert">'.$error.'</p>';
        ?>
    </div>


    <? include('footer.php') ?>
    <script src="script.js"></script>
  </body>
</html>
