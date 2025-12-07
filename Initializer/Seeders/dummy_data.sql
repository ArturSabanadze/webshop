-- =====================
-- DUMMY USERS
-- =====================
INSERT INTO users (username, password_hash, name, surname, email, role) VALUES
('jdoe', '$2y$10$examplehash1', 'John', 'Doe', 'jdoe@example.com', 'admin'),
('asmith', '$2y$10$examplehash2', 'Alice', 'Smith', 'asmith@example.com', 'user'),
('bwayne', '$2y$10$examplehash3', 'Bruce', 'Wayne', 'bwayne@example.com', 'user');

-- =====================
-- DUMMY CATEGORIES
-- =====================
INSERT INTO categories (category_name, description) VALUES
('Programming', 'Courses related to programming and software development'),
('Design', 'Courses related to graphic and UI/UX design'),
('Marketing', 'Courses about digital marketing and SEO strategies');

-- =====================
-- DUMMY PRODUCTS
-- =====================
INSERT INTO products (product_name, description, price, min_capacity, max_capacity, start_date, end_date, valid_to_start, available_for_reservation) VALUES
('PHP for Beginners', 'Learn PHP from scratch', 99.99, 1, 30, '2025-01-10', '2025-02-10', TRUE, TRUE),
('Advanced JavaScript', 'Deep dive into JS concepts', 149.99, 2, 25, '2025-03-01', '2025-04-01', TRUE, TRUE),
('UI/UX Design Fundamentals', 'Learn the basics of design', 79.99, 1, 20, '2025-02-15', '2025-03-15', TRUE, TRUE),
('Digital Marketing 101', 'Introduction to digital marketing', 59.99, 1, 50, NULL, NULL, FALSE, TRUE);

-- =====================
-- DUMMY USERS_PRODUCTS (enrollments)
-- =====================
INSERT INTO users_products (user_id, product_id) VALUES
(1, 1), -- John Doe enrolled in PHP for Beginners
(2, 2), -- Alice Smith enrolled in Advanced JavaScript
(2, 3), -- Alice Smith enrolled in UI/UX Design Fundamentals
(3, 4); -- Bruce Wayne enrolled in Digital Marketing 101

-- =====================
-- DUMMY PRODUCTS_CATEGORIES
-- =====================
INSERT INTO products_categories (product_id, category_id) VALUES
(1, 1), -- PHP for Beginners → Programming
(2, 1), -- Advanced JavaScript → Programming
(3, 2), -- UI/UX Design Fundamentals → Design
(4, 3); -- Digital Marketing 101 → Marketing