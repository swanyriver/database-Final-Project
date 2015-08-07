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


include "headandnav.php";
echo "<script> document.getElementById('build_tab').classList.add('active'); </script>";

 ?>







<div class="container-fluid">
  <div class="row" id="inventory_container">
    <div class="col-md-4">
      <h3 class="inventory_heading">Decks</h3>


<?php
#generate decks
$query =
  "SELECT D.id, D.color as deckColor, DT.deck_name, DT.length, DT.description, B.brand_name as deck_brand_name, B.brand_img_url as deck_brand_img_url, D.fk_deck_id as fkid FROM sk8_deck_inv D
  INNER JOIN sk8_deck_type DT on D.fk_deck_id = DT.id 
  INNER JOIN sk8_brand B on DT.fk_brand_id = B.id";
$result = $mysqli->query($query);
while($row=$result->fetch_assoc()){
  makeDeckInv($row, 'buildPanel');
}
?>
</div>
<div class="container-fluid">
  <div class="row" id="inventory_container">
    <div class="col-md-4">
      <h3 class="inventory_heading">Trucks</h3>

<?php
#generate trucks
$query =
  "SELECT T.id, TT.truck_name, TT.width, B.brand_name as truck_brand_name, B.brand_img_url as truck_brand_img_url, T.fk_truck_id as fkid FROM sk8_truck_inv T
  INNER JOIN sk8_truck_type TT on T.fk_truck_id = TT.id 
  INNER JOIN sk8_brand B on TT.fk_brand_id = B.id";
$result = $mysqli->query($query);
while($row=$result->fetch_assoc()){
  makeTruckInv($row, 'buildPanel');
}
?>
</div>
<div class="container-fluid">
  <div class="row" id="inventory_container">
    <div class="col-md-4">
      <h3 class="inventory_heading">Wheels</h3>
<!--create new wheel-->


<?php
#generate wheels
$query = 
  "SELECT W.id, W.color as wheelColor, WT.wheel_name, WT.diameter, WT.durometer, B.brand_name as wheel_brand_name, B.brand_img_url as wheel_brand_img_url, W.fk_wheel_id as fkid FROM sk8_wheel_inv W
  INNER JOIN sk8_wheel_type WT on W.fk_wheel_id=WT.id
  INNER JOIN sk8_brand B on WT.fk_brand_id = B.id";
$result = $mysqli->query($query);
while($row=$result->fetch_assoc()){
  makeWheelInv($row, 'buildPanel');
}

echo" </div>
  </div>
</div>";


?>

</body>


<!-- Modal -->
<div class="modal fade" id="colorModal" role="dialog">
  <div class="modal-dialog">
  
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">What color is it?</h4>
      </div>
      <div class="modal-body">
      <form action="addinv.php" method="post">
      <input id="colorid" type="hidden" name="id" value=""></input>
      <input id="colortable" type="hidden" name="table" value=""></input>
      <input id="colorfkid" type="hidden" name="fkid" value=""></input>
      <input type="text" name="color"></input>
      <button type="submit">
        <span class="glyphicon glyphicon-plus"> </span>
        </button>
      </form>
      </div>
    </div>
    
  </div>
</div>

</html>