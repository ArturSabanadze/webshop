LOAD DATA LOCAL INFILE 'products.csv' 
INTO TABLE products
FIELDS TERMINATED BY ';'
OPTIONALLY ENCLOSED BY '"'
LINES TERMINATED BY '\r\n'
IGNORE 1 LINES
(product_name, image_url, description, price, min_capacity, max_capacity, start_date, end_date, valid_to_start, available_for_reservation);