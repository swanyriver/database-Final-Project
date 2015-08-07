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

<script type="text/javascript">
  function colorform ( id , table , fkid ) {
    document.getElementById('colorid').value=id;
    document.getElementById('colortable').value=table;
    document.getElementById('colorfkid').value=fkid;
    $("#colorModal").modal();
  }
  function toggleinputs(group){
    panel=document.getElementById(group+'form');
    left=document.getElementById(group+'left');
    down=document.getElementById(group+'down');

    if (panel.hasAttribute('hidden')) {
      panel.removeAttribute('hidden');
      down.removeAttribute('hidden');
      left.setAttribute('hidden', true);
    }else {
      panel.setAttribute('hidden', true);
      down.setAttribute('hidden', true);
      left.removeAttribute('hidden');
    }
  }
</script>

<form class="form-inline" action="addbrand.php" method="POST">
  <button type="submit" class="btn btn-default">Add Brand</button>
  <div class="form-group">
    <label for="brandnameinput">Brand Name</label>
    <input type="text" class="form-control" id="brandnameinput" name="brand_name">
  </div>
  <div class="form-group">
    <label for="brandurlinput">Image URL</label>
    <input type="text" class="form-control" id="brandurlinput" name="brand_url">
  </div>
  
</form>


<div class="container-fluid">
  <div class="row" id="inventory_container">
    <div class="col-md-4">
      <h3 class="inventory_heading">Decks</h3>
<!--create new deck-->
<div class="panel panel-default addPanel">
  <div class="panel-heading" onclick="toggleinputs('deck')">Add New Deck
  <div id="deckleft"><span class="glyphicon glyphicon-chevron-left"></span></div>
  <div hidden id="deckdown"><span class="glyphicon glyphicon-chevron-down"></span></div>
  </div>
  <div class="panel-body" hidden id="deckform">
    <form class="form-inline" action="addinv.php" method="POST">
      <div class="form-group">
        <label>Brand:</label>
        <?php echo getBrandSelector($mysqli) ?>
      </div><br>
      <div class="form-group">
        <label>Name:</label>
        <input type="text" class="form-control" name="name">
      </div><br>
      <div class="form-group">
        <label>Length:</label>
        <input type="number" class="form-control" name="length">
      </div><br>
      <div class="form-group">
        <label>Description:</label>
        <input type="text" class="form-control" name="description">
      </div><br>
      <div class="form-group">
        <label>Color:</label>
        <input type="text" class="form-control" name="color">
      </div><br>
      <input type="hidden" name="table" value="deck">
      <button type="submit" class="btn btn-default">Add Deck</button>
    </form>
  </div>
</div>

<?php
#generate decks
$query =
  "SELECT D.id, D.color as deckColor, DT.deck_name, DT.length, DT.description, B.brand_name as deck_brand_name, B.brand_img_url as deck_brand_img_url, D.fk_deck_id as fkid FROM sk8_deck_inv D
  INNER JOIN sk8_deck_type DT on D.fk_deck_id = DT.id 
  INNER JOIN sk8_brand B on DT.fk_brand_id = B.id";
$result = $mysqli->query($query);
while($row=$result->fetch_assoc()){
  makeDeckInv($row, 'inventoryPanel');
}
?>
</div>
<div class="container-fluid">
  <div class="row" id="inventory_container">
    <div class="col-md-4">
      <h3 class="inventory_heading">Trucks</h3>
<!--create new truck-->
<div class="panel panel-default addPanel">
  <div class="panel-heading" onclick="toggleinputs('truck')">Add New Trucks
  <div id="truckleft"><span class="glyphicon glyphicon-chevron-left"></span></div>
  <div hidden id="truckdown"><span class="glyphicon glyphicon-chevron-down"></span></div>
  </div>
  <div class="panel-body" hidden id="truckform">
    <form class="form-inline" action="addinv.php" method="POST">
      <div class="form-group">
        <label>Brand:</label>
        <?php echo getBrandSelector($mysqli) ?>
      </div><br>
      <div class="form-group">
        <label>Name:</label>
        <input type="text" class="form-control" name="name">
      </div><br>
      <div class="form-group">
        <label>Width:</label>
        <input type="number" class="form-control" name="width">
      </div><br>
      <input type="hidden" name="table" value="truck">
      <button type="submit" class="btn btn-default">Add Truck</button>
    </form>
  </div>
</div>
<?php
#generate trucks
$query =
  "SELECT T.id, TT.truck_name, TT.width, B.brand_name as truck_brand_name, B.brand_img_url as truck_brand_img_url, T.fk_truck_id as fkid FROM sk8_truck_inv T
  INNER JOIN sk8_truck_type TT on T.fk_truck_id = TT.id 
  INNER JOIN sk8_brand B on TT.fk_brand_id = B.id";
$result = $mysqli->query($query);
while($row=$result->fetch_assoc()){
  makeTruckInv($row, 'inventoryPanel');
}
?>
</div>
<div class="container-fluid">
  <div class="row" id="inventory_container">
    <div class="col-md-4">
      <h3 class="inventory_heading">Wheels</h3>
<!--create new wheel-->
<div class="panel panel-default addPanel">
  <div class="panel-heading" onclick="toggleinputs('wheel')">Add New Wheels
  <div id="wheelleft"><span class="glyphicon glyphicon-chevron-left"></span></div>
  <div hidden id="wheeldown"><span class="glyphicon glyphicon-chevron-down"></span></div>
  </div>  <div class="panel-body" hidden id="wheelform">
    <form class="form-inline" action="addinv.php" method="POST">
      <div class="form-group">
        <label>Brand:</label>
        <?php echo getBrandSelector($mysqli) ?>
      </div><br>
      <div class="form-group">
        <label>Name:</label>
        <input type="text" class="form-control" name="name">
      </div><br>
      <div class="form-group">
        <label>Diameter:</label>
        <input type="number" class="form-control" name="diameter">
      </div><br>
      <div class="form-group">
        <label>Durometer:</label>
        <input type="number" class="form-control" name="durometer">
      </div><br>
      <div class="form-group">
        <label>Color:</label>
        <input type="text" class="form-control" name="color">
      </div><br>
      <input type="hidden" name="table" value="wheel">
      <button type="submit" class="btn btn-default">Add Wheels</button>
    </form>
  </div>
</div>

<?php
#generate wheels
$query = 
  "SELECT W.id, W.color as wheelColor, WT.wheel_name, WT.diameter, WT.durometer, B.brand_name as wheel_brand_name, B.brand_img_url as wheel_brand_img_url, W.fk_wheel_id as fkid FROM sk8_wheel_inv W
  INNER JOIN sk8_wheel_type WT on W.fk_wheel_id=WT.id
  INNER JOIN sk8_brand B on WT.fk_brand_id = B.id";
$result = $mysqli->query($query);
while($row=$result->fetch_assoc()){
  makeWheelInv($row, 'inventoryPanel');
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