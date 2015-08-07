<?php

ini_set('display_errors', 'On');
header('Content-Type: text/html');
include "storedInfo.php"; //contains hostname/username/password/databasename
include "globalConstants.php";
include "sqloperationfunctions.php";

function exit_in_error($stmt){
  $msg = $stmt->error;
  $stmt->close();
  fishy($msg,'inventory');
}

if (!in_array($_POST['table'], $itemtables)) {
    fishy("how did you ask to add to:{$_POST['table']}",'inventory');
}

$table = $_POST['table'];

if($table=='deck'){
  if(isset($_POST['fkid'])){
    //collect color and add an entry to inventory
  } else {
    //is new item, will need to be added
    //after adding item add instance use last id
    //$last_id = $mysqli->insert_id;
  }

  redirect('item added to inventory','inventory');
}

if($table=='truck'){
  if(isset($_POST['fkid'])){
    //duplicate item
    $instmt=$mysqli->prepare("INSERT INTO sk8_truck_inv (fk_truck_id) VALUES(?)");
    $instmt->bind_param('i',$_POST['fkid']);
    $instmt->execute();
    if($instmt->errno) exit_in_error($instmt);
    $instmt->close();
  } else {
    //is new item, will need to be added
    $instmt=$mysqli->prepare("INSERT INTO sk8_truck_type (truck_name, width, fk_brand_id) VALUES(?,?,?)");
    $instmt->bind_param('sii',$_POST['name'],$_POST['width'],$_POST['brand_id']);
    $instmt->execute();
    if($instmt->errno) exit_in_error($instmt);
    $instmt->close();
    //after adding item add instance use last id
    $last_id = $mysqli->insert_id;
    $instmt=$mysqli->prepare("INSERT INTO sk8_truck_inv (fk_truck_id) VALUES(?)");
    $instmt->bind_param('i',$last_id);
    $instmt->execute();
    if($instmt->errno) exit_in_error($instmt);
    $instmt->close();
  }

  redirect('item added to inventory','inventory');
}

if($table=='wheel'){
  if(isset($_POST['fkid'])){
    //collect color and add an entry to inventory
  } else {
    //is new item, will need to be added
    //after adding item add instance use last id
    //$last_id = $mysqli->insert_id;
  }

  redirect('item added to inventory','inventory');
}



?>

