<!-- <img src='./images/butaca_amarilla.png'> -->
<?php
session_start();
require_once "Connection.php";

$nombrepeliculas = array();
$peliculas = array();
$asientos;
$peliculaSeleccionada;
$login=$_GET['login'];

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
            array_push($nombrepeliculas, $moviedb["title"]); //Titles movies.
            array_push($peliculas, $moviedb); //Titles and seats movies.

        }
        if(empty($_POST["selectPelicula"])){
            $peliculaSeleccionada = $nombrepeliculas[0]; //First movie to show.
        }
        else{
            $peliculaSeleccionada = $_POST["selectPelicula"]; //Show selected movie.
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylePagina.css">
    <title>Cine Pagina</title>
</head>
<body>
    <img id="imgLogo" src="./images/images/logo.png"/>
    <p>Welcome, <strong><?php echo $_SESSION['login'] ?></strong>! (<a href="cineLogin.php">logout</a>)</p>
    <h1>Buy Tickets</h1>
    <h2>Movie: <?php echo $peliculaSeleccionada ?></h2>
    <img id="imgPant" src="./images/images/pant.png"/><br />

    <?php
        foreach ($peliculas as $item) {
            if($item["title"] == $peliculaSeleccionada){
                $asientos = $item["seats"];
            }
        }
    ?>
    <table>
        <?php
            //Set red image or yelow image.
            $asientos = str_split($asientos);
            for ($i=0; $i < count($asientos); $i++) { 
                    if($i == 0){echo "<tr>";}
                    if($asientos[$i] == 0){
                        echo "<td><img src='./images/images/butaca_roja.png'/></td>";
                    }
                    else{
                        echo "<td class= 'amarilla'><a href='cineComprada.php?id=$i&peliculaSeleccionada=$peliculaSeleccionada&login=$login'><img src='./images/images/butaca_amarilla.png'/></a></td>";
                    }
                    if($i == 9 || $i == 19 || $i == 29 || $i == 39){ //Break row.
                        echo "</tr><tr>";
                    }
                    if($i == 50 ){echo "</tr>";}   
            }
        ?>
    </table>
    <form action="" method="post">
        <select name="selectPelicula">
            
        <?php
        //Select movie as selected.
        foreach ($nombrepeliculas as $nombrepelicula ) {
            if($nombrepelicula == $peliculaSeleccionada){
                echo "<option selected value='$nombrepelicula'>$nombrepelicula</option>";
            }
            else{
                echo "<option value='$nombrepelicula'>$nombrepelicula</option>";
            }
        }
        ?>
        </select>
        <button type="submit" name="submit">Choose Film</button>

    </form>
    </body>
</html>