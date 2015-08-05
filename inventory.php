<?php 

ini_set('display_errors', 'On');

header('Content-Type: text/html');
include "storedInfo.php"; //contains hostname/username/password/databasename

//connect to database with created mysqli object
$mysqli = new mysqli($hostname, $Username, $Password, $DatabaseName);
if ($mysqli->connect_errno || $mysqli->connect_error)
{
  http_response_code(500);
  echo "Database currently unvailable";
  exit();
}

include "headandnav.php";
echo "<script> document.getElementById('inventory_tab').classList.add('active'); </script>";

#$deckStmt = $mysqli->prepare("SELECT T.name,T.,, from sk8_deck_inv I inner join ")

$deckStmt = $mysqli->prepare("select name from sk8_skateboards");
$deckStmt->execute();
$deckStmt->bind_result($deckname);
while($deckStmt->fetch()){
  echo "$deckname <br>";
}

?>

</body>