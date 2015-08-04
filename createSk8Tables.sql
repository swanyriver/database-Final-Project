---------------------------------------
--ensure starting brand new tables ----
---------------------------------------
DROP TABLE IF EXISTS '';



---------------------------------------
-----Create sk8 Tables-----------------
---------------------------------------

CREATE TABLE sk8_riders (
  id INT NOT NULL AUTO_INCREMENT,
  name varchar(255) NOT NULL,
  img_url varchar(255) NOT NULL, DEFAULT 'http://web.engr.oregonstate.edu/~swansonb/dataFinal/profileshadow.jpg',
  PRIMARY KEY (id)
);

CREATE TABLE sk8_brand (
  id INT NOT NULL AUTO_INCREMENT,
  name varchar(255) NOT NULL,
  img_url varchar(255),
  PRIMARY KEY (id)
);

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
  PRIMARY KEY (id),
  FOREIGN KEY (fk_brand_id) REFERENCES sk8_brand (id)
);

CREATE TABLE sk8_deck_type(
  id INT NOT NULL AUTO_INCREMENT,
  name varchar(255) NOT NULL,
  fk_brand_id INT NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (fk_brand_id) REFERENCES sk8_brand (id)
);

---------------------------------------
----Populate Tables--------------------
---------------------------------------