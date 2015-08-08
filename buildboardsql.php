<?php

ini_set('display_errors', 'On');
header('Content-Type: text/html');
include "storedInfo.php"; //contains hostname/username/password/databasename
include "globalConstants.php";
include "sqloperationfunctions.php";

if(!isset($_POST['board_name']) || $_POST['board_name']==''){
  fishy('you must set a name','build');
}

//todo check for part is already in use

$stmt = $mysqli->prepare("INSERT INTO sk8_skateboards (board_name,fk_deck_id,fk_truck_id,fk_wheel_id)
                          VALUES(?,?,?,?)");
$stmt->bind_param('siii',$_POST['board_name'],$_POST['fk_deck_id'],$_POST['fk_truck_id'],$_POST['fk_wheel_id']);
$stmt->execute();

if($stmt->errno){
  $error=$stmt->error;
  $number = $stmt->errno;
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