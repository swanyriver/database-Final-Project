<?php
//connect to database with created mysqli object
$mysqli = new mysqli($hostname, $Username, $Password, $DatabaseName);
if ($mysqli->connect_errno || $mysqli->connect_error)
{
  http_response_code(500);
  echo "Database currently unvailable";
  exit();
}

function redirect($message,$page){
  $path = explode('/', $_SERVER['PHP_SELF'], -1);
  $path = implode('/',$path);
  $redirect = "http://" . $_SERVER['HTTP_HOST'] . $path;
  if ($message) $message="?message=".$message;
  header("Location: {$redirect}/{$page}.php{$message}", true);
  exit();
}

function fishy($error,$page){
  $msg = "something fishy is going on here:".$error;
  redirect($msg . '&error=true',$page);
}
?>