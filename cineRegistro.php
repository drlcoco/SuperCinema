<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Registration</title>
</head>
<body>

    <?php
    session_start();
    $name;
    $isvalid = true;
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
                $insert = "INSERT INTO `users`(`login`, `password`) VALUES ('$login','$crypt');";                
                $query = mysqli_query($connection, $insert);
                if($query){
                    header("Location: cineLogin.php?login=".$login);
                }
                else{
                    echo "Error en el query";
                }
                
            } 
            
        }      
        
    ?>
            <form name="form" action="" method="post"> 
                
                <h1>Sing Up</h1>

                <div class="messageError">
                    
                    <?php
                    if(!$isvalid){
                        echo "Login fail, try again!!!";
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
                <label for="name">- Name: </label>
                <input type="text" id="name" name="name" value="<?php 
                    if(isset($_POST['submit']) && isset($_POST['name'])){
                        echo $_POST['name'];
                    }?>" />
                <?php 
                    if(isset($_POST['submit']) && empty($_POST['name'])){
                        echo "<span class ='messageError' style=color:darkred>- You must enter a name!</span>";
                    }?><br />

                <label for="password">- Password:</label>
                <input type="password" name="password" id="password" value="<?php 
                    if(isset($_POST['submit']) && isset($_POST['password'])){
                        echo $_POST['password'];
                    }?>" />
                <?php 
                    if(isset($_POST['submit']) && empty($_POST['password'])){
                        echo "<span class ='messageError' style=color:darkred>- You must enter a password!</span>";
                    }?><br /><br />
                <label for="password2">- Verify Password:</label>
                <input type="password" name="password2" id="password2" value="<?php 
                    if(isset($_POST['submit']) && isset($_POST['password2'])){
                        if($_POST['password'] == $_POST['password2']){
                            echo $_POST['password2'];
                        }
                        else{
                            echo "<span class ='messageError' style=color:darkred>- Incorrect password!</span>";
                        }
                    }?>" />
                <?php 
                    if(isset($_POST['submit']) && empty($_POST['password'])){
                        echo "<span class ='messageError' style=color:darkred>- You must enter a password!</span>";
                    }?><br /><br />

                <input type="submit" value="Sign Up" name="submit" /><br /><br />
                
                <br /><br />
            </form>
            
</body>
</html>