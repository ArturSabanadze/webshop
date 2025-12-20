USE webshop_pro;

-- Users
INSERT INTO users (username, password_hash, email) VALUES
  ('alice', 'hash1', 'alice@example.com'),
  ('bob',   'hash2', 'bob@example.com'),
  ('carol', 'hash3', 'carol@example.com');

INSERT INTO users_profiles (user_id, name, surname, biography, profile_img_url) VALUES
  (1, 'Alice', 'Anderson', 'Loves online courses', NULL),
  (2, 'Bob', 'Brown', 'Interested in gadgets', NULL),
  (3, 'Carol', 'Clark', 'Enjoys live seminars', NULL);

INSERT INTO users_addresses (user_id, type, zip_code, country, street, street_number, state, province) VALUES
  (1, 'billing', '10552', 'Greece', 'Panepistimiou', '10', 'Attica', 'Attica'),
  (1, 'shipping','10552', 'Greece', 'Panepistimiou', '10', 'Attica', 'Attica'),
  (2, 'billing', '11742', 'Greece', 'Syngrou', '45', 'Attica', 'Attica'),
  (3, 'shipping','15125', 'Greece', 'Kifisias', '100', 'Attica', 'Attica');

-- Categories
INSERT INTO categories (category_name, description) VALUES
  ('Electronics', 'Physical electronic devices'),
  ('E-books', 'Downloadable books'),
  ('Online Courses', 'Self-paced video courses'),
  ('Seminars', 'Live in-person seminars');
  
-- Products
INSERT INTO products (title, description, image_url, price, status, start_selling_date) VALUES
  ('Wireless Mouse', 'Ergonomic wireless mouse', NULL, 25.90, 'active', NOW()),
  ('Learning SQL eBook', 'Introductory SQL book', NULL, 9.99, 'active', NOW()),
  ('PHP for Beginners Course', 'Video course for PHP', NULL, 49.00, 'active', NOW()),
  ('Web Development Seminar Athens', '2-day live seminar', NULL, 199.00, 'active', NOW());

-- Product category mapping
INSERT INTO product_categories (product_id, category_id) VALUES
  (1, 1),
  (2, 2),
  (3, 3),
  (4, 4);

-- Physical product
INSERT INTO physical_products (product_id, stock, weight, pack_size_height, pack_size_width, pack_size_depth, shipping_required) VALUES
  (1, 50, 0.150, 10.0, 6.0, 4.0, 1);

-- Digital product (ebook)
INSERT INTO digital_products (product_id, file_url, license_type) VALUES
  (2, 'https://example.com/downloads/sql_ebook.pdf', 'single-user');

-- Course
INSERT INTO courses (product_id, content_url, content_creator) VALUES
  (3, 'https://example.com/courses/php-beginners', 'John Instructor');

-- Seminar location & live seminar
INSERT INTO seminars_locations (street, street_number, zip_code, state, province, country) VALUES
  ('Academias', '15', '10672', 'Attica', 'Attica', 'Greece');

INSERT INTO live_seminars (product_id, start_date, end_date, location_id, min_participants, max_participants) VALUES
  (4, DATE_ADD(NOW(), INTERVAL 10 DAY), DATE_ADD(NOW(), INTERVAL 11 DAY), 1, 5, 30);

-- Seminar participants
INSERT INTO seminar_participants (seminar_id, user_id) VALUES
  (4, 3);

-- Carts and items
INSERT INTO carts (user_id, currency) VALUES
  (1, 'EUR'),
  (2, 'EUR');

INSERT INTO carts_items (cart_id, product_id, quantity, unit_price, applied_discount) VALUES
  (1, 1, 1, 25.90, 0.00),
  (1, 2, 1, 9.99, 0.00),
  (2, 3, 1, 49.00, 5.00);

-- Wishlist
INSERT INTO wishlist (user_id) VALUES
  (1),
  (2);

INSERT INTO wishlist_items (wishlist_id, product_id) VALUES
  (1, 3),
  (1, 4),
  (2, 2);

-- Orders & items
INSERT INTO orders (user_id, status, total_amount, billing_address_id, billing_address_snapshot,
                    shipping_address_id, shipping_address_snapshot, created_at)
VALUES
  (1, 'confirmed', 35.89,
     1, JSON_OBJECT('street','Panepistimiou','number','10'),
     2, JSON_OBJECT('street','Panepistimiou','number','10'),
     NOW()),
  (2, 'pending', 44.00,
     3, JSON_OBJECT('street','Syngrou','number','45'),
     NULL, NULL,
     NOW());

INSERT INTO order_items (order_id, product_id, quantity, unit_price, status, product_snapshot) VALUES
  (1, 1, 1, 25.90, 'fulfilled',
     JSON_OBJECT('title','Wireless Mouse','price',25.90)),
  (1, 2, 1, 9.99, 'fulfilled',
     JSON_OBJECT('title','Learning SQL eBook','price',9.99)),
  (2, 3, 1, 49.00, 'pending',
     JSON_OBJECT('title','PHP for Beginners Course','price',49.00));

-- Payments & events
INSERT INTO payments (order_id, provider, transaction_id, amount, currency, status, paid_at) VALUES
  (1, 'stripe', 'tr_abc123', 35.89, 'EUR', 'captured', NOW()),
  (2, 'paypal', NULL, 44.00, 'EUR', 'authorized', NULL);

INSERT INTO payment_events (payment_id, type) VALUES
  (1, 'capture'),
  (2, 'authorize');

-- Voucher types and vouchers
INSERT INTO v_types (type_name, description) VALUES
  ('Percentage', 'Percentage discount'),
  ('FixedAmount', 'Fixed amount discount'),
  ('FreeProduct', 'Gives a product for free');

INSERT INTO vouchers (voucher_code, value, product_id, discount_rate) VALUES
  ('WELCOME10', 0.00, NULL, 10.00),
  ('FIXED5',    5.00, NULL, NULL),
  ('FREECOURSE',0.00, 3, NULL);

INSERT INTO vouchers_types (voucher_id, type_id) VALUES
  (1, 1),   -- WELCOME10 is percentage
  (2, 2),   -- FIXED5 is fixed amount
  (3, 3);   -- FREECOURSE is free product

INSERT INTO users_voucher (user_id, voucher_id, purchased_at, expiring_at) VALUES
  (1, 1, NOW(), DATE_ADD(NOW(), INTERVAL 30 DAY)),
  (2, 2, NOW(), DATE_ADD(NOW(), INTERVAL 60 DAY)),
  (3, 3, NOW(), DATE_ADD(NOW(), INTERVAL 90 DAY));
