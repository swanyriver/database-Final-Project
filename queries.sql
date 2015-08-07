# get information for each deck in inventory
SELECT D.id, D.color, DT.deck_name, DT.length, DT.description, B.brand_name, B.brand_img_url FROM sk8_deck_inv D
INNER JOIN sk8_deck_type DT on D.fk_deck_id = DT.id 
INNER JOIN sk8_brand B on DT.fk_brand_id = B.id;

SELECT T.id, TT.truck_name, TT.width, B.brand_name, B.brand_img_url FROM sk8_truck_inv T
INNER JOIN sk8_truck_type TT on T.fk_truck_id = TT.id 
INNER JOIN sk8_brand B on TT.fk_brand_id = B.id;

SELECT W.id, W.color, WT.wheel_name, WT.diameter, WT.durometer, B.brand_name, B.brand_img_url FROM sk8_wheel_inv W
  INNER JOIN sk8_wheel_type WT on W.fk_wheel_id=WT.id
  INNER JOIN sk8_brand B on WT.fk_brand_id = B.id;

# show only available parts in inventory
SELECT D.id, D.color, DT.deck_name, DT.length, DT.description, B.brand_name, B.brand_img_url FROM sk8_deck_inv D
INNER JOIN sk8_deck_type DT on D.fk_deck_id = DT.id 
INNER JOIN sk8_brand B on DT.fk_brand_id = B.id
WHERE D.id NOT IN (SELECT fk_deck_id from sk8_skateboards);

SELECT T.id, TT.truck_name, TT.width, B.brand_name, B.brand_img_url FROM sk8_truck_inv T
INNER JOIN sk8_truck_type TT on T.fk_truck_id = TT.id 
INNER JOIN sk8_brand B on TT.fk_brand_id = B.id
WHERE T.id NOT IN (SELECT fk_truck_id from sk8_skateboards);

SELECT W.id, W.color, WT.wheel_name, WT.diameter, WT.durometer, B.brand_name, B.brand_img_url FROM sk8_wheel_inv W
  INNER JOIN sk8_wheel_type WT on W.fk_wheel_id=WT.id
  INNER JOIN sk8_brand B on WT.fk_brand_id = B.id
  WHERE W.id NOT IN (SELECT fk_wheel_id from sk8_skateboards);



-- selection queries

SELECT SK.name, DT.name, TT.name, WT.name from sk8_skateboards SK
inner join sk8_deck_inv DI on SK.fk_deck_id = DI.id
inner join sk8_deck_type DT on DI.fk_deck_id = DT.id
inner join sk8_truck_inv TI on SK.fk_truck_id = TI.id
inner join sk8_truck_type TT on TI.fk_truck_id = TT.id
inner join sk8_wheel_inv WI on SK.fk_wheel_id = WI.id
inner join sk8_wheel_type WT on WI.fk_wheel_id = WT.id;




#$deckStmt = $mysqli->prepare("SELECT T.name,T.,, from sk8_deck_inv I inner join ")
/*$deckStmt = $mysqli->prepare("select name from sk8_skateboards");
$deckStmt->execute();
$deckStmt->bind_result($deckname);
while($deckStmt->fetch()){
  echo "$deckname <br>";
}*/