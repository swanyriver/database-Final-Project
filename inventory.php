<?php 

ini_set('display_errors', 'On');

header('Content-Type: text/html');
include "storedInfo.php"; //contains hostname/username/password/databasename

//connect to database with created mysqli object
$mysqli = new mysqli($hostname, $Username, $Password, $DatabaseName);
if ($mysqli->connect_errno || $mysqli->connect_error)
{
  http_response_code(500);
  echo "Database currently unvailable";
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Database Final Project">
    <meta name="author" content="Brandon">

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- my CSS -->
    <link href="style.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <ul class="nav nav-tabs">
      <li><a href="welcome.html">Home</a></li>
      <li><a href="riders.php">Riders</a></li>
      <li><a href="skateboards.php">SkateBoards</a></li>
      <li class="active" ><a href="inventory.php">Invetory</a></li>
    </ul>
  </div><!-- /.container-fluid -->
</nav>


<?php

#$deckStmt = $mysqli->prepare("SELECT T.name,T.,, from sk8_deck_inv I inner join ")

$deckStmt = $mysqli->prepare("select name from sk8_skateboards");
$deckStmt->execute();
$deckStmt->bind_result($deckname);
while($deckStmt->fetch()){
  echo "$deckname <br>";
}

?>

</body>