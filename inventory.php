<?php 

ini_set('display_errors', 'On');

header('Content-Type: text/html');
include "storedInfo.php"; //contains hostname/username/password/databasename
include "htmlgenerators.php";
include "globalConstants.php";

//connect to database with created mysqli object
$mysqli = new mysqli($hostname, $Username, $Password, $DatabaseName);
if ($mysqli->connect_errno || $mysqli->connect_error)
{
  http_response_code(500);
  echo "Database currently unvailable";
  exit();
}

$brand_selector=getBrandSelector($mysqli);

include "headandnav.php";
echo "<script> document.getElementById('inventory_tab').classList.add('active'); </script>";
?>


<?php
echo "<div class=\"container-fluid\">
  <div class=\"row\" id=\"inventory_container\">
    <div class=\"col-md-4\">
      <h3 class=\"inventory_heading\">Decks</h3>
";

#create new deck

#add deck option


#generate decks
$query =
  "SELECT D.id, D.color, DT.deck_name, DT.length, DT.description, B.brand_name, B.brand_img_url FROM sk8_deck_inv D
  INNER JOIN sk8_deck_type DT on D.fk_deck_id = DT.id 
  INNER JOIN sk8_brand B on DT.fk_brand_id = B.id";
$result = $mysqli->query($query);
while($row=$result->fetch_assoc()){
  makeDeckInv($row);
}

echo "    </div>
    <div class=\"col-md-4\">
      <h3 class=\"inventory_heading\">Trucks</h3>
";
#generate trucks
$query =
  "SELECT T.id, TT.truck_name, TT.width, B.brand_name, B.brand_img_url FROM sk8_truck_inv T
  INNER JOIN sk8_truck_type TT on T.fk_truck_id = TT.id 
  INNER JOIN sk8_brand B on TT.fk_brand_id = B.id";
$result = $mysqli->query($query);
while($row=$result->fetch_assoc()){
  makeTruckInv($row);
}

echo "</div>
    <div class=\"col-md-4\">
      <h3 class=\"inventory_heading\">Wheels</h3>
      ";
#generate wheels
$query = 
  "SELECT W.id, W.color, WT.wheel_name, WT.diameter, WT.durometer, B.brand_name, B.brand_img_url FROM sk8_wheel_inv W
  INNER JOIN sk8_wheel_type WT on W.fk_wheel_id=WT.id
  INNER JOIN sk8_brand B on WT.fk_brand_id = B.id";
$result = $mysqli->query($query);
while($row=$result->fetch_assoc()){
  makeWheelInv($row);
}

echo" </div>
  </div>
</div>";


?>

</body>
</html>