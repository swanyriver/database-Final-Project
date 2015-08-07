<?php

ini_set('display_errors', 'On');
header('Content-Type: text/html');
include "storedInfo.php"; //contains hostname/username/password/databasename
include "globalConstants.php";
include "sqloperationfunctions.php";


if (!in_array($_POST['table'], $itemtables)) {
    fishy("how did you ask to add to:{$_POST['table']}",'inventory');
}

if($_POST['brandid']=$new_brand && (!isset($_POST['brand_name'])  || $_POST['brand_name']=='')){
  echo"
  <html>
  <body>
  <form>Brand Name: <input type=\"text\" name=\"brand_name\"></input>
  <br> Brand Image URL: <input type=\"text\" name=\"brand_url\"></input>
  <br><input type=\"submit\"></input>";
foreach ($_POST as $key => $value) {
  echo "<input type=\"hidden\" name=\"{$key}\" value=\"{$value}\"></input>";
} else if(isset($_POST['brand_name'])){
  //add new brand to database
  $stmt=$mysqli->prepare("INSERT INTO sk8_brand (brand_name, brand_img_url) VALUES (?,?)");
  $skStmt->bind_param('ss',$_POST['brand_name'],$_POST['brand_url']);
  $skStmt->execute();
  //check for duplicate name
  $skStmt->close();
}

echo"
  </form>
  </body>
  ";
}



?>