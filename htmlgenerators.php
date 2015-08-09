<?php

function getBrandSelector($mysqli){
  $select= "
    <select name=\"brand_id\">

  ";
  $stmt=$mysqli->prepare("SELECT id,brand_name from sk8_brand");
  $stmt->execute();
  $stmt->bind_result($id,$name);
  while($stmt->fetch()){
    $select=$select . "<option value=\"$id\">$name</option>";
  }
  $select = $select . "</select>";
  $stmt->close();
  return $select;
}

function getAddButton($id,$table,$fkid){

  if($table=='truck') return "<form action=\"addinv.php\" method=\"post\">
      <input type=\"hidden\" name=\"id\" value=\"{$id}\"></input>
      <input type=\"hidden\" name=\"table\" value=\"{$table}\"></input>
      <input type=\"hidden\" name=\"fkid\" value=\"{$fkid}\"></input>
      <button type=\"submit\">
        <span class=\"glyphicon glyphicon-plus\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Add another of this item\"> </span>
        </button>
      </form>";

  return "
    <button onclick=\"colorform( $id , '$table' , $fkid )\">
      <span class=\"glyphicon glyphicon-plus\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Add another of this item\"> </span>
      </button>
  ";

}

//todo pass id and appropriate phps for edit or delete
function getHeading($brand,$part,$id,$table,$fkid){
  $add = getAddButton($id,$table,$fkid);
  return "
    <div class=\"panel-heading\">
    <span class=\"brandName\"> $brand:</span> 
    <span class=\"partName\">$part</span>
    <span class=\"inventorycontrols\" > 
      

    $add      

      <form action=\"invdelete.php\" method=\"post\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Delete Item\">
      <input type=\"hidden\" name=\"id\" value=\"{$id}\"></input>
      <input type=\"hidden\" name=\"table\" value=\"{$table}\"></input>
      <button type=\"submit\">
        <span class=\"glyphicon glyphicon-remove\" > </span>
        </button>
      </form>

    </span>
    </div>";
}

function makeDeckInv($invAssoc,$panelclass){

  $heading = getHeading($invAssoc['deck_brand_name'],$invAssoc['deck_name'], $invAssoc['id'],'deck',$invAssoc['fkid']);

  echo "
  <div class=\"panel panel-default {$panelclass}\" data-id=\"{$invAssoc['id']}\">
    $heading
    <div class=\"panel-body inventoryPanelBody\">
    <img src=\"{$invAssoc['deck_brand_img_url']}\" class=\"inv_back_brand\">
    <span class=\"category\">Length:</span> <span class=\"info\" >{$invAssoc['length']} inches</span>
    <br><span class=\"category\">Color:</span> <span class=\"info\" >{$invAssoc['deckColor']}</span>
    <br><span class=\"category\">Description:</span> <span class=\"info\" >{$invAssoc['description']}</span>

    </div>
  </div>
";
}

function makeTruckInv($invAssoc, $panelclass){

  $heading = getHeading($invAssoc['truck_brand_name'],$invAssoc['truck_name'],$invAssoc['id'],'truck',$invAssoc['fkid']);

  echo "
  <div class=\"panel panel-default {$panelclass}\" data-id=\"{$invAssoc['id']}\">
    $heading
    <div class=\"panel-body inventoryPanelBody\">
    <img src=\"{$invAssoc['truck_brand_img_url']}\" class=\"inv_back_brand\">
    <span class=\"category\">Width:</span> <span class=\"info\" >{$invAssoc['width']} inches</span>
  
    </div>
  </div>
";
}

function makeWheelInv($invAssoc, $panelclass){

  $heading = getHeading($invAssoc['wheel_brand_name'],$invAssoc['wheel_name'],$invAssoc['id'],'wheel',$invAssoc['fkid']);

  echo "
  <div class=\"panel panel-default {$panelclass}\" data-id=\"{$invAssoc['id']}\">
    $heading
    <div class=\"panel-body inventoryPanelBody\">
    <img src=\"{$invAssoc['wheel_brand_img_url']}\" class=\"inv_back_brand\">
    <span class=\"category\">Diameter:</span> <span class=\"info\" >{$invAssoc['diameter']}mm</span>
    <br><span class=\"category\">Durometer:</span> <span class=\"info\" >{$invAssoc['durometer']}A</span>
    <br><span class=\"category\">Color:</span> <span class=\"info\" >{$invAssoc['wheelColor']}</span>

    </div>
  </div>
";
}

function createSkateboardLink($id,$name)
{
  return "<a href=\"skateboards.php#{$id}\"> $name </a>";
}

function createRiderLink($id,$name)
{
  return "<a href=\"riders.php#{$id}\"> $name </a>";
}

function getBoardelem($skid,$name,$rid){
  $elem = '';
  //encase in div

  //get link to skateboard
  $elem .= createSkateboardLink($skid,$name);
  //create button to remove relationship

  return $elem;
}

function getRiderelem($rid,$name,$skid){
  $elem = '';
  //encase in span
  //get link to skateboard
  $elem .= createRiderLink($rid,$name);
  //create button to remove relationship

  return $elem;
}

?>