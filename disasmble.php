<?php 

ini_set('display_errors', 'On');

include "storedInfo.php"; //contains hostname/username/password/databasename
include "globalConstants.php";
include "sqloperationfunctions.php";

//delete skateboard
$delStmt=$mysqli->prepare("DELETE from sk8_skateboards WHERE id=?");
$delStmt->bind_param('i',$_POST['id']);
$delStmt->execute();

if(!$mysqli->errno){
  $delStmt->close();

  redirect('Skateboard disasembles','skateboards');
} else {
  $delStmt->close();
  fishy("database error: {$mysqli->errno}",'skateboards');
}



?>


