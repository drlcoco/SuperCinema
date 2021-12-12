<?php
require_once "Connection.php";

$nombrepeliculas = array();
$peliculas = array();
$asientos;
$peliculaSeleccionada = $_GET["peliculaSeleccionada"];
$login=$_GET['login'];
$seatNumber = $_GET['id'] + 1;

//Set the row.
if($seatNumber > 0 && $seatNumber <= 10){$row = 1;}
if($seatNumber > 10 && $seatNumber <= 20){$row = 2;}
if($seatNumber > 20 && $seatNumber <= 30){$row = 3;}
if($seatNumber >= 30 && $seatNumber <= 40){$row = 4;}
if($seatNumber >= 40 && $seatNumber <= 50){$row = 5;}
$row;
        
mysqli_select_db($connection, $database) or die("I cannot find the database.");

    if ($connection->connect_errno) {
        echo "Error connecting to MySQL: ". $connection->connect_error;
        exit();  //Not Connected.
    }
    else{
        //Connect.
        //Insert values.
        $select = "SELECT * FROM movies;";
        $query = mysqli_query($connection, $select);
        while($moviedb = mysqli_fetch_array($query)){
            array_push($peliculas, $moviedb);
        }
    }   

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleComprada.css">
    <title>Cine Comprada</title>
</head>
<body>
    <img src="./images/images/logo.png"/>
    <h1>CONGRATULATIONS <?php echo $login ?>!!!</h1>
    <p>You have bought a ticket, Click <?php echo"<a href='cinePdfEntrada.php?movie=$peliculaSeleccionada&row=$row&seat=$seatNumber'>here</a>";?> to download.</p>
    <br />
    <a href="cinePagina.php?login=<?php echo $login?>"><img src="./images/images/botonSeguir.png"/></a>
    <?php
        foreach ($peliculas as $pelicula) {
            if($pelicula["title"] == $peliculaSeleccionada){
                $asientos = $pelicula["seats"];
            }
        }
    ?>
    <table>
        <?php
            $asientos = str_split($asientos);
            for ($i=0; $i < count($asientos); $i++) {  
                if($_GET["id"] == $i){
                    
                    if ($connection->connect_errno) {
                        echo "Error connecting to MySQL: ". $connection->connect_error;
                        exit();  //Not Connected.
                    }
                    else{
                        //If buy a seat set this in data base.
                        $asientos[$i] = 0;
                        $asientos = join("", $asientos);
                        $updateSeat = "UPDATE movies SET seats = '$asientos' WHERE title = '$peliculaSeleccionada'";
                        $query = mysqli_query($connection, $updateSeat);
                        mysqli_close($connection);
                    }
                } 
            }
        ?>
    </table>
    <form action="" method="post">
    <select name="selectPelicula">
            
        <?php
        foreach ($nombrepeliculas as $nombrepelicula ) {
            echo "<option selected value='$nombrepelicula'>$nombrepelicula</option>";
        }
        ?>
    </select>
    <button type="submit" name="submit">Choose Film</button>

    </form>
    </body>
</html>