--  -----------------------------------------------------------------------------------------------------------------
--  --------------------------------GENERAL USE QUERIES--------------------------------------------------------------
--  -----------------------------------------------------------------------------------------------------------------

-- -----------------------------
-- ---------SELECT QUERIES -----
-- -----------------------------
--  get information for each part in inventory
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

--  show only available parts in inventory
SELECT D.id, D.color as deckColor, DT.deck_name, DT.length, DT.description, 
B.brand_name as deck_brand_name, B.brand_img_url as deck_brand_img_url, D.fk_deck_id as fkid FROM sk8_deck_inv D
INNER JOIN sk8_deck_type DT on D.fk_deck_id = DT.id 
INNER JOIN sk8_brand B on DT.fk_brand_id = B.id
WHERE D.id NOT IN (SELECT fk_deck_id FROM sk8_skateboards);

SELECT T.id, TT.truck_name, TT.width, 
B.brand_name as truck_brand_name, B.brand_img_url as truck_brand_img_url, T.fk_truck_id as fkid FROM sk8_truck_inv T
INNER JOIN sk8_truck_type TT on T.fk_truck_id = TT.id 
INNER JOIN sk8_brand B on TT.fk_brand_id = B.id
WHERE T.id NOT IN (SELECT fk_truck_id FROM sk8_skateboards);

SELECT W.id, W.color as wheelColor, WT.wheel_name, WT.diameter, WT.durometer, 
B.brand_name as wheel_brand_name, B.brand_img_url as wheel_brand_img_url, W.fk_wheel_id as fkid FROM sk8_wheel_inv W
INNER JOIN sk8_wheel_type WT on W.fk_wheel_id=WT.id
INNER JOIN sk8_brand B on WT.fk_brand_id = B.id
WHERE W.id NOT IN (SELECT fk_wheel_id FROM sk8_skateboards);

--get riders for display
SELECT id, rider_name, rider_img_url FROM sk8_riders

-- select all parts,details, and brands of a skateboard
SELECT SK.id, SK.board_name, SK.board_img_url, 
        DT.deck_name, DT.length, DT.description, DI.color as deckColor, 
        DB.deck_brand_name, DB.deck_brand_img_url,
        TT.truck_name, TT.width, TB.truck_brand_name, TB.truck_brand_img_url,
        WT.wheel_name, WT.diameter, WT.durometer, WI.color as wheelColor,
        WB.wheel_brand_name, WB.wheel_brand_img_url
FROM sk8_skateboards SK
INNER JOIN sk8_deck_inv DI on SK.fk_deck_id = DI.id
INNER JOIN sk8_deck_type DT on DI.fk_deck_id = DT.id
INNER JOIN sk8_truck_inv TI on SK.fk_truck_id = TI.id
INNER JOIN sk8_truck_type TT on TI.fk_truck_id = TT.id
INNER JOIN sk8_wheel_inv WI on SK.fk_wheel_id = WI.id
INNER JOIN sk8_wheel_type WT on WI.fk_wheel_id = WT.id
INNER JOIN (SELECT WT.id, B.brand_name as wheel_brand_name, B.brand_img_url as wheel_brand_img_url FROM sk8_brand B
INNER JOIN sk8_wheel_type WT on WT.fk_brand_id = B.id) WB on WT.id = WB.id
INNER JOIN (SELECT TT.id, B.brand_name as truck_brand_name, B.brand_img_url as truck_brand_img_url FROM sk8_brand B
INNER JOIN sk8_truck_type TT on TT.fk_brand_id = B.id) TB on TT.id = TB.id
INNER JOIN (SELECT DT.id, B.brand_name as deck_brand_name, B.brand_img_url as deck_brand_img_url FROM sk8_brand B
INNER JOIN sk8_deck_type DT on DT.fk_brand_id = B.id) DB on DT.id = DB.id;

-- link together skateboarders and riders
SELECT fk_skateboard_id, fk_rider_id, B.board_name FROM sk8_riders_skateboards
INNER JOIN sk8_skateboards B ON B.id = fk_skateboard_id;

SELECT fk_skateboard_id, fk_rider_id, R.rider_name FROM sk8_riders_skateboards 
INNER JOIN sk8_riders R on R.id = fk_rider_id;

-- create dropdown menues for all possible riders for all skateboards
--  using a left outer join on with the riders/skateboard many-to-many table
--  and a cross-product table of all riders and skateboarders
SELECT POSSIBLES.skid, POSSIBLES.board_name, POSSIBLES.rid, POSSIBLES.rider_name
FROM (SELECT B.id as skid, B.board_name, R.id as rid, R.rider_name
FROM sk8_skateboards B INNER JOIN sk8_riders R) POSSIBLES
LEFT OUTER JOIN sk8_riders_skateboards RS
ON RS.fk_rider_id = POSSIBLES.rid AND RS.fk_skateboard_id = POSSIBLES.skid
WHERE RS.fk_rider_id IS null;

