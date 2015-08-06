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
  if ($message) $message="?$message=".$message
  header("Location: {$redirect}/inventory.php{$message}", true);
  exit();
}

function fishy($error){
  $msg = "something fishy is going on here:".$error;
  redirect($msg . '&error=true');
}

//if(!isset($_POST['redirect'])){}

$tables = array("wheel","truck","deck");
if (!in_array($_POST['table'], $tables)) {
    fishy("how did you ask to delete from:{$_POST['table']}");
}

$table = $_POST['table'];

//get type id
$typeStmt=$mysqli->prepare("SELECT fk_{$table}_id from sk8_{$table}_inv WHERE id=?");
$typeStmt->bind_param('i',$_POST['id']);
$typeStmt->execute();
$typeStmt->bind_result($typeID);
$typeStmt->fetch();
$typeStmt->close();


//delete item
$delStmt=$mysqli->prepare("DELETE from sk8_{$table}_inv WHERE id=?");
$delStmt->bind_param('i',$_POST['id']);
$delStmt->execute();
$delStmt->close();


//check that type is still being used
$crStmt = $mysqli->prepare("SELECT COUNT(*) FROM sk8_{$table}_inv WHERE id = ?");
$crStmt->bind_param("i",$typeID);
$crStmt->execute();
$crStmt->bind_result($itemCount);
$crStmt->fetch();
$crStmt->close();

//remove type if not being used
if(!$itemCount){
  $delStmt=$mysqli->prepare("DELETE from sk8_{$table}_inv WHERE id=?");
  $delStmt->bind_param('i',$typeID);
  $delStmt->execute();
  $delStmt->close();
}

redirect('');