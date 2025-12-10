-- =====================
-- DUMMY USERS
-- admin user(username: admin, password: admin1)
-- =====================
INSERT INTO users (username, password_hash, name, surname, email, role) VALUES
('jdoe', '$2y$10$examplehash1', 'John', 'Doe', 'jdoe@example.com', 'user'),
('asmith', '$2y$10$examplehash2', 'Alice', 'Smith', 'asmith@example.com', 'user'),
('bwayne', '$2y$10$examplehash3', 'Bruce', 'Wayne', 'bwayne@example.com', 'user'),
('admin', '$2y$12$wTvJXqcfg1e6df0RtRUFB.7vkDvRWdCHJlO/S/6veiGYCJIar5khG', 'Aristotelis', 'Papadopoulos', 'admin@example.com', 'admin');

-- =====================
-- DUMMY CATEGORIES
-- =====================
INSERT INTO categories (category_name, description) VALUES
('Software', 'Courses related to programming and software development'),
('Web Development', 'Courses related to web development and UI/UX design'),
('Marketing', 'Courses about digital marketing and SEO strategies'),
('Business', 'Courses related to business management and entrepreneurship');

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
(1, 1), -- Python Masterclass → Software
(2, 1), -- Modern JavaScript Pro → Software
(3, 2), -- React Native Apps → Web Development
(4, 1), -- Data Science mit R → Software
(4, 4), -- Data Science mit R → Business
(5, 1), -- AI & Machine Learning → Software
(6, 1), -- Cybersecurity Basics → Software
(7, 1), -- DevOps: Docker & K8s → Software
(8, 2), -- C# & Unity Game Dev → Web Development
(9, 2), -- Fullstack Web Dev → Web Development
(10, 1), -- AWS Cloud Architect → Software
(10, 4), -- AWS Cloud Architect → Business
(4, 3); -- Data Science mit R → Marketing