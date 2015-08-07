<?php

function getBrandSelector($mysqli){
  $select= "
    <select>

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

//todo pass id and appropriate phps for edit or delete
function getHeading($brand,$part,$id,$table){
return "
    <div class=\"panel-heading\">
    <span class=\"brandName\"> $brand:</span> 
    <span class=\"partName\">$part</span>
    <span class=\"inventorycontrols\" > 
      <form action=\"invdelete.php\" method=\"post\">
      <input type=\"hidden\" name=\"id\" value=\"{$id}\"></input>
      <input type=\"hidden\" name=\"table\" value=\"{$table}\"></input>
      <button type=\"submit\">
        <span class=\"glyphicon glyphicon-remove\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Delete Item\"> </span>
        </button>
      </form>
    </span>
    </div>";
}

function makeDeckInv($invAssoc){

  $heading = getHeading($invAssoc['brand_name'],$invAssoc['deck_name'], $invAssoc['id'],'deck');

  echo "
  <div class=\"panel panel-default inventoryPanel\" data-id=\"{$invAssoc['id']}\">
    $heading
    <div class=\"panel-body inventoryPanelBody\">
    <img src=\"{$invAssoc['brand_img_url']}\" class=\"inv_back_brand\">
    <span class=\"category\">Length:</span> <span class=\"info\" >{$invAssoc['length']} inches</span>
    <br><span class=\"category\">Color:</span> <span class=\"info\" >{$invAssoc['color']}</span>
    <br><span class=\"category\">Description:</span> <span class=\"info\" >{$invAssoc['description']}</span>

    </div>
  </div>
";
}

function makeTruckInv($invAssoc){

  $heading = getHeading($invAssoc['brand_name'],$invAssoc['truck_name'],$invAssoc['id'],'truck');

  echo "
  <div class=\"panel panel-default inventoryPanel\" data-id=\"{$invAssoc['id']}\">
    $heading
    <div class=\"panel-body inventoryPanelBody\">
    <img src=\"{$invAssoc['brand_img_url']}\" class=\"inv_back_brand\">
    <span class=\"category\">Width:</span> <span class=\"info\" >{$invAssoc['width']} inches</span>
  
    </div>
  </div>
";
}

function makeWheelInv($invAssoc){

  $heading = getHeading($invAssoc['brand_name'],$invAssoc['wheel_name'],$invAssoc['id'],'wheel');

  echo "
  <div class=\"panel panel-default inventoryPanel\" data-id=\"{$invAssoc['id']}\">
    $heading
    <div class=\"panel-body inventoryPanelBody\">
    <img src=\"{$invAssoc['brand_img_url']}\" class=\"inv_back_brand\">
    <span class=\"category\">Diameter:</span> <span class=\"info\" >{$invAssoc['diameter']}mm</span>
    <br><span class=\"category\">Durometer:</span> <span class=\"info\" >{$invAssoc['durometer']}A</span>
    <br><span class=\"category\">Color:</span> <span class=\"info\" >{$invAssoc['color']}</span>

    </div>
  </div>
";
}

?>