CREATE DATABASE IF NOT EXISTS webshop
    DEFAULT CHARACTER SET utf8mb4
    COLLATE utf8mb4_general_ci;

USE webshop;

-- =====================
-- USERS TABLE
-- =====================
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE,
    password_hash VARCHAR(255),
    name VARCHAR(100),
    surname VARCHAR(100),
    gender VARCHAR(10),
    birthdate DATE,
    email VARCHAR(100) UNIQUE,
    country VARCHAR(50),
    postal_index VARCHAR(50),
    street VARCHAR(255),
    phone VARCHAR(20),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    is_active BOOLEAN DEFAULT TRUE,
    role VARCHAR(20) DEFAULT 'user'
) ENGINE=InnoDB;

-- =====================
-- ADMINS TABLE
-- =====================
CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE,
    password_hash VARCHAR(255),
    name VARCHAR(100),
    surname VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    role VARCHAR(20) DEFAULT 'admin'
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


-- Tabelle für Seminartermine
CREATE TABLE IF NOT EXISTS seminar_dates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    start_datetime DATETIME NOT NULL,
    end_datetime DATETIME NOT NULL,
    room VARCHAR(100),
    min_participants INT DEFAULT 1,
    max_participants INT DEFAULT 10,
    valid_to_start BOOLEAN DEFAULT FALSE,
    available_for_reservation BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);


-- Tabelle für Seminar-Anmeldungen (Teilnehmer)
CREATE TABLE IF NOT EXISTS seminar_registrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    seminar_date_id INT NOT NULL,
    registration_datetime DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (seminar_date_id) REFERENCES seminar_dates(id) ON DELETE CASCADE
);
