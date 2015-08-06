-- -------------------------------------
-- ensure starting brand new tables ----
-- -------------------------------------
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS sk8_riders;
DROP TABLE IF EXISTS sk8_brand;
DROP TABLE IF EXISTS sk8_wheel_type;
DROP TABLE IF EXISTS sk8_truck_type;
DROP TABLE IF EXISTS sk8_deck_type;
DROP TABLE IF EXISTS sk8_wheel_inv;
DROP TABLE IF EXISTS sk8_truck_inv;
DROP TABLE IF EXISTS sk8_deck_inv;
DROP TABLE IF EXISTS sk8_skateboards;
DROP TABLE IF EXISTS sk8_riders_skateboards;
SET FOREIGN_KEY_CHECKS = 1;


-- -------------------------------------
-- ---Create sk8 Tables-----------------
-- -------------------------------------

-- ---Independent Entities------
CREATE TABLE sk8_riders (
  id INT NOT NULL AUTO_INCREMENT,
  rider_name varchar(255) NOT NULL,
  img_url varchar(255) NOT NULL DEFAULT 'http://web.engr.oregonstate.edu/~swansonb/dataFinal/profileshadow.jpg',
  PRIMARY KEY (id)
)ENGINE=InnoDB;

CREATE TABLE sk8_brand (
  id INT NOT NULL AUTO_INCREMENT,
  brand_name varchar(255) NOT NULL,
  img_url varchar(255),
  PRIMARY KEY (id),
  UNIQUE (brand_name)
)ENGINE=InnoDB;


-- ---Equipment Types--------
CREATE TABLE sk8_wheel_type(
  id INT NOT NULL AUTO_INCREMENT,
  wheel_name varchar(255) NOT NULL,
  fk_brand_id INT NOT NULL,
  diamater INT NOT NULL,
  durometer INT NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (fk_brand_id) REFERENCES sk8_brand (id)
)ENGINE=InnoDB;

CREATE TABLE sk8_truck_type(
  id INT NOT NULL AUTO_INCREMENT,
  truck_name varchar(255) NOT NULL,
  fk_brand_id INT NOT NULL,
  width INT NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (fk_brand_id) REFERENCES sk8_brand (id)
)ENGINE=InnoDB;

CREATE TABLE sk8_deck_type(
  id INT NOT NULL AUTO_INCREMENT,
  deck_name varchar(255) NOT NULL,
  fk_brand_id INT NOT NULL,
  length INT NOT NULL,
  description varchar(511) NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (fk_brand_id) REFERENCES sk8_brand (id)
)ENGINE=InnoDB;

-- ---Equipment Inventory------------------------------
-- ---Each entry/row in tables is a real world item----
CREATE TABLE sk8_wheel_inv(
  id INT NOT NULL AUTO_INCREMENT,
  fk_wheel_id INT NOT NULL,
  color varchar(127),
  PRIMARY KEY (id),
  FOREIGN KEY (fk_wheel_id) REFERENCES sk8_wheel_type (id)
)ENGINE=InnoDB;

CREATE TABLE sk8_truck_inv(
  id INT NOT NULL AUTO_INCREMENT,
  fk_truck_id INT NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (fk_truck_id) REFERENCES sk8_truck_type (id)
)ENGINE=InnoDB;

CREATE TABLE sk8_deck_inv(
  id INT NOT NULL AUTO_INCREMENT,
  fk_deck_id INT NOT NULL,
  color varchar(127),
  PRIMARY KEY (id),
  FOREIGN KEY (fk_deck_id) REFERENCES sk8_deck_type (id)
)ENGINE=InnoDB;

-- -Relational Tables----

