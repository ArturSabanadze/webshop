-- =====================
-- DUMMY USERS
-- =====================
INSERT INTO users (username, password_hash, name, surname, email, role) VALUES
('jdoe', '$2y$10$examplehash1', 'John', 'Doe', 'jdoe@example.com', 'user'),
('asmith', '$2y$10$examplehash2', 'Alice', 'Smith', 'asmith@example.com', 'user'),
('bwayne', '$2y$10$examplehash3', 'Bruce', 'Wayne', 'bwayne@example.com', 'user');

-- =====================
-- DUMMY CATEGORIES
-- =====================
INSERT INTO categories (category_name, description) VALUES
('Software', 'Courses related to programming and software development'),
('Web Development', 'Courses related to web development and UI/UX design'),
('Marketing', 'Courses about digital marketing and SEO strategies'),
('Business', 'Courses related to business management and entrepreneurship');

-- =====================
-- DUMMY PRODUCTS
-- =====================
INSERT INTO products (
    product_name, 
    image_url, 
    description, 
    price, 
    min_capacity, 
    max_capacity, 
    start_date, 
    end_date, 
    valid_to_start, 
    available_for_reservation
) VALUES

('Python Masterclass', '../../assets/product_images/python-bootcamp.webp', 'Der komplette Einstieg: Von Variablen bis zu Machine Learning Grundlagen.', 49.99, 6, 20, '2025-03-01', '2025-04-15', FALSE, TRUE),
('Modern JavaScript Pro', '../../assets/product_images/js-frontend-pro.webp', 'Beherrsche ES6+, Async/Await und DOM-Manipulation wie ein Profi.', 59.90, 8, 25, '2025-03-10', '2025-04-20', FALSE, TRUE),
('React Native Apps', '../../assets/product_images/react-native-app.webp', 'Baue echte iOS und Android Apps mit nur einer Codebasis.', 69.99, 6, 20, '2025-03-15', '2025-05-01', FALSE, TRUE),
('Data Science mit R', '../../assets/product_images/data-science-r.webp', 'Datenvisualisierung und statistische Analyse für Big Data Projekte.', 79.00, 10, 25, '2025-04-01', '2025-06-01', FALSE, TRUE),
('AI & Machine Learning', '../../assets/product_images/machine-learning-ai.webp', 'Trainiere neuronale Netze mit TensorFlow und PyTorch.', 89.99, 10, 20, '2025-04-05', '2025-06-15', FALSE, TRUE),
('Cybersecurity Basics', '../../assets/product_images/cyber-security-hacker.webp', 'Ethisches Hacking, Netzwerksicherheit und Penetration Testing.', 64.50, 8, 20, '2025-04-10', '2025-05-20', FALSE, TRUE),
('DevOps: Docker & K8s', '../../assets/product_images/docker-kubernetes-devops.webp', 'Containerisierung und Orchestrierung für skalierbare Cloud-Apps.', 74.90, 6, 15, '2025-05-01', '2025-06-01', FALSE, TRUE),
('C# & Unity Game Dev', '../../assets/product_images/c-sharp-game-dev.webp', 'Entwickle dein erstes 3D-Spiel von Grund auf.', 55.00, 6, 20, '2025-05-15', '2025-07-15', FALSE, TRUE),
('Fullstack Web Dev', '../../assets/product_images/web-fullstack-dev.webp', 'HTML, CSS, NodeJS und Datenbanken – das komplette Paket.', 99.00, 10, 30, '2025-06-01', '2025-08-30', FALSE, TRUE),
('AWS Cloud Architect', '../../assets/product_images/aws-cloud-architect.webp', 'Vorbereitung auf die Zertifizierung und Serverless Computing.', 95.00, 8, 25, '2025-06-15', '2025-08-15', FALSE, TRUE);


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