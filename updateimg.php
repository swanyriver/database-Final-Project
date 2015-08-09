<?php

ini_set('display_errors', 'On');
header('Content-Type: text/html');
include "storedInfo.php"; //contains hostname/username/password/databasename
include "globalConstants.php";
include "sqloperationfunctions.php";

if(!isset($_POST['table']) || !isset($_POST['id'])){
  fishy('how did you get to that php', 'welcome');
}

if($_POST['table']=='skateboards'){
  $redirect = 'skateboards';
} else if($_POST['table']=='riders'){
  $redirect = 'riders';
} else fishy('how did you get to that php', 'welcome');


//generate form for new url
if(!isset($_POST['img_url'])){

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

  <form class="form-inline" action="updateimg.php" method="POST"> 
  <?php
  foreach ($_POST as $key => $value) {
    echo "<input type=\"hidden\" name=\"{$key}\" value=\"{$value}\"></input>";
  }
  ?>
  <input type="url" name="img_url"></input>
  <button type="submit">Update Image URL</button>
  </form>
  </body>
  </html>

  <?php
  exit();
}

$img = $_POST['img_url'];
$id = $_POST['id'];

if($_POST['table']=='skateboards'){
  if($img=='') $query="UPDATE sk8_skateboards SET board_img_url = DEFAULT WHERE id = ?";
  else $query = "UPDATE sk8_skateboards SET board_img_url = ? WHERE id=?";
} else if($_POST['table']=='riders'){
  if($img=='') $query="UPDATE sk8_riders SET rider_img_url = DEFAULT WHERE id = ?";
  else $query = "UPDATE sk8_riders SET rider_img_url = ? WHERE id=?";
}

$stmt=$mysqli->prepare($query);
if($img=='') $stmt->bind_param('i',$id);
else $stmt->bind_param('si',$img,$id);

$stmt->execute();
if($stmt->errno){
  $error=$stmt->error;
  $number = $stmt->errno;
  $stmt->close();

  fishy($error,$redirect);
}

$stmt->close();


redirect("Image Updated", $redirect);

?>