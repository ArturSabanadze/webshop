## 📋 Table of Contents

- [Overview](#overview)
- [Installation](#installation)
- [Architecture](#architecture)
- [Project Structure](#project-structure)
- [Core Classes & Traits](#core-classes--traits)
- [Key Functions](#key-functions)
- [Database Schema](#database-schema)
- [Security Features](#security-features)
- [Tech Stack](#tech-stack)
- [Team](#team)
- [Repository](#repository)

## Overview

A comprehensive web-based platform for managing and booking seminars/courses online. This project implements a full-featured webshop designed for multi products.

⚠️ Important Warning

Attention: This web application is currently under active development and is not yet production-ready. By installing or using this software, you acknowledge and accept the following risks:

Incomplete Features: Some functionalities are not implemented or partially implemented. Certain pages, workflows, or admin features may not behave as expected.

Potential Bugs: The application may contain bugs, errors, or security gaps. Use at your own risk; data loss or unexpected behavior is possible.

Security Limitations: While basic security measures (password hashing, prepared statements, session management) are implemented, the application has not been fully security-audited. Do not deploy this system in production or on the public internet without proper review and hardening.

Data Integrity: Test data is included for demonstration purposes. Using your own data may lead to unexpected behavior or conflicts if database schemas or constraints are altered.

Experimental Setup: Installation scripts (e.g., setup.bat) are designed for Windows + XAMPP environments. Running them in other environments may fail or cause errors.

Recommendations:

Use this software in a development or testing environment only.

Avoid exposing the application to the internet until full testing, security hardening, and feature completion are done.

Backup any important data before testing.

Contribute improvements, bug fixes, or security enhancements responsibly.

Disclaimer: This software is intended for educational and demonstration purposes only. The authors are not responsible for data loss, system damage, or security issues resulting from its use.

## Installation

### Prerequisites .

- XAMPP installed at C:/xampp (Apache + MySQL)
- Windows operating system (for setup.bat automation)
- Ensure MySQL has no password (default)

### Installation Steps

1. **Automated Setup:**

   - Run `setup.bat` to:
     - Copy project files to XAMPP htdocs
     - Create database schema
     - Import test data
     - Configure environment

1. **Start Apache and MySQL:**

   - Start xampp
   - Run Apache and MySQL from XAMPP Control Panel

1. **Access the Application:**

   - Open Browser
   - Frontend URL: http://localhost/gruppe1/Frontend/public/index.php
   - Test User Credentials:

     - username: user
     - password: user1

   - Admin Dashboard URL: http://localhost/gruppe1/Frontend/public/AdminDashboard/private/admin_dashboard.php
   - Admin Credentials:
     - username: admin
     - password: admin1

## Architecture

The project follows a modern three-tier architecture:

- **Backend**: RESTful API handlers for business logic and database operations
- **Admin Dashboard**: Protected administrative interface for system management
- **Frontend**: PHP-based user interface with responsive design
- **Database**: MySQL database with normalized schema using PDO for secure data access

## Key Features

### 1. **Product/Seminar Display**

- **Location**: `Frontend/src/Includes/main.php`
- Grid view of all available seminars/courses
- Fetches product data from the database and renders in an organized card layout
- Displays product images, descriptions, prices, and availability

### 2. **Advanced Search & Filtering**

- **Location**: `Frontend/src/Includes/shop.php`, `Frontend/src/Functions/product_card_loader.php`
- Search seminars by keywords
- Filter by categories (Software, Web Development, Business, Marketing)
- Sort by price (low to high, high to low) or newest
- Real-time filtering using AJAX

### 3. **User Authentication System**

- **Location**: `Frontend/src/Includes/login.php`, `Frontend/src/Includes/register.php`, `Backend/login_handler.php`, `Backend/register_handler.php`
- Secure user registration with password hashing
- Token-based authentication system
- Session management for logged-in users
- Role-based access control (user/admin)

### 4. **Seminar Enrollment Process**

- **Location**: `Frontend/src/Includes/shop.php`, Backend API endpoints (`ajax_enroll.php`, `ajax_get_seminar_dates.php`)
- Browse available seminar dates and times
- Real-time enrollment processing via AJAX
- Save in Database and serialized file (`Frontend/src/Data/enrollments.txxt`)
- Enrollment confirmation and tracking

### 5. **User Panel**

- **Location**: `Frontend/src/Includes/user_panel.php`
- Manage personal account information

### 6. **Admin Dashboard**

- **Location**: `Frontend/public/AdminDashboard/*`
- Comprehensive seminar management (create, delete)
- Image upload functionality for seminar promotion
- Seminar date/schedule management
- Participant tracking
- Room assignment and capacity control
- Admin credentials: username: `admin`, password: `admin1`

### 7. **Membership Plans**

- **Location**: `Frontend/src/Includes/membership.php`
- Three-tier membership system:
  - **Student** (€9/month): Basic course access
  - **Student+** (€19/month): Live workshops + downloadable resources
  - **Student-Pro** (€39/month): Premium features

### 8. **Additional Pages**

- **About**: Team member profiles and project information
- **Contact**: Contact form for inquiries
- **Impressum**: Legal information
- **Terms & Conditions (AGB)**: Booking and participation policies

## Database Schema

The application uses a MySQL database with the following main tables:

- **admins**: seperate table to store users with admin rights
  - Fields: id, username, password_hash, email, role etc.
- **users**: User accounts with authentication and profile data
  - Fields: id, username, password_hash, email, role, name, surname, birthdate, etc.
- **products**: Seminar/course information
  - Fields: id, product_name, description, price, image_url, capacity limits, dates, availability
- **categories**: Seminar categories for organization
- **seminar_dates**: Specific date/time slots for seminars
  - Fields: id, product_id, start_datetime, end_datetime, room, max_participants
- **seminar_registrations**: User enrollments in seminars
  - Fields: id, user_id, seminar_date_id, registration_datetime
- **users_products**: Many-to-many relationship between users and products
- **products_categories**: Many-to-many relationship between products and categories

## Project Structure

```
webshop/
├── Backend/
│   ├── config/                                 # Environment configuration
│   ├── db_connection.php                       # PDO database connection
│   ├── login_handler.php                       # Login authentication logic for Users and Admin
│   └── register_handler.php                    # User registration logic
├── Frontend/
│   ├── public/                                 # Public web root
│   │   ├── AdminDashboard/                     # Admin interface
│   │   ├── assets/                             # Images
│   │   ├── styles/                             # CSS
│   │   ├── ajax_get_seminar_dates.php          # Read available seminars and return a json
│   │   ├── ajax_enroll.php                     # Seminar Enrollment handler
│   │   └── index.php                           # Main entry point
│   └── src/
│       ├── Controllers/                        # Request handlers
│       ├── Functions/                          # Business logic
│       ├── Data/                               # Serialized data files (Contact messages, seminar enrollments)
│       └── Includes/                           # Page components / Templates
├── Initializer/
│   ├── db_schema.sql                           # Database schema
│   └── Dummy/                                  # Test data
│       ├── products.csv                        # Test data in csv format
│       └── load_seminare.sql                   # SQL script to load from csv file
├── Documentation/
│   ├── Use_Case_1.jpg                          # Dokumentation files (UML etc.)
├── setup.bat                                   # Automated setup script
└── Readme.MD                                   # This file
```

## Technologies Used

- **Backend**: PHP 7+
- **Database**: MySQL with PDO
- **Frontend**: HTML5, CSS3, PHP, JavaScript
- **Server**: Apache (XAMPP)
- **Architecture**: MVC-inspired pattern with separation of concerns

## Security Features

- Password hashing using PHP's password_hash()
- SQL injection protection via PDO prepared statements
- Session-based authentication
- Role-based access control
- Input validation and sanitization
- CSRF protection for forms.

## Team

- **Dominik Kraft** - Database Engineer
- **Artur Sabanadze** - Full-Stack Developer
- **Tobias Heinrich Dyck** - Backend Developer
- **Ingo Paar** - Frontend Developer

## Repository

1. **Clone the repository:** (If you have the Project zip folder skip to step 2)

   ```bash
   git clone https://github.com/ArturSabanadze/webshop.git
   cd webshop
   ```

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Contributing

This is an educational project developed as part of a PHP web development course. Feel free to fork and experiment with the code.

## Support

For questions or issues:

- Check the Documentation folder for detailed guides
- Review the Anleitung.txt for setup troubleshooting
- Contact us on GitHub (ArturSabanadze, KenjiPetto, ColaNotPeppsy, in6o)

---

**Note**: This is a demonstration project for educational purposes. Ensure proper security measures are implemented before deploying to production.
