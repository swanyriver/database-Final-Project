-- -------------------------------------
-- ensure starting brand new tables ----
-- -------------------------------------
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


-- -------------------------------------
-- ---Create sk8 Tables-----------------
-- -------------------------------------

-- ---Independent Entities------
CREATE TABLE sk8_riders (
  id INT NOT NULL AUTO_INCREMENT,
  name varchar(255) NOT NULL,
  img_url varchar(255) NOT NULL DEFAULT 'http://web.engr.oregonstate.edu/~swansonb/dataFinal/profileshadow.jpg',
  PRIMARY KEY (id)
);

CREATE TABLE sk8_brand (
  id INT NOT NULL AUTO_INCREMENT,
  name varchar(255) NOT NULL,
  img_url varchar(255),
  PRIMARY KEY (id)
);


-- ---Equipment Types--------
CREATE TABLE sk8_wheel_type(
  id INT NOT NULL AUTO_INCREMENT,
  name varchar(255) NOT NULL,
  fk_brand_id INT NOT NULL,
  diamater INT NOT NULL,
  durometer INT NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (fk_brand_id) REFERENCES sk8_brand (id)
);

CREATE TABLE sk8_truck_type(
  id INT NOT NULL AUTO_INCREMENT,
  name varchar(255) NOT NULL,
  fk_brand_id INT NOT NULL,
  height INT NOT NULL,
  width INT NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (fk_brand_id) REFERENCES sk8_brand (id)
);

CREATE TABLE sk8_deck_type(
  id INT NOT NULL AUTO_INCREMENT,
  name varchar(255) NOT NULL,
  fk_brand_id INT NOT NULL,
  length INT NOT NULL,
  width INT NOT NULL,
  description varchar(511) NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (fk_brand_id) REFERENCES sk8_brand (id)
);

-- ---Equipment Inventory------------------------------
-- ---Each entry/row in tables is a real world item----
CREATE TABLE sk8_wheel_inv(
  id INT NOT NULL AUTO_INCREMENT,
  fk_wheel_id INT NOT NULL,
  broken boolean DEFAULT FALSE,
  PRIMARY KEY (id),
  FOREIGN KEY (fk_wheel_id) REFERENCES sk8_wheel_type (id)
);

CREATE TABLE sk8_truck_inv(
  id INT NOT NULL AUTO_INCREMENT,
  fk_truck_id INT NOT NULL,
  broken boolean DEFAULT FALSE,
  PRIMARY KEY (id),
  FOREIGN KEY (fk_truck_id) REFERENCES sk8_truck_type (id)
);

CREATE TABLE sk8_deck_inv(
  id INT NOT NULL AUTO_INCREMENT,
  fk_deck_id INT NOT NULL,
  broken boolean DEFAULT FALSE,
  PRIMARY KEY (id),
  FOREIGN KEY (fk_deck_id) REFERENCES sk8_deck_type (id)
);

-- -Relational Tables----
CREATE TABLE  sk8_skateboards(
  id INT NOT NULL AUTO_INCREMENT,
  assembled DATE NOT NULL,
  dissasembled DATE DEFAULT NULL,
  fk_deck_id INT NOT NULL,
  fk_truck_id INT NOT NULL,
  fk_wheel_id INT NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (fk_deck_id) REFERENCES sk8_deck_inv(id),
  FOREIGN KEY (fk_truck_id) REFERENCES sk8_truck_inv(id),
  FOREIGN KEY (fk_wheel_id) REFERENCES sk8_wheel_inv(id),
);

CREATE TABLE sk8_riders_skateboards(
  fk_rider_id INT NOT NULL,
  fk_skateboard_id INT NOT NULL,
  FOREIGN KEY (fk_rider_id) REFERENCES sk8_riders(id),
  FOREIGN KEY (fk_skateboard_id) REFERENCES sk8_skateboards(id),
  CONSTRAINT pk_rider_board PRIMARY KEY (fk_rider_id,fk_skateboard_id)
);
-- -------------------------------------
-- --Populate Tables--------------------
-- -------------------------------------