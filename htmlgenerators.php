<?php

//todo pass id and appropriate phps for edit or delete
function getHeading($brand,$part){
return "
    <div class=\"panel-heading\">
    <span class=\"brandName\"> $brand:</span> 
    <span class=\"partName\">$part</span>
    <span class=\"inventorycontrols\" > * * </span>
    </div>";
}

function makeDeckInv($invAssoc){

  $heading = getHeading($invAssoc['brand_name'],$invAssoc['deck_name']);

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

  $heading = getHeading($invAssoc['brand_name'],$invAssoc['truck_name']);

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

  $heading = getHeading($invAssoc['brand_name'],$invAssoc['wheel_name']);

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