-- a skateboard is a relation of having exacly 
--    one deck
--    one pair of trucks
-- &  one set of 4 wheels
--  each inventory item can only be in one skateboard, hence the uniqe constraint
CREATE TABLE  sk8_skateboards(
  id INT NOT NULL AUTO_INCREMENT,
  board_name varchar(255) NOT NULL,
  img_url varchar(255) NOT NULL DEFAULT 'http://web.engr.oregonstate.edu/~swansonb/dataFinal/skateboard_line_art.png',
  fk_deck_id INT NOT NULL,
  fk_truck_id INT NOT NULL,
  fk_wheel_id INT NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (fk_deck_id) REFERENCES sk8_deck_inv(id),
  FOREIGN KEY (fk_truck_id) REFERENCES sk8_truck_inv(id),
  FOREIGN KEY (fk_wheel_id) REFERENCES sk8_wheel_inv(id),
  UNIQUE (fk_deck_id),
  UNIQUE (fk_truck_id),
  UNIQUE (fk_wheel_id),
  UNIQUE (board_name)
)ENGINE=InnoDB;

-- Many-to-Many pairs of riders and skateboards
CREATE TABLE sk8_riders_skateboards(
  fk_rider_id INT NOT NULL,
  fk_skateboard_id INT NOT NULL,
  PRIMARY KEY (fk_rider_id, fk_skateboard_id),
  FOREIGN KEY (fk_rider_id) REFERENCES sk8_riders(id),
  FOREIGN KEY (fk_skateboard_id) REFERENCES sk8_skateboards(id)
)ENGINE=InnoDB;


-- -------------------------------------
-- --Units------------------------------
-- -------------------------------------
#durometer - A
#diamerter - mm
#length    - inches
#width     - inches

-- -------------------------------------
-- --Populate Tables--------------------
-- -------------------------------------

INSERT INTO
    sk8_brand (brand_name, img_url)
VALUES 
    ('Sector 9', 'https://www.edgeboardshop.com/modules/store/attribute_images/609/21520/2720380_med.png'),
    ('Penny', 'http://skin.pennyskateboards.com/frontend/penny/default/assets/img/logo-greydkdisc.png'),
    ('Shark Wheels', 'http://www.sharkwheel.com/wp-content/uploads/2015/05/1-Shark-Wheel-Green-Logo.png'),
    ('Gullwing', 'https://www.edgeboardshop.com/modules/store/attribute_images/609/24574/2647538_med.jpg'),
    ('Cult Classic', NULL);

INSERT INTO
    sk8_riders (rider_name, img_url)
VALUES 
    ('Brandon', 'https://lh3.googleusercontent.com/-zMjLf3TGzf4/AAAAAAAAAAI/AAAAAAAAABE/waQ_QZ7E7Fs/s120-c/photo.jpg'); 

INSERT INTO
    sk8_riders (rider_name)
VALUES
    ('Doris');

INSERT INTO
  sk8_wheel_type (wheel_name,diamater,durometer,fk_brand_id)
VALUES
  ('California Roll',60,78,3),
  ('CC Longboard Wheels',70,80,5),
  ('Penny Wheels', 59,79,2);

INSERT INTO
  sk8_wheel_inv (fk_wheel_id,color)
VALUES
  (1,'Blue'),
  (2,'Blue'),
  (3,'Red'),(3,'Red');

INSERT INTO
  sk8_truck_type (truck_name, width, fk_brand_id)
VALUES
  ('Mission Truck', 9, 4),
  ('Penny Trucks', 4, 2),
  ('Penny Trucks', 3, 2);

INSERT INTO sk8_truck_inv (fk_truck_id) VALUES (1),(2),(3);

INSERT INTO
  sk8_deck_type (deck_name,length, description, fk_brand_id)
VALUES
  ('nickel',27,'Plastic Retro Cruiser', 2),
  ('penny', 22, 'Plastic Retro Mini', 2);

INSERT INTO
  sk8_deck_inv (fk_deck_id, color) 
VALUES 
  (1,'Blue'),
  (2,'Red/Polka Dot');

INSERT INTO
  sk8_skateboards (board_name,fk_deck_id,fk_truck_id,fk_wheel_id)
VALUES
  ('little blue',1,2,1),
  ('widowmaker',2,3,3);

INSERT INTO
  sk8_riders_skateboards(fk_skateboard_id,fk_rider_id)
VALUES
  (1,1);
