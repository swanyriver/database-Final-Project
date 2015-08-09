<?php

ini_set('display_errors', 'On');
header('Content-Type: text/html');
include "storedInfo.php"; //contains hostname/username/password/databasename
include "globalConstants.php";
include "sqloperationfunctions.php";

if(!isset($_POST['skid']) || !isset($_POST['rid'])){
  fishy('the board and rider must be set','skateboards');
}

$stmt = $mysqli->prepare("INSERT INTO sk8_riders_skateboards(fk_skateboard_id,fk_rider_id) VALUES (?,?) ");
$stmt->bind_param('ii',$_POST['skid'],$_POST['rid']);
$stmt->execute();
if($stmt->errno){
  $error=$stmt->error;
  $number = $stmt->errno;
  $stmt->close();

  fishy($error,'skateboards');
}

$stmt->close();

redirect("rider/skateboard relationship created",'skateboards');

?>