<?php 

ini_set('display_errors', 'On');

header('Content-Type: text/html');
include "storedInfo.php"; //contains hostname/username/password/databasename
include "htmlgenerators.php";

//connect to database with created mysqli object
$mysqli = new mysqli($hostname, $Username, $Password, $DatabaseName);
if ($mysqli->connect_errno || $mysqli->connect_error)
{
  http_response_code(500);
  echo "Database currently unvailable";
  exit();
}

//generate panel footers with riders and add riders form
$combinations = array();
$possibles= array();

//create links to skateboards riders
$stmt = $mysqli->prepare("SELECT fk_skateboard_id, fk_rider_id, R.rider_name from sk8_riders_skateboards 
                          INNER JOIN sk8_riders R on R.id = fk_rider_id");
$stmt->execute();
$stmt->bind_result($skid,$rid,$name);
while($stmt->fetch()){
  if(!isset($combinations[$skid])) $combinations[$skid] = "";
  $combinations[$skid] .= getRiderelem($rid,$name,$skid);
}
$stmt->close();

//create dropdown menues for all possible riders for all skateboards
// using a left outer join on with the riders/skateboard many-to-many table
// and a cross-product table of all riders and skateboarders
$stmt = $mysqli->prepare(
"SELECT POSSIBLES.skid, POSSIBLES.board_name, POSSIBLES.rid, POSSIBLES.rider_name
FROM (select B.id as skid, B.board_name, R.id as rid, R.rider_name
FROM sk8_skateboards B INNER JOIN sk8_riders R) POSSIBLES
LEFT OUTER JOIN sk8_riders_skateboards RS
ON RS.fk_rider_id = POSSIBLES.rid AND RS.fk_skateboard_id = POSSIBLES.skid
WHERE RS.fk_rider_id IS null;");

$stmt->execute();
$stmt->bind_result($skid,$notused,$rid,$name);
while($stmt->fetch()){
  if(!isset($possibles[$skid])) $possibles[$skid] ="";
  $possibles[$skid] .= "<option value=\"{$rid}\"> $name </option>";
}
$stmt->close();
foreach ($possibles as $key => $value) {
  $possibles[$key] = "<form class=\"addRiderForm\" action=\"addboardrider.php\" method=\"POST\" >" 
                    . "<input type=\"hidden\" name=\"skid\" value=\"{$key}\"></input>"
                    . "<select name=\"rid\">"
                    . $value
                    . "</select> <button type=\"submit\"> add rider </button> </form>";
}



include "headandnav.php";
echo "<script> document.getElementById('skateboards_tab').classList.add('active'); </script>";

?>

<div class="container-fluid">
  <div class="row" id="skateboard_container">
    <div class="col-md-7">
    
    <?php
    #get skateboards
    #select all parts,details, and brands of a skateboard
    $query =
    "SELECT SK.id, SK.board_name, SK.board_img_url, 
            DT.deck_name, DT.length, DT.description, DI.color as deckColor, 
            DB.deck_brand_name, DB.deck_brand_img_url,
            TT.truck_name, TT.width, TB.truck_brand_name, TB.truck_brand_img_url,
            WT.wheel_name, WT.diameter, WT.durometer, WI.color as wheelColor,
            WB.wheel_brand_name, WB.wheel_brand_img_url
    from sk8_skateboards SK
    inner join sk8_deck_inv DI on SK.fk_deck_id = DI.id
    inner join sk8_deck_type DT on DI.fk_deck_id = DT.id
    inner join sk8_truck_inv TI on SK.fk_truck_id = TI.id
    inner join sk8_truck_type TT on TI.fk_truck_id = TT.id
    inner join sk8_wheel_inv WI on SK.fk_wheel_id = WI.id
    inner join sk8_wheel_type WT on WI.fk_wheel_id = WT.id
    inner join (select WT.id, B.brand_name as wheel_brand_name, B.brand_img_url as wheel_brand_img_url from sk8_brand B
    inner join sk8_wheel_type WT on WT.fk_brand_id = B.id) WB on WT.id = WB.id
    inner join (select TT.id, B.brand_name as truck_brand_name, B.brand_img_url as truck_brand_img_url from sk8_brand B
    inner join sk8_truck_type TT on TT.fk_brand_id = B.id) TB on TT.id = TB.id
    inner join (select DT.id, B.brand_name as deck_brand_name, B.brand_img_url as deck_brand_img_url from sk8_brand B
    inner join sk8_deck_type DT on DT.fk_brand_id = B.id) DB on DT.id = DB.id;";

    $result = $mysqli->query($query);
    while($row=$result->fetch_assoc()){
      $id=$row['id'];
      $row['id']=-1;
      $row['fkid']=-1;

      echo "<a name=\"{$id}\"> </a>";
      echo "<div class=\"panel panel-default\">";
      echo "<div class=\"panel-heading\">{$row['board_name']}";
      echo" <span class=\"inventorycontrols\" >

      <form action=\"updateimg.php\" method=\"post\" data-toggle=\"tooltip\" data-placement=\"left\" title=\"Change Image\">
      <input type=\"hidden\" name=\"id\" value=\"{$id}\"></input>
      <input type=\"hidden\" name=\"table\" value=\"skateboards\"></input>
      <button type=\"submit\">
        <span class=\"glyphicon glyphicon-pencil\" > </span>
        </button>
      </form> 
      
      <form action=\"disasmble.php\" method=\"post\" data-toggle=\"tooltip\" data-placement=\"left\" title=\"Disasemble Skateboard\">
      <input type=\"hidden\" name=\"id\" value=\"{$id}\"></input>
      <button type=\"submit\">
        <span class=\"glyphicon glyphicon-wrench\" > </span>
        </button>
      </form>

    </span>";

      echo "</div> <!-- heading -->";
      echo "<div class=\"panel-body\">";
      echo "<img class=\"boardimage\" src=\"{$row['board_img_url']}\"></img>";
      echo "<div class=\"container-fluid\"> <div class=\"row\">";

      echo "<div class=\"col-md-4\">";
      makeDeckInv($row, 'skateboardPanel');
      echo "</div>"; #col

      echo "<div class=\"col-md-4\">";
      makeTruckInv($row, 'skateboardPanel');
      echo "</div>"; #col

      echo "<div class=\"col-md-4\">";
      makeWheelInv($row, 'skateboardPanel');
      echo "</div>"; #col

      echo "</div></div>"; #fluid #Row
      echo "</div>"; #body

      ## panel footer, for rider display and controls
      echo "<div class=\"panel-footer\">";

      if(isset($combinations[$id])) echo "Riders:" . $combinations[$id];
      if(isset($possibles[$id])) echo $possibles[$id];

      echo "</div></div>"; #fodter #panel

    }
    ?>


    </div>

  </div>
</div>

</body>
</html>