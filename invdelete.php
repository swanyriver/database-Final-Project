<?php 

ini_set('display_errors', 'On');

include "storedInfo.php"; //contains hostname/username/password/databasename
include "globalConstants.php";
include "sqloperationfunctions.php";



//check if equipment is being used in skateboard
/*$result = $mysqli->query("SELECT count(*), id, name from sk8_skateboards where fk_{$table}_id=?");
$inSkateboard = $result->fetch();
echo $inSkateboard;*/

if (!in_array($_POST['table'], $itemtables)) {
    fishy("how did you ask to delete from:{$_POST['table']}",'inventory');
}

$table = $_POST['table'];

//delete item
$delStmt=$mysqli->prepare("DELETE from sk8_{$table}_inv WHERE id=?");
$delStmt->bind_param('i',$_POST['id']);
$delStmt->execute();

//foriegn key constraint violated
if($mysqli->errno == 1451){
  $delStmt->close();

  $skStmt = $mysqli->prepare("SELECT id,board_name from sk8_skateboards where fk_{$table}_id=?");
  $skStmt->bind_param('i',$_POST['id']);
  $skStmt->execute();
  $skStmt->bind_result($id,$name);
  $skStmt->fetch();
  $skStmt->close();

  $boardmessage = "cannot delete this part right now because it is being used on skateboard: \"$name\"";

  redirect($boardmessage,'inventory');

} else if(!$mysqli->errno){
  $delStmt->close();
  redirect('Item Deleted','inventory');
} else {
  $delStmt->close();
  fishy("database error: {$mysqli->errno}",'inventory');
}

/*echo "sqli" . $mysqli->errno . $mysqli->error ."\n"; 
echo "stmt" . $delStmt->errno . $delStmt->error."\n";

$delStmt->close();

echo "sqli" . $mysqli->errno . $mysqli->error ."\n"; 
echo "stmt" . $delStmt->errno . $delStmt->error."\n";*/




