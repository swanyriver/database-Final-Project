<?php

ini_set('display_errors', 'On');
header('Content-Type: text/html');
include "storedInfo.php"; //contains hostname/username/password/databasename
include "globalConstants.php";
include "sqloperationfunctions.php";

if(!isset($_POST['board_name']) || $_POST['board_name']==''){
  fishy('you must set a name','build');
}

//if returned here with delete key, run delet sql, then insert new board
if(isset($_POST['dissasemble'])){

  $stmt=$mysqli->prepare("SELECT DISTINCT B.id from sk8_skateboards B 
                  WHERE fk_deck_id = ? OR fk_truck_id = ? OR fk_wheel_id = ?");
  $stmt->bind_param('iii',$_POST['fk_deck_id'],$_POST['fk_truck_id'],$_POST['fk_wheel_id']);
  $stmt->execute();

  $delboard= array();

  $stmt->bind_result($next);
  while ($stmt->fetch()) {
    $delboard[]=$next;
  }

  $stmt->close();


  foreach ($delboard as $id) {
    $stmt=$mysqli->prepare("DELETE FROM sk8_skateboards WHERE id=?");
    $stmt->bind_param('i',$id);
    $stmt->execute();
    $stmt->close();
  }

}


$stmt = $mysqli->prepare("INSERT INTO sk8_skateboards (board_name,fk_deck_id,fk_truck_id,fk_wheel_id)
                          VALUES(?,?,?,?)");
$stmt->bind_param('siii',$_POST['board_name'],$_POST['fk_deck_id'],$_POST['fk_truck_id'],$_POST['fk_wheel_id']);
$stmt->execute();

if($stmt->errno){
  $error=$stmt->error;
  $number = $stmt->errno;

  //parts already in use in other boards
  if($number == 1062){
    $stmt->close();
    $stmt=$mysqli->prepare("SELECT DISTINCT B.id, B.board_name from sk8_skateboards B 
                            WHERE fk_deck_id = ? OR fk_truck_id = ? OR fk_wheel_id = ?");
    $stmt->bind_param('iii',$_POST['fk_deck_id'],$_POST['fk_truck_id'],$_POST['fk_wheel_id']);
    $stmt->execute();
    $stmt->bind_result($id,$name);

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

    <?php
    echo "<h2>These parts are currently being used in:</h2> <br> <ul>";
    while ($stmt->fetch()) {
      echo "<li> <a href=\"skateboards.php#{$id}\"> $name </a> </li>";
    }
    echo "</ul>";
    $stmt->close();

    ?>

    <form action="buildboardsql.php" method="POST">

    <?php 
      foreach ($_POST as $key => $value) {
        echo "<input type=\"hidden\" name=\"{$key}\" value=\"{$value}\"></input>";
      }
      echo "<input type=\"hidden\" name=\"dissasemble\" value=\"true\"></input>";
    ?>

      <a href="build.php">
      <button type="button" class="btn btn-warning">
      <span class="glyphicon glyphicon-backward"> </span> Go Back (Cancel Build)
      </button>
      </a>

      <button type="submit" class="btn btn-danger">
      <span class="glyphicon glyphicon-wrench"> </span>Dissasemble Board(s) and Build new Board
      </button>

    </form>
    </body>
    </html>

    <?php

    exit();
  }


  $stmt->close();
  fishy($error,'build');
}
$stmt->close();

if(isset($_POST['board_img_url']) && $_POST['board_img_url'] != ''){
  //update img url
  $last_id = $mysqli->insert_id;
  $stmt=$mysqli->prepare("UPDATE sk8_skateboards SET board_img_url=?  WHERE id=?");
  $stmt->bind_param('si',$_POST['board_img_url'],$last_id);
  $stmt->execute();
  $stmt->close();
}


redirect("{$_POST['board_name']} added to skateboards",'skateboards');

?>