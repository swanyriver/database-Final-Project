<?php

ini_set('display_errors', 'On');
header('Content-Type: text/html');
include "storedInfo.php"; //contains hostname/username/password/databasename
include "globalConstants.php";
include "sqloperationfunctions.php";

if(isset($_POST['redirect'])){
  $redirect = $_POST['redirect'];
} else $redirect = 'skateboards';

if(!isset($_POST['skid']) || !isset($_POST['rid'])){
  fishy('the board and rider must be set',$redirect);
}



if(isset($_POST['delete'])){
  $query = "DELETE FROM sk8_riders_skateboards WHERE fk_skateboard_id = ? AND fk_rider_id = ?";
  $create = "deleted";
} else {
  $query = "INSERT INTO sk8_riders_skateboards(fk_skateboard_id,fk_rider_id) VALUES (?,?) ";
  $create = "created";
}

$stmt = $mysqli->prepare($query);
$stmt->bind_param('ii',$_POST['skid'],$_POST['rid']);
$stmt->execute();
if($stmt->errno){
  $error=$stmt->error;
  $number = $stmt->errno;
  $stmt->close();

  fishy($error,$redirect);
}

$stmt->close();

redirect("rider/skateboard relationship $create",$redirect);

?>