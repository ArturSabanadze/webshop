LOAD DATA LOCAL INFILE 'products_for_xampp.csv' 
INTO TABLE products
FIELDS TERMINATED BY ';'
OPTIONALLY ENCLOSED BY '"'
LINES TERMINATED BY '\r\n'
IGNORE 1 LINES
(product_name, image_url, description, price, min_capacity, max_capacity, start_date, end_date);