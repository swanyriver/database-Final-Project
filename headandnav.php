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
      <li id="home_tab"><a href="welcome.php" >Home</a></li>
      <li id="diagrams_tab"><a href="diagrams.php">Diagrams and Queries</a></li>
      <li id="riders_tab"><a href="riders.php">Riders</a></li>
      <li id="skateboards_tab"><a href="skateboards.php">SkateBoards</a></li>
      <li id="inventory_tab"><a href="inventory.php">Invetory</a></li>
      <li id="build_tab"><a href="build.php">Build a Skateboard</a></li>
    </ul>
  </div><!-- /.container-fluid -->
</nav>

<?php

if(isset($_GET['message'])){
  $mclass = "message";
  if(isset($_GET['error'])) $mclass = $mclass." error";
  echo "<div class=\"$mclass\"> {$_GET['message']} </div>";
}

?>