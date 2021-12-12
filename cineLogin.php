<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Unit 5 - Cine Login</title>
</head>
<body>

    <?php
    session_start();
    $isvalid = true;
    $login = $_POST['user'];
    $password = $_POST['password'];
    $user;
    require_once "Connection.php";
        if (isset($_POST['submit']) && !empty($_POST['user']) && !empty($_POST['password'])) {
            $login = $_POST['user'];
            $password = $_POST['password']; 
            mysqli_select_db($connection, $database) or die("I cannot find the database.");

            if ($connection->connect_errno) {
                echo "Error connecting to MySQL: ". $connection->connect_error;
                exit();  //Not Connected.
            }
            else{
                //Connect.
                //Insert values.
                $crypt = password_hash($password, PASSWORD_BCRYPT);
                $select = "SELECT * FROM users;";
                $query = mysqli_query($connection, $select);
                while($userdb = mysqli_fetch_array($query)){
                    $isvalid = ($userdb["login"] == $login) && (password_verify($password, $userdb["password"]));
                    if($isvalid){
                        $_SESSION['login'] = $userdb['login']; 

                        date_default_timezone_set('Europe/Madrid');
                        setcookie("$login", $_SERVER['PHP_AUTH_USER'], time()+3600);

                        if (isset($_COOKIE['last_time_log_in'])) {
                            $last_login = $_COOKIE['last_time_log_in']; 
                        }
                        setcookie('last_time_log_in', time(), time()+60*60); 
                        header("Location:cinePagina.php");
                    }
                }
                
            } 
            
        }      
        
    ?>
            <form name="form" action="" method="post"> 
                
                <img src="./images/images/logo.png"/>
                <h1>Login to enter</h1>

                <div class="messageError">
                    
                    <?php
                    if(!$isvalid){
                        echo "Login fail, try again!!!";
                    }
                    else{
                        echo "Insert Credentials to enter";
                    }
                    ?>
                </div>
                <label for="section">- User: </label>
                <input type="text" id="user" name="user" value="<?php 
                    if(isset($_POST['submit']) && isset($_POST['user'])){
                        echo $_POST['user'];
                    }?>" />
                <?php 
                    if(isset($_POST['submit']) && empty($_POST['user'])){
                        echo "<span class ='messageError' style=color:darkred>- You must enter an user!</span>";
                    }?><br />

                <label for="password">- Password:</label>
                <input type="password" name="password" id="password" value="<?php 
                    if(isset($_POST['submit']) && isset($_POST['password'])){
                        echo $_POST['password'];
                    }?>" />
                <?php 
                    if(isset($_POST['submit']) && empty($_POST['password'])){
                        echo "<span class ='messageError' style=color:darkred;>- You must enter a password!</span>";
                    }?><br /><br />

                <input type="submit" value="Login" name="submit" /><br /><br />

                <p>Don't you have an account? <a href="cineRegistro.php">Sing Up</a></p>

                
                <br /><br />
            </form>
            
</body>
</html>