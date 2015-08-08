# get information for each deck in inventory
SELECT D.id, D.color as deckColor, DT.deck_name, DT.length, DT.description, 
B.brand_name as deck_brand_name, B.brand_img_url as deck_brand_img_url, D.fk_deck_id as fkid FROM sk8_deck_inv D
INNER JOIN sk8_deck_type DT on D.fk_deck_id = DT.id 
INNER JOIN sk8_brand B on DT.fk_brand_id = B.id;

SELECT T.id, TT.truck_name, TT.width, 
B.brand_name as truck_brand_name, B.brand_img_url as truck_brand_img_url, T.fk_truck_id as fkid FROM sk8_truck_inv T
INNER JOIN sk8_truck_type TT on T.fk_truck_id = TT.id 
INNER JOIN sk8_brand B on TT.fk_brand_id = B.id;

SELECT W.id, W.color as wheelColor, WT.wheel_name, WT.diameter, WT.durometer, 
B.brand_name as wheel_brand_name, B.brand_img_url as wheel_brand_img_url, W.fk_wheel_id as fkid FROM sk8_wheel_inv W
INNER JOIN sk8_wheel_type WT on W.fk_wheel_id=WT.id
INNER JOIN sk8_brand B on WT.fk_brand_id = B.id;

# show only available parts in inventory
SELECT D.id, D.color as deckColor, DT.deck_name, DT.length, DT.description, 
B.brand_name as deck_brand_name, B.brand_img_url as deck_brand_img_url, D.fk_deck_id as fkid FROM sk8_deck_inv D
INNER JOIN sk8_deck_type DT on D.fk_deck_id = DT.id 
INNER JOIN sk8_brand B on DT.fk_brand_id = B.id
WHERE D.id NOT IN (SELECT fk_deck_id from sk8_skateboards);

SELECT T.id, TT.truck_name, TT.width, 
B.brand_name as truck_brand_name, B.brand_img_url as truck_brand_img_url, T.fk_truck_id as fkid FROM sk8_truck_inv T
INNER JOIN sk8_truck_type TT on T.fk_truck_id = TT.id 
INNER JOIN sk8_brand B on TT.fk_brand_id = B.id
WHERE T.id NOT IN (SELECT fk_truck_id from sk8_skateboards);

SELECT W.id, W.color as wheelColor, WT.wheel_name, WT.diameter, WT.durometer, 
B.brand_name as wheel_brand_name, B.brand_img_url as wheel_brand_img_url, W.fk_wheel_id as fkid FROM sk8_wheel_inv W
INNER JOIN sk8_wheel_type WT on W.fk_wheel_id=WT.id
INNER JOIN sk8_brand B on WT.fk_brand_id = B.id
WHERE W.id NOT IN (SELECT fk_wheel_id from sk8_skateboards);



-- selection queries

#select all parts and details of a skateboard
SELECT  SK.board_name, SK.board_img_url, 
        DT.deck_name, DT.length, DT.description, DI.color as deckColor, 
        TT.truck_name, TT.width,
        WT.wheel_name, WT.diameter, WT.durometer, WI.color as wheelColor 
from sk8_skateboards SK
inner join sk8_deck_inv DI on SK.fk_deck_id = DI.id
inner join sk8_deck_type DT on DI.fk_deck_id = DT.id
inner join sk8_truck_inv TI on SK.fk_truck_id = TI.id
inner join sk8_truck_type TT on TI.fk_truck_id = TT.id
inner join sk8_wheel_inv WI on SK.fk_wheel_id = WI.id
inner join sk8_wheel_type WT on WI.fk_wheel_id = WT.id;

#select all parts,details, and brands of a skateboard
SELECT  SK.ID, SK.board_name, SK.board_img_url, 
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
inner join sk8_deck_type DT on DT.fk_brand_id = B.id) DB on DT.id = DB.id;


-- deletion queries --------

DELETE from sk8_[deck/truck/wheel]_inv WHERE id=[]
-- delete type if there are no more instances
delete from sk8_[deck/truck/wheel]_type where id not in (select fk_[deck/truck/wheel]_id from sk8_[deck/truck/wheel]_inv);
