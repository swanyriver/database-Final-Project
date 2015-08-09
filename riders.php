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
$stmt = $mysqli->prepare(
"SELECT fk_skateboard_id, fk_rider_id, B.board_name
FROM sk8_riders_skateboards
INNER JOIN sk8_skateboards B ON B.id = fk_skateboard_id");
$stmt->execute();
$stmt->bind_result($skid,$rid,$name);
while($stmt->fetch()){
  if(!isset($combinations[$rid])) $combinations[$rid] = "";
  $combinations[$rid] .= getBoardelem($skid,$name,$rid);
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
$stmt->bind_result($skid,$name,$rid,$notused);
while($stmt->fetch()){
  if(!isset($possibles[$rid])) $possibles[$rid] ="";
  $possibles[$rid] .= "<option value=\"{$skid}\"> $name </option>";
}
$stmt->close();
foreach ($possibles as $key => $value) {
  $possibles[$key] = "<form class=\"addRiderForm\" action=\"addboardrider.php\" method=\"POST\" >" 
                    . "<input type=\"hidden\" name=\"rid\" value=\"{$key}\"></input>"
                    . "<input type=\"hidden\" name=\"redirect\" value=\"riders\"></input>"
                    . "<select name=\"skid\">"
                    . $value
                    . "</select> <button type=\"submit\"> add board </button> </form>";
}


include "headandnav.php";
echo "<script> document.getElementById('riders_tab').classList.add('active'); </script>";

?>

<form class="form-inline addform" action="addrider.php" method="POST">
  
  <div class="form-group">
    <label for="ridernameinput">Rider Name</label>
    <input type="text" class="form-control" id="ridernameinput" name="rider_name">
  </div>
  <div class="form-group">
    <label for="riderurlinput">Image URL</label>
    <input type="text" class="form-control" id="riderurlinput" name="rider_url">
  </div>

  <button type="submit" class="btn btn-default">Add Rider</button>
  
</form>


<div class="container-fluid">
  <div class="row" id="rider_container">
    <div class="col-md-7">
    
    <?php
    #get riders
    $stmt = $mysqli->prepare("SELECT id, rider_name, rider_img_url FROM sk8_riders");
    $stmt->execute();
    $stmt->bind_result($id,$name,$img);
    while($stmt->fetch()){

      echo "<a name=\"{$id}\"> </a>";
      echo "<div class=\"panel panel-default\">";
      echo "<div class=\"panel-heading\"> $name ";
      echo" <span class=\"inventorycontrols\" > 
      
      <form action=\"removeRider.php\" method=\"post\" data-toggle=\"tooltip\" data-placement=\"left\" title=\"Remove Rider\">
      <input type=\"hidden\" name=\"id\" value=\"{$id}\"></input>
      <button type=\"submit\">
        <span class=\"glyphicon glyphicon-remove\" > </span>
        </button>
      </form>

      </span>";

      echo "</div> <!-- heading -->";
      echo "<div class=\"panel-body\">";

      echo "<div class=\"container-fluid\"> <div class=\"row\">";
      echo "<div class=\"col-md-4\">";

      echo "<img class=\"riderimg\" src=\"{$img}\"></img>";
      
      echo "</div>"; #col

      echo "<div class=\"col-md-8\">";
      
      //boards and add boards controls
      if(isset($combinations[$id])) echo "Rides Boards:" . $combinations[$id];
      if(isset($possibles[$id])) echo $possibles[$id];

      echo "</div>"; #col

      echo "</div></div>";  #Row #fluid
      echo "</div>"; #body
      echo "</div>"; #panel

    }
    ?>


    </div>

  </div>
</div>

</body>
</html>