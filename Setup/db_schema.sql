CREATE DATABASE IF NOT EXISTS gruppe1
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE gruppe1;
-- =========================
-- Products & categories
-- =========================

CREATE TABLE products (
  id                INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  title             VARCHAR(255) NOT NULL,
  description       TEXT,
  image_url         VARCHAR(500),
  price             DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  status            ENUM('draft','active','inactive') NOT NULL DEFAULT 'draft',
  created_at        DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  start_selling_date DATETIME NULL
) ENGINE=InnoDB;

CREATE TABLE categories (
  id             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  category_name  VARCHAR(255) NOT NULL,
  description    TEXT
) ENGINE=InnoDB;

CREATE TABLE product_categories (
  id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  product_id  INT UNSIGNED NOT NULL,
  category_id INT UNSIGNED NOT NULL,
  UNIQUE KEY uq_product_category (product_id, category_id),
  CONSTRAINT fk_pc_product
    FOREIGN KEY (product_id) REFERENCES products(id)
    ON DELETE CASCADE,
  CONSTRAINT fk_pc_category
    FOREIGN KEY (category_id) REFERENCES categories(id)
    ON DELETE CASCADE
) ENGINE=InnoDB;

-- Physical products

CREATE TABLE physical_products (
  product_id        INT UNSIGNED PRIMARY KEY,
  stock             INT NOT NULL DEFAULT 0,
  weight            DECIMAL(10,3) NULL,
  pack_size_height  DECIMAL(10,2) NULL,
  pack_size_width   DECIMAL(10,2) NULL,
  pack_size_depth   DECIMAL(10,2) NULL,
  shipping_required TINYINT(1) NOT NULL DEFAULT 1,
  CONSTRAINT fk_pp_product
    FOREIGN KEY (product_id) REFERENCES products(id)
    ON DELETE CASCADE
) ENGINE=InnoDB;

-- Digital products

CREATE TABLE digital_products (
  product_id   INT UNSIGNED PRIMARY KEY,
  file_url     VARCHAR(500) NOT NULL,
  license_type VARCHAR(100),
  CONSTRAINT fk_dp_product
    FOREIGN KEY (product_id) REFERENCES products(id)
    ON DELETE CASCADE
) ENGINE=InnoDB;

-- Courses

CREATE TABLE courses (
  product_id     INT UNSIGNED PRIMARY KEY,
  content_url    VARCHAR(500) NOT NULL,
  content_creator VARCHAR(255),
  CONSTRAINT fk_courses_product
    FOREIGN KEY (product_id) REFERENCES products(id)
    ON DELETE CASCADE
) ENGINE=InnoDB;

-- Seminars

CREATE TABLE seminars_locations (
  id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  street        VARCHAR(255),
  street_number VARCHAR(50),
  zip_code      VARCHAR(20),
  state         VARCHAR(100),
  province      VARCHAR(100),
  country       VARCHAR(100)
) ENGINE=InnoDB;

