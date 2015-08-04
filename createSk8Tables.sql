-- -------------------------------------
-- ensure starting brand new tables ----
-- -------------------------------------
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS `sk8_riders`;
DROP TABLE IF EXISTS `sk8_brand`;
DROP TABLE IF EXISTS `sk8_wheel_type`;
DROP TABLE IF EXISTS `sk8_truck_type`;
DROP TABLE IF EXISTS `sk8_deck_type`;
DROP TABLE IF EXISTS `sk8_wheel_inv`;
DROP TABLE IF EXISTS `sk8_truck_inv`;
DROP TABLE IF EXISTS `sk8_deck_inv`;
DROP TABLE IF EXISTS `sk8_skateboards`;
DROP TABLE IF EXISTS `sk8_riders_skateboards`;
SET FOREIGN_KEY_CHECKS = 1;


-- -------------------------------------
-- ---Create sk8 Tables-----------------
-- -------------------------------------

-- ---Independent Entities------
CREATE TABLE sk8_riders (
  id INT NOT NULL AUTO_INCREMENT,
  name varchar(255) NOT NULL,
  img_url varchar(255) NOT NULL DEFAULT 'http://web.engr.oregonstate.edu/~swansonb/dataFinal/profileshadow.jpg',
  PRIMARY KEY (id)
)ENGINE=InnoDB;

CREATE TABLE sk8_brand (
  id INT NOT NULL AUTO_INCREMENT,
  name varchar(255) NOT NULL,
  img_url varchar(255),
  PRIMARY KEY (id),
  UNIQUE (name)
)ENGINE=InnoDB;


-- ---Equipment Types--------
CREATE TABLE sk8_wheel_type(
  id INT NOT NULL AUTO_INCREMENT,
  name varchar(255) NOT NULL,
  fk_brand_id INT NOT NULL,
  diamater INT NOT NULL,
  durometer INT NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (fk_brand_id) REFERENCES sk8_brand (id)
)ENGINE=InnoDB;

CREATE TABLE sk8_truck_type(
  id INT NOT NULL AUTO_INCREMENT,
  name varchar(255) NOT NULL,
  fk_brand_id INT NOT NULL,
  height INT NOT NULL,
  width INT NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (fk_brand_id) REFERENCES sk8_brand (id)
)ENGINE=InnoDB;

CREATE TABLE sk8_deck_type(
  id INT NOT NULL AUTO_INCREMENT,
  name varchar(255) NOT NULL,
  fk_brand_id INT NOT NULL,
  length INT NOT NULL,
  width INT NOT NULL,
  description varchar(511) NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (fk_brand_id) REFERENCES sk8_brand (id)
)ENGINE=InnoDB;

-- ---Equipment Inventory------------------------------
-- ---Each entry/row in tables is a real world item----
CREATE TABLE sk8_wheel_inv(
  id INT NOT NULL AUTO_INCREMENT,
  fk_wheel_id INT NOT NULL,
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
  PRIMARY KEY (id),
  FOREIGN KEY (fk_deck_id) REFERENCES sk8_deck_type (id)
)ENGINE=InnoDB;

-- -Relational Tables----
CREATE TABLE  sk8_skateboards(
  id INT NOT NULL AUTO_INCREMENT,
  img_url varchar(255) NOT NULL DEFAULT 'http://web.engr.oregonstate.edu/~swansonb/dataFinal/skateboard_line_art.png',
  fk_deck_id INT NOT NULL,
  fk_truck_id INT NOT NULL,
  fk_wheel_id INT NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (fk_deck_id) REFERENCES sk8_deck_inv(id),
  FOREIGN KEY (fk_truck_id) REFERENCES sk8_truck_inv(id),
  FOREIGN KEY (fk_wheel_id) REFERENCES sk8_wheel_inv(id)
)ENGINE=InnoDB;

CREATE TABLE sk8_riders_skateboards(
  fk_rider_id INT NOT NULL,
  fk_skateboard_id INT NOT NULL,
  PRIMARY KEY (fk_rider_id, fk_skateboard_id),
  FOREIGN KEY (fk_rider_id) REFERENCES sk8_riders(id),
  FOREIGN KEY (fk_skateboard_id) REFERENCES sk8_skateboards(id)
  -- CONSTRAINT pk_rider_board PRIMARY KEY (fk_rider_id,fk_skateboard_id)
)ENGINE=InnoDB;

-- -------------------------------------
-- --Populate Tables--------------------
-- -------------------------------------

INSERT INTO
    sk8_brand (name, img_url)
VALUES 
    ('Sector 9', 'https://www.edgeboardshop.com/modules/store/attribute_images/609/21520/2720380_med.png'),
    ('Penny', 'http://skin.pennyskateboards.com/frontend/penny/default/assets/img/logo-greydkdisc.png'),
    ('Shark Wheels', 'http://www.sharkwheel.com/wp-content/uploads/2015/05/1-Shark-Wheel-Green-Logo.png'),
    ('Gullwing', 'https://www.edgeboardshop.com/modules/store/attribute_images/609/24574/2647538_med.jpg'),
    ('Cult Classic', NULL);

INSERT INTO
    sk8_riders (name, img_url)
VALUES 
    ('Brandon', 'https://lh3.googleusercontent.com/-zMjLf3TGzf4/AAAAAAAAAAI/AAAAAAAAABE/waQ_QZ7E7Fs/s120-c/photo.jpg'); 

INSERT INTO
    sk8_riders (name)
VALUES
    ('Doris');

INSERT INTO
  sk8_wheel_type (name,diamater,durometer,fk_brand_id)
VALUES
  ('California Roll',60,78,3),
  ('CC Longboard Wheels',70,80,5);

