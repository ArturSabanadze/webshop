USE gruppe1;

-- ========================================
-- USERS (12 Benutzer)
-- ========================================
INSERT INTO users (username, password_hash, email, role) VALUES
  ('alice', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcg7b3XeKeUxWdeS86E36DusJea', 'alice@example.com', 'user'),
  ('bob', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcg7b3XeKeUxWdeS86E36DusJea', 'bob@example.com', 'user'),
  ('carol', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcg7b3XeKeUxWdeS86E36DusJea', 'carol@example.com', 'user'),
  ('david', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcg7b3XeKeUxWdeS86E36DusJea', 'david@example.com', 'user'),
  ('emma', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcg7b3XeKeUxWdeS86E36DusJea', 'emma@example.com', 'user'),
  ('frank', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcg7b3XeKeUxWdeS86E36DusJea', 'frank@example.com', 'user'),
  ('grace', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcg7b3XeKeUxWdeS86E36DusJea', 'grace@example.com', 'user'),
  ('henry', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcg7b3XeKeUxWdeS86E36DusJea', 'henry@example.com', 'user'),
  ('iris', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcg7b3XeKeUxWdeS86E36DusJea', 'iris@example.com', 'user'),
  ('jack', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcg7b3XeKeUxWdeS86E36DusJea', 'jack@example.com', 'user'),
  ('kate', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcg7b3XeKeUxWdeS86E36DusJea', 'kate@example.com', 'user'),
  ('liam', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcg7b3XeKeUxWdeS86E36DusJea', 'liam@example.com', 'user');


-- ========================================
-- USER PROFILES (12 Profile)
-- ========================================
INSERT INTO users_profiles (user_id, name, surname, gender, birthdate, phone, biography, profile_img_url) VALUES
  (1, 'Alice', 'Anderson', 'Female', '1990-05-15', '+30-210-1234567', 'Loves online courses and web development', NULL),
  (2, 'Bob', 'Brown', 'Male', '1988-08-22', '+30-210-2345678', 'Interested in gadgets and electronics', NULL),
  (3, 'Carol', 'Clark', 'Female', '1992-03-10', '+30-210-3456789', 'Enjoys live seminars and networking', NULL),
  (4, 'David', 'Davis', 'Male', '1985-11-30', '+30-210-4567890', 'Professional web developer', NULL),
  (5, 'Emma', 'Evans', 'Female', '1995-07-18', '+30-210-5678901', 'Admin user managing the shop', NULL),
  (6, 'Frank', 'Foster', 'Male', '1987-02-14', '+30-210-6789012', 'Passionate about technology', NULL),
  (7, 'Grace', 'Green', 'Female', '1991-09-25', '+30-210-7890123', 'Digital content enthusiast', NULL),
  (8, 'Henry', 'Harris', 'Male', '1989-01-08', '+30-210-8901234', 'Always learning new skills', NULL),
  (9, 'Iris', 'Iverson', 'Female', '1993-06-12', '+30-210-9012345', 'E-book collector and reader', NULL),
  (10, 'Jack', 'Johnson', 'Male', '1986-04-20', '+30-211-0123456', 'Tech blogger and reviewer', NULL),
  (11, 'Kate', 'Kelly', 'Female', '1994-10-05', '+30-211-1234567', 'Online course enthusiast', NULL),
  (12, 'Liam', 'Lewis', 'Male', '1997-12-17', '+30-211-2345678', 'Student and part-time learner', NULL);


-- ========================================
-- USER ADDRESSES (12+ Adressen)
-- ========================================
INSERT INTO users_addresses (user_id, type, street, street_number, zip_code, state, province, country) VALUES
  (1, 'billing', 'Panepistimiou', '10', '10672', 'Attica', 'Attica', 'Greece'),
  (1, 'shipping', 'Panepistimiou', '10', '10672', 'Attica', 'Attica', 'Greece'),
  (2, 'billing', 'Syngrou', '45', '11742', 'Attica', 'Attica', 'Greece'),
  (2, 'shipping', 'Tritis Septemvriou', '22', '17671', 'Attica', 'Attica', 'Greece'),
  (3, 'billing', 'Kifisias', '100', '15125', 'Attica', 'Attica', 'Greece'),
  (3, 'shipping', 'Kifisias', '100', '15125', 'Attica', 'Attica', 'Greece'),
  (4, 'billing', 'Vasilissis Sofias', '54', '10676', 'Attica', 'Attica', 'Greece'),
  (4, 'shipping', 'Vasilissis Sofias', '54', '10676', 'Attica', 'Attica', 'Greece'),
  (5, 'billing', 'Ermou', '30', '10563', 'Attica', 'Attica', 'Greece'),
  (5, 'shipping', 'Ermou', '30', '10563', 'Attica', 'Attica', 'Greece'),
  (6, 'billing', 'Stadiou', '5', '10564', 'Attica', 'Attica', 'Greece'),
  (6, 'shipping', 'Akademias', '15', '10672', 'Attica', 'Attica', 'Greece'),
  (7, 'billing', 'Odou Voulis', '8', '10559', 'Attica', 'Attica', 'Greece'),
  (7, 'shipping', 'Odou Voulis', '8', '10559', 'Attica', 'Attica', 'Greece'),
  (8, 'billing', 'Leoforos Vassileos Konstantinou', '1', '11527', 'Attica', 'Attica', 'Greece'),
  (8, 'shipping', 'Leoforos Vassileos Konstantinou', '1', '11527', 'Attica', 'Attica', 'Greece'),
  (9, 'billing', 'Patission', '120', '10434', 'Attica', 'Attica', 'Greece'),
  (9, 'shipping', 'Patission', '120', '10434', 'Attica', 'Attica', 'Greece'),
  (10, 'billing', 'Aiolou', '45', '10557', 'Attica', 'Attica', 'Greece'),
  (10, 'shipping', 'Aiolou', '45', '10557', 'Attica', 'Attica', 'Greece'),
  (11, 'billing', 'Mitropoleos', '2', '10556', 'Attica', 'Attica', 'Greece'),
  (11, 'shipping', 'Mitropoleos', '2', '10556', 'Attica', 'Attica', 'Greece'),
  (12, 'billing', 'Athinas', '80', '10552', 'Attica', 'Attica', 'Greece'),
  (12, 'shipping', 'Athinas', '80', '10552', 'Attica', 'Attica', 'Greece');


-- ========================================
-- CATEGORIES (12 Kategorien)
-- ========================================
INSERT INTO categories (category_name, description) VALUES
  ('Electronics', 'Physical electronic devices and gadgets'),
  ('E-books', 'Downloadable digital books and publications'),
  ('Online Courses', 'Self-paced video and interactive courses'),
  ('Live Seminars', 'In-person live educational events'),
  ('Software Tools', 'Digital tools and software licenses'),
  ('Mobile Apps', 'Mobile applications and digital services'),
  ('Photography', 'Photography courses and digital content'),
  ('Business Training', 'Professional and business development courses'),
  ('Language Learning', 'Language courses and learning materials'),
  ('Design & Graphics', 'Design courses and graphic resources'),
  ('Health & Wellness', 'Health, fitness and wellness courses'),
  ('Creative Arts', 'Art and creative skills development');


-- ========================================
-- PRODUCTS (12 Produkte - gemischte Typen)
-- ========================================
INSERT INTO products (title, description, image_url, price, status, start_selling_date) VALUES
  ('Wireless Mouse Pro', 'Ergonomic wireless mouse with precision tracking', 'https://example.com/mouse.jpg', 25.90, 'active', NOW()),
  ('USB-C Hub 7-in-1', 'Multi-port USB-C hub for laptops', 'https://example.com/hub.jpg', 45.50, 'active', NOW()),
  ('Mechanical Keyboard RGB', 'Gaming keyboard with RGB lighting', 'https://example.com/keyboard.jpg', 89.99, 'active', NOW()),
  ('Learning SQL eBook', 'Introductory SQL book for beginners', 'https://example.com/sql_ebook.jpg', 9.99, 'active', NOW()),
  ('Advanced Python eBook', 'Deep dive into Python programming', 'https://example.com/python_ebook.jpg', 14.99, 'active', NOW()),
  ('Web Design eBook Collection', 'Complete guide to modern web design', 'https://example.com/webdesign_ebook.jpg', 19.99, 'active', NOW()),
  ('PHP for Beginners Course', 'Video course for PHP basics', 'https://example.com/php_course.jpg', 49.00, 'active', NOW()),
  ('JavaScript Mastery Course', 'Complete JavaScript video course', 'https://example.com/js_course.jpg', 69.00, 'active', NOW()),
  ('React.js Advanced Course', 'Advanced React development techniques', 'https://example.com/react_course.jpg', 79.00, 'active', NOW()),
  ('Web Development Seminar Athens', '2-day live seminar in Athens', 'https://example.com/seminar_athens.jpg', 199.00, 'active', NOW()),
  ('Web Development Seminar Thessaloniki', '2-day live seminar in Thessaloniki', 'https://example.com/seminar_thessaloniki.jpg', 199.00, 'active', NOW()),
  ('UX/UI Design Bootcamp', 'Intensive 1-week live bootcamp', 'https://example.com/bootcamp_ux.jpg', 299.00, 'active', NOW());


-- ========================================
-- PRODUCT CATEGORIES (12 Zuordnungen)
-- ========================================
INSERT INTO product_categories (product_id, category_id) VALUES
  (1, 1),   -- Wireless Mouse Pro -> Electronics
  (2, 1),   -- USB-C Hub -> Electronics
  (3, 1),   -- Mechanical Keyboard -> Electronics
  (4, 2),   -- Learning SQL eBook -> E-books
  (5, 2),   -- Advanced Python eBook -> E-books
  (6, 2),   -- Web Design eBook -> E-books
  (7, 3),   -- PHP for Beginners -> Online Courses
  (8, 3),   -- JavaScript Mastery -> Online Courses
  (9, 3),   -- React.js Advanced -> Online Courses
  (10, 4),  -- Web Dev Seminar Athens -> Live Seminars
  (11, 4),  -- Web Dev Seminar Thessaloniki -> Live Seminars
  (12, 4);  -- UX/UI Bootcamp -> Live Seminars


-- ========================================
-- PHYSICAL PRODUCTS (3 Stück)
-- ========================================
INSERT INTO physical_products (product_id, stock, weight, pack_size_height, pack_size_width, pack_size_depth, shipping_required) VALUES
  (1, 50, 0.150, 10.0, 6.0, 4.0, 1),
  (2, 35, 0.280, 15.0, 10.0, 5.0, 1),
  (3, 25, 0.850, 45.0, 12.0, 5.0, 1);


-- ========================================
-- DIGITAL PRODUCTS (3 eBooks)
-- ========================================
INSERT INTO digital_products (product_id, file_url, license_type) VALUES
  (4, 'https://example.com/downloads/sql_ebook.pdf', 'single-user'),
  (5, 'https://example.com/downloads/python_ebook.pdf', 'single-user'),
  (6, 'https://example.com/downloads/webdesign_ebook.pdf', 'multi-user');


-- ========================================
-- COURSES (3 Online Courses)
-- ========================================
INSERT INTO courses (product_id, content_url, content_creator) VALUES
  (7, 'https://example.com/courses/php-beginners', 'John Instructor'),
  (8, 'https://example.com/courses/javascript-mastery', 'Sarah Johnson'),
  (9, 'https://example.com/courses/react-advanced', 'Mike Chen');


-- ========================================
-- SEMINAR LOCATIONS (4 Standorte)
-- ========================================
INSERT INTO seminars_locations (street, street_number, zip_code, state, province, country) VALUES
  ('Academias', '15', '10672', 'Attica', 'Attica', 'Greece'),
  ('Stadiou', '5', '10564', 'Attica', 'Attica', 'Greece'),
  ('Mitropoleos', '2', '10556', 'Attica', 'Attica', 'Greece'),
  ('Ermou', '30', '10563', 'Attica', 'Attica', 'Greece');


-- ========================================
-- LIVE SEMINARS (12 Seminare - 2 Termine pro Ort)
-- ========================================
INSERT INTO live_seminars (product_id, start_date, end_date, location_id, min_participants, max_participants) VALUES
  (10, DATE_ADD(NOW(), INTERVAL 10 DAY), DATE_ADD(NOW(), INTERVAL 11 DAY), 1, 5, 30),
  (10, DATE_ADD(NOW(), INTERVAL 45 DAY), DATE_ADD(NOW(), INTERVAL 46 DAY), 1, 5, 30),
  (11, DATE_ADD(NOW(), INTERVAL 15 DAY), DATE_ADD(NOW(), INTERVAL 16 DAY), 2, 5, 25),
  (11, DATE_ADD(NOW(), INTERVAL 50 DAY), DATE_ADD(NOW(), INTERVAL 51 DAY), 2, 5, 25),
  (10, DATE_ADD(NOW(), INTERVAL 20 DAY), DATE_ADD(NOW(), INTERVAL 21 DAY), 3, 5, 28),
  (10, DATE_ADD(NOW(), INTERVAL 55 DAY), DATE_ADD(NOW(), INTERVAL 56 DAY), 3, 5, 28),
  (11, DATE_ADD(NOW(), INTERVAL 25 DAY), DATE_ADD(NOW(), INTERVAL 26 DAY), 4, 5, 32),
  (11, DATE_ADD(NOW(), INTERVAL 60 DAY), DATE_ADD(NOW(), INTERVAL 61 DAY), 4, 5, 32),
  (12, DATE_ADD(NOW(), INTERVAL 30 DAY), DATE_ADD(NOW(), INTERVAL 36 DAY), 1, 8, 40),
  (12, DATE_ADD(NOW(), INTERVAL 70 DAY), DATE_ADD(NOW(), INTERVAL 76 DAY), 2, 8, 40),
  (12, DATE_ADD(NOW(), INTERVAL 35 DAY), DATE_ADD(NOW(), INTERVAL 41 DAY), 3, 8, 35),
  (12, DATE_ADD(NOW(), INTERVAL 75 DAY), DATE_ADD(NOW(), INTERVAL 81 DAY), 4, 8, 35);


-- ========================================
-- SEMINAR PARTICIPANTS (12 Teilnahmen)
-- ========================================
INSERT INTO seminar_participants (seminar_id, user_id) VALUES
  (1, 1), (1, 3), (1, 5),
  (2, 2), (2, 4), (2, 6),
  (3, 7), (3, 8), (3, 9),
  (4, 10), (4, 11), (4, 12),
  (5, 1), (5, 2), (5, 3),
  (6, 4), (6, 5), (6, 6),
  (7, 7), (7, 8), (7, 9),
  (8, 10), (8, 11), (8, 12),
  (9, 1), (9, 2), (9, 3), (9, 4),
  (10, 5), (10, 6), (10, 7), (10, 8),
  (11, 9), (11, 10), (11, 11), (11, 12),
  (12, 1), (12, 3), (12, 5), (12, 7);


-- ========================================
-- CARTS (12 Warenkörbe)
-- ========================================
INSERT INTO carts (user_id, currency, created_at) VALUES
  (1, 'EUR', NOW()),
  (2, 'EUR', DATE_SUB(NOW(), INTERVAL 1 DAY)),
  (3, 'EUR', DATE_SUB(NOW(), INTERVAL 2 DAY)),
  (4, 'EUR', NOW()),
  (5, 'EUR', DATE_SUB(NOW(), INTERVAL 3 HOUR)),
  (6, 'EUR', NOW()),
  (7, 'EUR', DATE_SUB(NOW(), INTERVAL 1 DAY)),
  (8, 'EUR', NOW()),
  (9, 'EUR', DATE_SUB(NOW(), INTERVAL 4 DAY)),
  (10, 'EUR', NOW()),
  (11, 'EUR', DATE_SUB(NOW(), INTERVAL 1 DAY)),
  (12, 'EUR', NOW());


-- ========================================
-- CART ITEMS (12+ Warenkörbe mit Produkten)
-- ========================================
INSERT INTO carts_items (cart_id, product_id, quantity, unit_price, applied_discount) VALUES
  (1, 1, 1, 25.90, 0.00),
  (1, 2, 1, 45.50, 5.00),
  (2, 3, 1, 89.99, 0.00),
  (2, 4, 2, 9.99, 0.00),
  (3, 5, 1, 14.99, 3.00),
  (3, 7, 1, 49.00, 0.00),
  (4, 6, 1, 19.99, 0.00),
  (4, 8, 1, 69.00, 10.00),
  (5, 9, 1, 79.00, 0.00),
  (6, 1, 2, 25.90, 0.00),
  (6, 3, 1, 89.99, 15.00),
  (7, 2, 1, 45.50, 0.00),
  (7, 5, 1, 14.99, 0.00),
  (8, 4, 3, 9.99, 0.00),
  (8, 6, 1, 19.99, 0.00),
  (9, 7, 1, 49.00, 0.00),
  (10, 8, 1, 69.00, 0.00),
  (10, 9, 1, 79.00, 0.00),
  (11, 1, 1, 25.90, 0.00),
  (11, 2, 1, 45.50, 0.00),
  (12, 3, 1, 89.99, 0.00),
  (12, 4, 1, 9.99, 2.00);


-- ========================================
-- WISHLISTS (12 Merklisten)
-- ========================================
INSERT INTO wishlist (user_id, created_at) VALUES
  (1, NOW()),
  (2, DATE_SUB(NOW(), INTERVAL 1 DAY)),
  (3, NOW()),
  (4, DATE_SUB(NOW(), INTERVAL 2 DAY)),
  (5, NOW()),
  (6, DATE_SUB(NOW(), INTERVAL 1 DAY)),
  (7, NOW()),
  (8, DATE_SUB(NOW(), INTERVAL 3 DAY)),
  (9, NOW()),
  (10, DATE_SUB(NOW(), INTERVAL 1 DAY)),
  (11, NOW()),
  (12, DATE_SUB(NOW(), INTERVAL 2 DAY));


-- ========================================
-- WISHLIST ITEMS (12+ Einträge)
-- ========================================
INSERT INTO wishlist_items (wishlist_id, product_id) VALUES
  (1, 3), (1, 4), (1, 7),
  (2, 2), (2, 5), (2, 8),
  (3, 1), (3, 6), (3, 9),
  (4, 3), (4, 4), (4, 10),
  (5, 2), (5, 7), (5, 11),
  (6, 1), (6, 8), (6, 12),
  (7, 5), (7, 9), (7, 3),
  (8, 4), (8, 6), (8, 2),
  (9, 7), (9, 1), (9, 10),
  (10, 8), (10, 11), (10, 5),
  (11, 9), (11, 12), (11, 4),
  (12, 3), (12, 2), (12, 6);


-- ========================================
-- ORDERS (12 Bestellungen)
-- ========================================
INSERT INTO orders (user_id, status, total_amount, billing_address_id, billing_address_snapshot,
                    shipping_address_id, shipping_address_snapshot, created_at)
VALUES
  (1, 'confirmed', 71.40, 1, JSON_OBJECT('street','Panepistimiou','number','10'), 2, JSON_OBJECT('street','Panepistimiou','number','10'), NOW()),
  (2, 'pending', 89.99, 3, JSON_OBJECT('street','Syngrou','number','45'), 4, JSON_OBJECT('street','Tritis Septemvriou','number','22'), DATE_SUB(NOW(), INTERVAL 1 DAY)),
  (3, 'shipped', 63.99, 5, JSON_OBJECT('street','Kifisias','number','100'), 6, JSON_OBJECT('street','Kifisias','number','100'), DATE_SUB(NOW(), INTERVAL 2 DAY)),
  (4, 'confirmed', 88.99, 7, JSON_OBJECT('street','Vasilissis Sofias','number','54'), 8, JSON_OBJECT('street','Vasilissis Sofias','number','54'), DATE_SUB(NOW(), INTERVAL 3 DAY)),
  (5, 'completed', 49.00, 9, JSON_OBJECT('street','Ermou','number','30'), 10, JSON_OBJECT('street','Ermou','number','30'), DATE_SUB(NOW(), INTERVAL 4 DAY)),
  (6, 'pending', 194.98, 11, JSON_OBJECT('street','Stadiou','number','5'), 12, JSON_OBJECT('street','Akademias','number','15'), DATE_SUB(NOW(), INTERVAL 5 DAY)),
  (7, 'confirmed', 39.98, 13, JSON_OBJECT('street','Odou Voulis','number','8'), 14, JSON_OBJECT('street','Odou Voulis','number','8'), DATE_SUB(NOW(), INTERVAL 6 DAY)),
  (8, 'shipped', 109.99, 15, JSON_OBJECT('street','Leoforos Vassileos Konstantinou','number','1'), 16, JSON_OBJECT('street','Leoforos Vassileos Konstantinou','number','1'), DATE_SUB(NOW(), INTERVAL 7 DAY)),
  (9, 'completed', 49.00, 17, JSON_OBJECT('street','Patission','number','120'), 18, JSON_OBJECT('street','Patission','number','120'), DATE_SUB(NOW(), INTERVAL 8 DAY)),
  (10, 'confirmed', 179.98, 19, JSON_OBJECT('street','Aiolou','number','45'), 20, JSON_OBJECT('street','Aiolou','number','45'), DATE_SUB(NOW(), INTERVAL 9 DAY)),
  (11, 'pending', 59.98, 21, JSON_OBJECT('street','Mitropoleos','number','2'), 22, JSON_OBJECT('street','Mitropoleos','number','2'), DATE_SUB(NOW(), INTERVAL 10 DAY)),
  (12, 'shipped', 99.98, 23, JSON_OBJECT('street','Athinas','number','80'), 24, JSON_OBJECT('street','Athinas','number','80'), DATE_SUB(NOW(), INTERVAL 11 DAY));


-- ========================================
-- ORDER ITEMS (12+ Bestellpositionen)
-- ========================================
INSERT INTO order_items (order_id, product_id, quantity, unit_price, status, product_snapshot) VALUES
  (1, 1, 1, 25.90, 'fulfilled', JSON_OBJECT('title','Wireless Mouse Pro','price',25.90)),
  (1, 2, 1, 45.50, 'fulfilled', JSON_OBJECT('title','USB-C Hub 7-in-1','price',45.50)),
  (2, 3, 1, 89.99, 'pending', JSON_OBJECT('title','Mechanical Keyboard RGB','price',89.99)),
  (3, 4, 2, 9.99, 'fulfilled', JSON_OBJECT('title','Learning SQL eBook','price',9.99)),
  (3, 7, 1, 49.00, 'fulfilled', JSON_OBJECT('title','PHP for Beginners Course','price',49.00)),
  (4, 5, 1, 14.99, 'fulfilled', JSON_OBJECT('title','Advanced Python eBook','price',14.99)),
  (4, 8, 1, 69.00, 'pending', JSON_OBJECT('title','JavaScript Mastery Course','price',69.00)),
  (5, 6, 1, 19.99, 'fulfilled', JSON_OBJECT('title','Web Design eBook Collection','price',19.99)),
  (5, 9, 1, 79.00, 'fulfilled', JSON_OBJECT('title','React.js Advanced Course','price',79.00)),
  (6, 2, 2, 45.50, 'pending', JSON_OBJECT('title','USB-C Hub 7-in-1','price',45.50)),
  (6, 4, 2, 9.99, 'pending', JSON_OBJECT('title','Learning SQL eBook','price',9.99)),
  (7, 1, 2, 25.90, 'fulfilled', JSON_OBJECT('title','Wireless Mouse Pro','price',25.90)),
  (7, 3, 1, 89.99, 'fulfilled', JSON_OBJECT('title','Mechanical Keyboard RGB','price',89.99)),
  (8, 5, 1, 14.99, 'fulfilled', JSON_OBJECT('title','Advanced Python eBook','price',14.99)),
  (8, 7, 1, 49.00, 'pending', JSON_OBJECT('title','PHP for Beginners Course','price',49.00)),
  (9, 8, 1, 69.00, 'fulfilled', JSON_OBJECT('title','JavaScript Mastery Course','price',69.00)),
  (10, 1, 1, 25.90, 'fulfilled', JSON_OBJECT('title','Wireless Mouse Pro','price',25.90)),
  (10, 2, 2, 45.50, 'fulfilled', JSON_OBJECT('title','USB-C Hub 7-in-1','price',45.50)),
  (10, 6, 1, 19.99, 'pending', JSON_OBJECT('title','Web Design eBook Collection','price',19.99)),
  (11, 3, 1, 89.99, 'pending', JSON_OBJECT('title','Mechanical Keyboard RGB','price',89.99)),
  (11, 4, 1, 9.99, 'fulfilled', JSON_OBJECT('title','Learning SQL eBook','price',9.99)),
  (12, 9, 1, 79.00, 'fulfilled', JSON_OBJECT('title','React.js Advanced Course','price',79.00)),
  (12, 5, 1, 14.99, 'fulfilled', JSON_OBJECT('title','Advanced Python eBook','price',14.99)),
  (12, 6, 1, 19.99, 'pending', JSON_OBJECT('title','Web Design eBook Collection','price',19.99));


-- ========================================
-- PAYMENTS (12 Zahlungen)
-- ========================================
INSERT INTO payments (order_id, provider, transaction_id, amount, currency, status, paid_at) VALUES
  (1, 'stripe', 'tr_001abc123', 71.40, 'EUR', 'captured', NOW()),
  (2, 'paypal', 'pp_002def456', 89.99, 'EUR', 'authorized', NULL),
  (3, 'stripe', 'tr_003ghi789', 63.99, 'EUR', 'captured', DATE_SUB(NOW(), INTERVAL 1 DAY)),
  (4, 'stripe', 'tr_004jkl012', 88.99, 'EUR', 'captured', DATE_SUB(NOW(), INTERVAL 2 DAY)),
  (5, 'paypal', 'pp_005mno345', 49.00, 'EUR', 'captured', DATE_SUB(NOW(), INTERVAL 3 DAY)),
  (6, 'stripe', 'tr_006pqr678', 194.98, 'EUR', 'authorized', NULL),
  (7, 'paypal', 'pp_007stu901', 39.98, 'EUR', 'captured', DATE_SUB(NOW(), INTERVAL 5 DAY)),
  (8, 'stripe', 'tr_008vwx234', 109.99, 'EUR', 'captured', DATE_SUB(NOW(), INTERVAL 6 DAY)),
  (9, 'paypal', 'pp_009yza567', 49.00, 'EUR', 'captured', DATE_SUB(NOW(), INTERVAL 7 DAY)),
  (10, 'stripe', 'tr_010bcd890', 179.98, 'EUR', 'captured', DATE_SUB(NOW(), INTERVAL 8 DAY)),
  (11, 'stripe', 'tr_011efg123', 59.98, 'EUR', 'authorized', NULL),
  (12, 'paypal', 'pp_012hij456', 99.98, 'EUR', 'captured', DATE_SUB(NOW(), INTERVAL 10 DAY));


-- ========================================
-- PAYMENT EVENTS (12+ Zahlungsereignisse)
-- ========================================
INSERT INTO payment_events (payment_id, type, created_at) VALUES
  (1, 'capture', NOW()),
  (2, 'authorize', DATE_SUB(NOW(), INTERVAL 1 DAY)),
  (3, 'capture', DATE_SUB(NOW(), INTERVAL 1 DAY)),
  (4, 'capture', DATE_SUB(NOW(), INTERVAL 2 DAY)),
  (5, 'capture', DATE_SUB(NOW(), INTERVAL 3 DAY)),
  (6, 'authorize', DATE_SUB(NOW(), INTERVAL 3 DAY)),
  (6, 'capture', DATE_SUB(NOW(), INTERVAL 2 DAY)),
  (7, 'capture', DATE_SUB(NOW(), INTERVAL 5 DAY)),
  (8, 'capture', DATE_SUB(NOW(), INTERVAL 6 DAY)),
  (9, 'capture', DATE_SUB(NOW(), INTERVAL 7 DAY)),
  (10, 'capture', DATE_SUB(NOW(), INTERVAL 8 DAY)),
  (11, 'authorize', DATE_SUB(NOW(), INTERVAL 9 DAY)),
  (12, 'capture', DATE_SUB(NOW(), INTERVAL 10 DAY));


-- ========================================
-- VOUCHER TYPES (12 Gutschein-Typen)
-- ========================================
INSERT INTO v_types (type_name, description) VALUES
  ('Percentage', 'Percentage discount on purchase'),
  ('FixedAmount', 'Fixed amount discount in EUR'),
  ('FreeProduct', 'Gives a specific product for free'),
  ('FirstTimeUser', 'Special discount for new customers'),
  ('SeasonalSale', 'Seasonal promotions and discounts'),
  ('BundleDiscount', 'Discount on bundled products'),
  ('LoyaltyReward', 'Rewards for loyal customers'),
  ('ReferralBonus', 'Bonus for referring a friend'),
  ('ExclusiveMember', 'Exclusive member-only offers'),
  ('FlashSale', 'Limited time flash sale vouchers'),
  ('StudentDiscount', 'Discount for students'),
  ('CorporateSale', 'Corporate and bulk purchase discounts');


-- ========================================
-- VOUCHERS (12 Gutscheine)
-- ========================================
INSERT INTO vouchers (voucher_code, value, product_id, discount_rate) VALUES
  ('WELCOME10', 0.00, NULL, 10.00),
  ('FIXED5', 5.00, NULL, NULL),
  ('FREECOURSE', 0.00, 7, NULL),
  ('NEWUSER15', 0.00, NULL, 15.00),
  ('SUMMER20', 0.00, NULL, 20.00),
  ('BUNDLE25', 0.00, NULL, 25.00),
  ('LOYAL30', 0.00, NULL, 30.00),
  ('REFERRAL10EUR', 10.00, NULL, NULL),
  ('VIPEXC', 0.00, NULL, 35.00),
  ('FLASH50', 50.00, NULL, NULL),
  ('STUDENT12', 0.00, NULL, 12.00),
  ('CORPORATE5OFF', 5.00, NULL, NULL);


-- ========================================
-- VOUCHER TYPES MAPPING (12+ Zuordnungen)
-- ========================================
INSERT INTO vouchers_types (voucher_id, type_id) VALUES
  (1, 1),   -- WELCOME10 -> Percentage
  (2, 2),   -- FIXED5 -> Fixed Amount
  (3, 3),   -- FREECOURSE -> Free Product
  (4, 4),   -- NEWUSER15 -> First Time User
  (5, 5),   -- SUMMER20 -> Seasonal Sale
  (6, 6),   -- BUNDLE25 -> Bundle Discount
  (7, 7),   -- LOYAL30 -> Loyalty Reward
  (8, 8),   -- REFERRAL10EUR -> Referral Bonus
  (9, 9),   -- VIPEXC -> Exclusive Member
  (10, 10), -- FLASH50 -> Flash Sale
  (11, 11), -- STUDENT12 -> Student Discount
  (12, 12); -- CORPORATE5OFF -> Corporate Sale


-- ========================================
-- USER VOUCHERS (12 Gutschein-Besitztümer)
-- ========================================
INSERT INTO users_voucher (user_id, voucher_id, purchased_at, expiring_at) VALUES
  (1, 1, NOW(), DATE_ADD(NOW(), INTERVAL 30 DAY)),
  (1, 3, NOW(), DATE_ADD(NOW(), INTERVAL 60 DAY)),
  (2, 2, DATE_SUB(NOW(), INTERVAL 5 DAY), DATE_ADD(NOW(), INTERVAL 60 DAY)),
  (2, 7, DATE_SUB(NOW(), INTERVAL 10 DAY), DATE_ADD(NOW(), INTERVAL 85 DAY)),
  (3, 4, NOW(), DATE_ADD(NOW(), INTERVAL 30 DAY)),
  (3, 5, DATE_SUB(NOW(), INTERVAL 2 DAY), DATE_ADD(NOW(), INTERVAL 28 DAY)),
  (4, 6, DATE_SUB(NOW(), INTERVAL 7 DAY), DATE_ADD(NOW(), INTERVAL 23 DAY)),
  (4, 8, NOW(), DATE_ADD(NOW(), INTERVAL 45 DAY)),
  (5, 9, DATE_SUB(NOW(), INTERVAL 1 DAY), DATE_ADD(NOW(), INTERVAL 29 DAY)),
  (6, 10, NOW(), DATE_ADD(NOW(), INTERVAL 14 DAY)),
  (7, 11, DATE_SUB(NOW(), INTERVAL 3 DAY), DATE_ADD(NOW(), INTERVAL 27 DAY)),
  (8, 12, NOW(), DATE_ADD(NOW(), INTERVAL 90 DAY)),
  (9, 1, DATE_SUB(NOW(), INTERVAL 4 DAY), DATE_ADD(NOW(), INTERVAL 26 DAY)),
  (10, 3, DATE_SUB(NOW(), INTERVAL 2 DAY), DATE_ADD(NOW(), INTERVAL 58 DAY)),
  (11, 5, NOW(), DATE_ADD(NOW(), INTERVAL 30 DAY)),
  (12, 7, DATE_SUB(NOW(), INTERVAL 6 DAY), DATE_ADD(NOW(), INTERVAL 84 DAY));


-- ========================================
-- SUMMARY
-- ========================================
-- Users: 12
-- User Profiles: 12
-- User Addresses: 24 (2 pro User)
-- Categories: 12
-- Products: 12
-- Product Categories: 12 (1:1 Mapping)
-- Physical Products: 3
-- Digital Products: 3
-- Courses: 3
-- Seminar Locations: 4
-- Live Seminars: 12
-- Seminar Participants: 40+ (mehrfach Zuordnungen)
-- Carts: 12 (1 pro User)
-- Cart Items: 22+
-- Wishlists: 12 (1 pro User)
-- Wishlist Items: 36+
-- Orders: 12 (1-2 pro User)
-- Order Items: 24+
-- Payments: 12 (1 pro Order)
-- Payment Events: 13+
-- Voucher Types: 12
-- Vouchers: 12
-- Voucher Type Mappings: 12
-- User Vouchers: 16

-- Alle Daten wurden erfolgreich eingefügt! ✅
