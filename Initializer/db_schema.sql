CREATE DATABASE IF NOT EXISTS webshop
    DEFAULT CHARACTER SET utf8mb4
    COLLATE utf8mb4_general_ci;

USE webshop;

-- =====================
-- USERS TABLE
-- =====================
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    name VARCHAR(100),
    surname VARCHAR(100),
    email VARCHAR(100) UNIQUE NOT NULL,
    role VARCHAR(20) DEFAULT 'user'
) ENGINE=InnoDB;

-- =====================
-- PRODUCTS TABLE
-- if a product has min_capacity 
-- =====================
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(50) NOT NULL,
    image_url VARCHAR(255) DEFAULT NULL,
    description VARCHAR(500) DEFAULT 'No description',
    price DECIMAL(10,2) NOT NULL,
    min_capacity INT DEFAULT 0,
    max_capacity INT DEFAULT NULL,
    start_date DATE,
    end_date DATE,
    valid_to_start BOOLEAN DEFAULT FALSE,
    available_for_reservation BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =====================
-- CATEGORIES TABLE
-- =====================
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(100) NOT NULL UNIQUE,
    description VARCHAR(255) DEFAULT NULL
) ENGINE=InnoDB;

-- =====================
-- USERS_PRODUCTS TABLE
-- Many-to-many: users ↔ products
-- =====================
CREATE TABLE IF NOT EXISTS users_products (
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (user_id, product_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =====================
-- PRODUCTS_CATEGORIES TABLE
-- Many-to-many: products ↔ categories
-- =====================
CREATE TABLE IF NOT EXISTS products_categories (
    product_id INT NOT NULL,
    category_id INT NOT NULL,
    PRIMARY KEY (product_id, category_id),
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
) ENGINE=InnoDB;
