<?php

ini_set('display_errors', 'On');
header('Content-Type: text/html');
include "storedInfo.php"; //contains hostname/username/password/databasename
include "globalConstants.php";
include "sqloperationfunctions.php";

if(!isset($_POST['rider_name']) || $_POST['rider_name']==''){
  fishy('you must set a name','riders');
}

$stmt = $mysqli->prepare("INSERT INTO sk8_riders (rider_name) VALUES (?) ");
$stmt->bind_param('s',$_POST['rider_name']);
$stmt->execute();
if($stmt->errno){
  $error=$stmt->error;
  $number = $stmt->errno;
  $stmt->close();

  fishy($error,'riders');
}

$stmt->close();

if(isset($_POST['rider_url']) && $_POST['rider_url'] != ''){
  //update img url
  $last_id = $mysqli->insert_id;
  $stmt=$mysqli->prepare("UPDATE sk8_riders SET rider_img_url=?  WHERE id=?");
  $stmt->bind_param('si',$_POST['rider_url'],$last_id);
  $stmt->execute();
  $stmt->close();
};

redirect("{$_POST['rider_name']} added to riders",'riders');

?>