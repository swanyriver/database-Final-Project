<?php

ini_set('display_errors', 'On');
header('Content-Type: text/html');
include "storedInfo.php"; //contains hostname/username/password/databasename
include "globalConstants.php";
include "sqloperationfunctions.php";

if(!isset($_POST['brand_name']) || $_POST['brand_name']==''){
  fishy('you must set a name','inventory');
}

$stmt = $mysqli->prepare("INSERT INTO sk8_brand (brand_name, brand_img_url) VALUES (?,?) ");
$stmt->bind_param('ss',$_POST['brand_name'],$_POST['brand_url']);
$stmt->execute();
if($stmt->errno){
  $error=$stmt->error;
  $number = $stmt->errno;
  $stmt->close();

  if($number==1062) fishy("{$_POST['brand_name']} was already added to brands",'inventory');

  fishy($error,'inventory');
}

$stmt->close();
redirect("{$_POST['brand_name']} added to brands",'inventory');