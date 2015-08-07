<?php

ini_set('display_errors', 'On');
header('Content-Type: text/html');
include "globalConstants.php";
include "storedInfo.php"; //contains hostname/username/password/databasename

//connect to database with created mysqli object
$mysqli = new mysqli($hostname, $Username, $Password, $DatabaseName);
if ($mysqli->connect_errno || $mysqli->connect_error)
{
  http_response_code(500);
  echo "Database currently unvailable";
  exit();
}

if (!in_array($_POST['table'], $itemtables)) {
    fishy("how did you ask to delete from:{$_POST['table']}");
}



?>