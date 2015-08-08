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

if(isset($_POST['available'])){
  //only show parts not on boards
  $deckQuery ="";
  $truckQuery="";
  $wheelQuery="";
}else {
  $deckQuery =  
  "SELECT D.id, D.color as deckColor, DT.deck_name, DT.length, DT.description, B.brand_name as deck_brand_name, B.brand_img_url as deck_brand_img_url, D.fk_deck_id as fkid FROM sk8_deck_inv D
  INNER JOIN sk8_deck_type DT on D.fk_deck_id = DT.id 
  INNER JOIN sk8_brand B on DT.fk_brand_id = B.id";
  
  $truckQuery=
  "SELECT T.id, TT.truck_name, TT.width, B.brand_name as truck_brand_name, B.brand_img_url as truck_brand_img_url, T.fk_truck_id as fkid FROM sk8_truck_inv T
  INNER JOIN sk8_truck_type TT on T.fk_truck_id = TT.id 
  INNER JOIN sk8_brand B on TT.fk_brand_id = B.id";

  $wheelQuery=
  "SELECT W.id, W.color as wheelColor, WT.wheel_name, WT.diameter, WT.durometer, B.brand_name as wheel_brand_name, B.brand_img_url as wheel_brand_img_url, W.fk_wheel_id as fkid FROM sk8_wheel_inv W
  INNER JOIN sk8_wheel_type WT on W.fk_wheel_id=WT.id
  INNER JOIN sk8_brand B on WT.fk_brand_id = B.id";
}


include "headandnav.php";
echo "<script> document.getElementById('build_tab').classList.add('active'); </script>";

 ?>

 <div class="container-fluid">
  <div class="row">
    <div class="col-lg-2"></div>
    <div class="col-lg-8" id="boardTemplate">
      
      <div class="container-fluid">
        <div class="row">
        <div class="col-lg-4">
          <span class="builpartlabel">Deck</span>
          <div class="buildPartHolder" id="deckPart"></div>
        </div>
        <div class="col-lg-4">
          <span class="builpartlabel">Truck</span>
          <div class="buildPartHolder" id="truckPart"></div>
        </div>
        <div class="col-lg-4">
          <span class="builpartlabel">Wheel</span>
          <div class="buildPartHolder" id="wheelPart"></div>
        </div>
      </div></div>


    </div>
    <div class="col-lg-2"></div>
  </div>
 </div>

<script type="text/javascript">

  var deckPart;
  var deckkey;
  var truckPart;
  var deckkey;
  var wheelPart;
  var wheelkey;
  
  function buildselect(panel,partpanel,formfield){
    console.log(panel.getAttribute('data-id'),panel);

    partpanel.innerHTML='';
    partpanel.appendChild(panel.cloneNode(true));

    formfield.setAttribute('value',panel.getAttribute('data-id'));

    if(deckkey.value && truckkey.value && wheelkey.value){
      console.log('ready');
    }

  }

  window.onload=function setonclicks () {

    deckPart=document.getElementById('deckPart');
    truckPart=document.getElementById('truckPart');
    wheelPart=document.getElementById('wheelPart');
    deckkey=document.getElementById('deckkey');
    truckkey=document.getElementById('truckkey');
    wheelkey=document.getElementById('wheelkey');

    decks=document.getElementsByClassName('deckbuild');
    for (var i = decks.length - 1; i >= 0; i--) {
      //decks[i].setAttribute("onclick","click(this,'deck')");
      decks[i].setAttribute("onclick","buildselect(this,deckPart,deckkey)");
    };

    trucks=document.getElementsByClassName('truckbuild');
    for (var i = trucks.length - 1; i >= 0; i--) {
      trucks[i].setAttribute("onclick","buildselect(this,truckPart,truckkey)");
    };

    wheels=document.getElementsByClassName('wheelbuild');
    for (var i = wheels.length - 1; i >= 0; i--) {
      wheels[i].setAttribute("onclick","buildselect(this,wheelPart,wheelkey)");
    };
  }

</script>





<div class="container-fluid">
  <div class="row" id="inventory_container">
    <div class="col-md-4">
      <h3 class="inventory_heading">Decks</h3>


<?php
#generate decks
$result = $mysqli->query($deckQuery);
while($row=$result->fetch_assoc()){
  makeDeckInv($row, 'buildPanel deckbuild');
}
?>
</div>
<div class="container-fluid">
  <div class="row" id="inventory_container">
    <div class="col-md-4">
      <h3 class="inventory_heading">Trucks</h3>

<?php
#generate trucks
$result = $mysqli->query($truckQuery);
while($row=$result->fetch_assoc()){
  makeTruckInv($row, 'buildPanel truckbuild');
}
?>
</div>
<div class="container-fluid">
  <div class="row" id="inventory_container">
    <div class="col-md-4">
      <h3 class="inventory_heading">Wheels</h3>


<?php
#generate wheels
$result = $mysqli->query($wheelQuery);
while($row=$result->fetch_assoc()){
  makeWheelInv($row, 'buildPanel wheelbuild');
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
        <h4 class="modal-title">Your New Board is almost built</h4>
      </div>
      <div class="modal-body">
      <form action="buildboardsql.php" method="post">

      <input id="deckkey" type="hidden" name="fk_deck_id" value=""></input>
      <input id="truckkey" type="hidden" name="fk_truck_id" value=""></input>
      <input id="wheelkey" type="hidden" name="fk_wheel_id" value=""></input>
      
      What is it's name:<input type="text" name="board_name"></input><br>
      (Optional) URL for a picture of it<input type="text" name="board_img_url"></input>

      <button type="submit">
        <span class="glyphicon glyphicon-plus"> </span>
        </button>
      </form>
      </div>
    </div>
    
  </div>
</div>

</html>