CREATE TABLE live_seminars (
  id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  product_id       INT UNSIGNED NOT NULL,
  start_date       DATETIME NOT NULL,
  end_date         DATETIME NOT NULL,
  location_id      INT UNSIGNED NOT NULL,
  min_participants INT UNSIGNED,
  max_participants INT UNSIGNED,
  CONSTRAINT fk_ls_product
    FOREIGN KEY (product_id) REFERENCES products(id)
    ON DELETE CASCADE,
  CONSTRAINT fk_ls_location
    FOREIGN KEY (location_id) REFERENCES seminars_locations(id)
    ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE seminar_participants (
  id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  seminar_id  INT UNSIGNED NOT NULL,
  user_id     INT UNSIGNED NOT NULL,
  UNIQUE KEY uq_seminar_user (seminar_id, user_id)
) ENGINE=InnoDB;

-- =========================
-- Users, Admins & related
-- =========================
CREATE TABLE admins (
  id             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  username       VARCHAR(100) NOT NULL UNIQUE,
  password_hash  VARCHAR(255) NOT NULL,
  email          VARCHAR(255) NOT NULL UNIQUE,
  role           ENUM('admin','superadmin') NOT NULL DEFAULT 'admin'
) ENGINE=InnoDB;


CREATE TABLE users (
  id             INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  username       VARCHAR(100) NOT NULL UNIQUE,
  password_hash  VARCHAR(255) NOT NULL,
  email          VARCHAR(255) NOT NULL UNIQUE,
  role           ENUM('user','contributor') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB;

CREATE TABLE users_profiles (
  user_id       INT UNSIGNED PRIMARY KEY,
  name          VARCHAR(100),
  surname       VARCHAR(100),
  gender        VARCHAR(100),
  birthdate     DATE,
  phone         VARCHAR(20),
  biography     TEXT,
  profile_img_url VARCHAR(500),
  CONSTRAINT fk_up_user
    FOREIGN KEY (user_id) REFERENCES users(id)
    ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE users_addresses (
  id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id       INT UNSIGNED NOT NULL,
  type          ENUM('billing','shipping','general') NOT NULL DEFAULT 'general',
  zip_code      VARCHAR(20),
  country       VARCHAR(100),
  street        VARCHAR(255),
  street_number VARCHAR(50),
  state         VARCHAR(100),
  province      VARCHAR(100),
  CONSTRAINT fk_ua_user
    FOREIGN KEY (user_id) REFERENCES users(id)
    ON DELETE CASCADE
) ENGINE=InnoDB;

-- =========================
-- Carts & wishlist
-- =========================

CREATE TABLE carts (
  id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id    INT UNSIGNED NOT NULL,
  currency   VARCHAR(10) NOT NULL DEFAULT 'EUR',
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NULL,
  CONSTRAINT fk_carts_user
    FOREIGN KEY (user_id) REFERENCES users(id)
    ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE carts_items (
  id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  cart_id    INT UNSIGNED NOT NULL,
  product_id INT UNSIGNED NOT NULL,
  quantity   INT NOT NULL DEFAULT 1,
  unit_price DECIMAL(10,2) NOT NULL,
  applied_discount DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  CONSTRAINT fk_ci_cart
    FOREIGN KEY (cart_id) REFERENCES carts(id)
    ON DELETE CASCADE,
  CONSTRAINT fk_ci_product
    FOREIGN KEY (product_id) REFERENCES products(id)
    ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE wishlist (
  id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id    INT UNSIGNED NOT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NULL,
  CONSTRAINT fk_wl_user
    FOREIGN KEY (user_id) REFERENCES users(id)
    ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE wishlist_items (
  id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  wishlist_id INT UNSIGNED NOT NULL,
  product_id  INT UNSIGNED NOT NULL,
  UNIQUE KEY uq_wishlist_product (wishlist_id, product_id),
  CONSTRAINT fk_wli_wishlist
    FOREIGN KEY (wishlist_id) REFERENCES wishlist(id)
    ON DELETE CASCADE,
  CONSTRAINT fk_wli_product
    FOREIGN KEY (product_id) REFERENCES products(id)
    ON DELETE RESTRICT
) ENGINE=InnoDB;

-- =========================
-- Orders & payments
-- =========================

CREATE TABLE orders (
  id                     INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id                INT UNSIGNED NOT NULL,
  status                 ENUM('pending','confirmed','shipped','completed','cancelled') NOT NULL DEFAULT 'pending',
  total_amount           DECIMAL(10,2) NOT NULL DEFAULT 1,
  billing_address_id     INT UNSIGNED,
  billing_address_snapshot  JSON,
  shipping_address_id    INT UNSIGNED,
  shipping_address_snapshot JSON,
  created_at             DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_orders_user
    FOREIGN KEY (user_id) REFERENCES users(id)
    ON DELETE CASCADE,
  CONSTRAINT fk_orders_ba
    FOREIGN KEY (billing_address_id) REFERENCES users_addresses(id)
    ON DELETE SET NULL,
  CONSTRAINT fk_orders_sa
    FOREIGN KEY (shipping_address_id) REFERENCES users_addresses(id)
    ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE order_items (
  id                INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  order_id          INT UNSIGNED NOT NULL,
  product_id        INT UNSIGNED NOT NULL,
  quantity          INT NOT NULL DEFAULT 1,
  unit_price        DECIMAL(10,2) NOT NULL,
  status            ENUM('pending','fulfilled','cancelled','refunded') NOT NULL DEFAULT 'pending',
  product_snapshot  JSON,
  CONSTRAINT fk_oi_order
    FOREIGN KEY (order_id) REFERENCES orders(id)
    ON DELETE CASCADE,
  CONSTRAINT fk_oi_product
    FOREIGN KEY (product_id) REFERENCES products(id)
    ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE payments (
  id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  order_id      INT UNSIGNED NOT NULL,
  provider      VARCHAR(50) NOT NULL,
  transaction_id VARCHAR(100),
  amount        DECIMAL(10,2) NOT NULL,
  currency      VARCHAR(10) NOT NULL DEFAULT 'EUR',
  status        ENUM('authorized','captured','refunded','failed') NOT NULL,
  paid_at       DATETIME NULL,
  CONSTRAINT fk_pay_order
    FOREIGN KEY (order_id) REFERENCES orders(id)
    ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE payment_events (
  id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  payment_id  INT UNSIGNED NOT NULL,
  type        ENUM('authorize','capture','refund','fail') NOT NULL,
  created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_pe_payment
    FOREIGN KEY (payment_id) REFERENCES payments(id)
    ON DELETE CASCADE
) ENGINE=InnoDB;

-- =========================
-- Vouchers
-- =========================

CREATE TABLE vouchers (
  id            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  voucher_code  VARCHAR(100) NOT NULL UNIQUE,
  value         DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  product_id    INT UNSIGNED NULL,
  discount_rate DECIMAL(5,2) NULL,
  CONSTRAINT fk_voucher_product
    FOREIGN KEY (product_id) REFERENCES products(id)
    ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE voucher_categories (
  id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  category_name   VARCHAR(100) NOT NULL,
  description TEXT
) ENGINE=InnoDB;

CREATE TABLE vouchers_types (
  voucher_id INT UNSIGNED NOT NULL,
  type_id    INT UNSIGNED NOT NULL,
  PRIMARY KEY (voucher_id, type_id),
  CONSTRAINT fk_vt_voucher
    FOREIGN KEY (voucher_id) REFERENCES vouchers(id)
    ON DELETE CASCADE,
  CONSTRAINT fk_vt_type
    FOREIGN KEY (type_id) REFERENCES voucher_categories(id)
    ON DELETE CASCADE
) ENGINE=InnoDB;

-- Link users to vouchers (ownership / redemption)

CREATE TABLE users_voucher (
  id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id     INT UNSIGNED NOT NULL,
  voucher_id  INT UNSIGNED NOT NULL,
  purchased_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  expiring_at  DATETIME NULL,
  UNIQUE KEY uq_user_voucher (user_id, voucher_id),
  CONSTRAINT fk_uv_user
    FOREIGN KEY (user_id) REFERENCES users(id)
    ON DELETE CASCADE,
  CONSTRAINT fk_uv_voucher
    FOREIGN KEY (voucher_id) REFERENCES vouchers(id)
    ON DELETE CASCADE
) ENGINE=InnoDB;

-- Add the missing foreign keys for seminar_participants
ALTER TABLE seminar_participants
  ADD CONSTRAINT fk_sp_seminar
    FOREIGN KEY (seminar_id) REFERENCES live_seminars(id)
    ON DELETE CASCADE,
  ADD CONSTRAINT fk_sp_user
    FOREIGN KEY (user_id) REFERENCES users(id)
    ON DELETE CASCADE;