-- for making a drop down menu of brands
SELECT id,brand_name FROM sk8_brand;

-- -----------------------------
-- ---------DELETE QUERIES -----
-- -----------------------------

DELETE FROM sk8_riders_skateboards WHERE fk_skateboard_id = [] AND fk_rider_id = [];
DELETE FROM sk8_skateboards WHERE id=[];
DELETE FROM sk8_riders WHERE id=[];

-- deleting an item FROM inventory
DELETE FROM sk8_[deck/truck/wheel]_inv WHERE id=[];
-- delete type if there are no more instances
DELETE FROM sk8_[deck/truck/wheel]_type WHERE id NOT IN (SELECT fk_[deck/truck/wheel]_id FROM sk8_[deck/truck/wheel]_inv);
--inform user of board that part is being used in (violating FK constraint)
SELECT id,board_name FROM sk8_skateboards WHERE fk_[deck/truck/wheel]_id=[];

-- -----------------------------
-- ---------INSERT QUERIES -----
-- -----------------------------

-- create a new skateboard and rider relationship ---
INSERT INTO sk8_riders_skateboards(fk_skateboard_id,fk_rider_id) VALUES ([],[]);

-- add a new brand ----
INSERT INTO sk8_brand (brand_name, brand_img_url) VALUES ([],[]);

-- add new inventory,  if it is a duplicate item then it will refrence a type and specify color
-- if the item is a brand new type then they type will be created first 
--   and then the [last id] in the type table used for the foriegn key
INSERT INTO sk8_deck_inv (fk_deck_id, color) VALUES([],[]);
INSERT INTO sk8_deck_type (deck_name,length, description, fk_brand_id) VALUES([],[],[],[]);
INSERT INTO sk8_deck_inv (fk_deck_id, color) VALUES($mysqli->insert_id,[]);

INSERT INTO sk8_truck_inv (fk_truck_id) VALUES([]);
INSERT INTO sk8_truck_type (truck_name, width, fk_brand_id) VALUES([],[],[]);
INSERT INTO sk8_truck_inv (fk_truck_id) VALUES($mysqli->insert_id);

INSERT INTO sk8_wheel_inv (fk_wheel_id, color) VALUES([],[]);
INSERT INTO sk8_wheel_type (wheel_name,diameter, durometer, fk_brand_id) VALUES([],[],[],[]);
INSERT INTO sk8_wheel_inv (fk_wheel_id, color) VALUES($mysqli->insert_id,[]);

-- when creating rider or skateboard image inserted as an UPDATE
-- this is in order to check for empty string
INSERT INTO sk8_riders (rider_name) VALUES ([]);
UPDATE sk8_riders SET rider_img_url=[]  WHERE id=[];

-- -----------------------------
-- ---------UPDATE QUERIES -----
-- -----------------------------

UPDATE sk8_skateboards SET board_img_url = DEFAULT WHERE id = [];
UPDATE sk8_skateboards SET board_img_url = [] WHERE id=[];
UPDATE sk8_riders SET rider_img_url = DEFAULT WHERE id = [];
UPDATE sk8_riders SET rider_img_url = [] WHERE id=[];

-- ----------------------------------------------------------------------------------------
-- ----Queries involved in building a board, a relationship of having 1: deck,truck,wheel -
-- ----------------------------------------------------------------------------------------

-- create board relationship 
INSERT INTO sk8_skateboards (board_name,fk_deck_id,fk_truck_id,fk_wheel_id) VALUES([],[],[],[])
-- check for uniqe constraint error 1062, each real work inventory item can only be used on one board at a time
-- if parts are in use, get IDs and Names of those boards to present to user
SELECT DISTINCT B.id, B.board_name FROM sk8_skateboards B 
WHERE fk_deck_id = [] OR fk_truck_id = [] OR fk_wheel_id = [];

-- if user decides to scrap those boards and assemble the new one
-- get boards that have those parts
SELECT DISTINCT B.id FROM sk8_skateboards B 
WHERE fk_deck_id = [] OR fk_truck_id = [] OR fk_wheel_id = [];
-- delete (dissasemble) those boards
DELETE FROM sk8_skateboards WHERE id=[];

-- if img_url is not empty string
UPDATE sk8_skateboards SET board_img_url=[]  WHERE id=$mysqli->insert_id;