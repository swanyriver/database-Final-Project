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
/*$deckStmt = $mysqli->prepare("select name from sk8_skateboards");
$deckStmt->execute();
$deckStmt->bind_result($deckname);
while($deckStmt->fetch()){
  echo "$deckname <br>";
}*/



echo "<div class=\"container-fluid\">
  <div class=\"row\" id=\"inventory_container\">
    <div class=\"col-md-4\">
      <h3 class=\"inventory_heading\">Decks</h3>
";
#generate decks
$query =
  "SELECT D.id, D.color, DT.name as dtname, DT.length, DT.description, B.name as Bname, B.img_url FROM sk8_deck_inv D
  INNER JOIN sk8_deck_type DT on D.fk_deck_id = DT.id 
  INNER JOIN sk8_brand B on DT.fk_brand_id = B.id";
$result = $mysqli->query($query);
while($row=$result->fetch_assoc()){
  print_r($row);
}

echo "    </div>
    <div class=\"col-md-4\">
      <h3 class=\"inventory_heading\">Trucks</h3>
";
#generate trucks

echo "</div>
    <div class=\"col-md-4\">
      <h3 class=\"inventory_heading\">Wheels</h3>
      ";
#generate wheels

echo" </div>
  </div>
</div>";


?>

</body>
</html>