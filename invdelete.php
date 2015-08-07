<?php 

ini_set('display_errors', 'On');

include "storedInfo.php"; //contains hostname/username/password/databasename

//connect to database with created mysqli object
$mysqli = new mysqli($hostname, $Username, $Password, $DatabaseName);
if ($mysqli->connect_errno || $mysqli->connect_error)
{
  http_response_code(500);
  echo "Database currently unvailable";
  exit();
}

function redirect($message){
  $path = explode('/', $_SERVER['PHP_SELF'], -1);
  $path = implode('/',$path);
  $redirect = "http://" . $_SERVER['HTTP_HOST'] . $path;
  if ($message) $message="?message=".$message;
  header("Location: {$redirect}/inventory.php{$message}", true);
  echo "{$redirect}/inventory.php{$message}";
  exit();
}

function fishy($error){
  $msg = "something fishy is going on here:".$error;
  redirect($msg . '&error=true');
}

//check if equipment is being used in skateboard
/*$result = $mysqli->query("SELECT count(*), id, name from sk8_skateboards where fk_{$table}_id=?");
$inSkateboard = $result->fetch();
echo $inSkateboard;*/

$tables = array("wheel","truck","deck");
if (!in_array($_POST['table'], $tables)) {
    fishy("how did you ask to delete from:{$_POST['table']}");
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

  echo $id,$name;
  exit();


} else if(!$mysqli->errno){
  $delStmt->close();
  redirect('Item Deleted');
} else {
  $delStmt->close();
  fishy("database error: {$mysqli->errno}");
}

/*echo "sqli" . $mysqli->errno . $mysqli->error ."\n"; 
echo "stmt" . $delStmt->errno . $delStmt->error."\n";

$delStmt->close();

echo "sqli" . $mysqli->errno . $mysqli->error ."\n"; 
echo "stmt" . $delStmt->errno . $delStmt->error."\n";*/




