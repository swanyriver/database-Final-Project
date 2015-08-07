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
    "SELECT  SK.board_name, SK.board_img_url, 
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
      $row['id']=-1;
      $row['fkid']=-1;
/*      echo "
      <div class=\"panel panel-default\">
        <div class=\"panel-heading\">Panel Header</div>
        <div class=\"panel-body\">
        <div class=\"row\">
        <div class=\"col-md-4\">";
      ";*/
      echo "<div class=\"panel panel-default\">";
      echo "<div class=\"panel-heading\">{$row['board_name']}</div>";
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
      //todo put footer here
      echo "</div>"; #panel

    }
    ?>


    </div>

  </div>
</div>

</body>
</html>