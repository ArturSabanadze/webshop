# Webshop - Seminar Management System

A comprehensive web-based platform for managing and booking seminars/courses online. This project implements a full-featured webshop specifically designed for educational seminars with user authentication, admin dashboard, and enrollment management.

## 📋 Project Overview

This webshop is a seminar management system that enables users to browse available courses, register for seminars, and manage their enrollments. The platform provides a user-friendly interface for customers and a powerful admin dashboard for managing seminars, dates, and participants.

## 🏗️ Architecture

The project follows a modern three-tier architecture:

- **Frontend**: PHP-based user interface with responsive design
- **Backend**: RESTful API handlers for business logic and database operations
- **Database**: MySQL database with normalized schema using PDO for secure data access
- **Admin Dashboard**: Protected administrative interface for system management

## ✨ Key Features

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
- View capacity and availability information
- Real-time enrollment processing via AJAX
- Enrollment confirmation and tracking

### 5. **User Panel**
- **Location**: `Frontend/src/Includes/user_panel.php`
- View enrolled seminars
- Manage personal account information
- Track registration history

### 6. **Admin Dashboard**
- **Location**: `Frontend/public/AdminDashboard/*`
- Comprehensive seminar management (create, edit, delete)
- Image upload functionality for seminar promotion
- Seminar date/schedule management
- Participant tracking and management
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

## 🗄️ Database Schema

The application uses a MySQL database with the following main tables:

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

## 🚀 Installation and Setup

### Prerequisites
- XAMPP (Apache + MySQL)
- Windows operating system (for setup.bat automation)

### Installation Steps

1. **Clone the repository:**
   ```bash
   git clone https://github.com/ArturSabanadze/webshop.git
   cd webshop
   ```

2. **Install XAMPP:**
   - Download and install XAMPP from https://www.apachefriends.org/
   - Install to default location: `C:\xampp`

3. **Configure MySQL:**
   - Start Apache and MySQL from XAMPP Control Panel
   - Ensure MySQL has no password (default), or update credentials in:
     - `Backend/config/.env`
     - `setup.bat`

4. **Automated Setup:**
   - Run `setup.bat` to:
     - Copy project files to XAMPP htdocs
     - Create database schema
     - Import test data
     - Configure environment

5. **Access the Application:**
   - Frontend: `http://localhost/Die_Fantastische_4/Frontend/public/index.php`
   - Admin Dashboard: `http://localhost/Die_Fantastische_4/Frontend/public/AdminDashboard/private/admin_dashboard.php`

### Manual Database Setup (Alternative)

If automated setup doesn't work:

1. Connect to MySQL:
   ```bash
   mysql -u root
   ```

2. Execute SQL scripts:
   ```sql
   source Initializer/db_schema.sql;
   source Initializer/dummy_data.sql;
   ```

## 📁 Project Structure

```
webshop/
├── Backend/
│   ├── config/              # Environment configuration
│   ├── db_connection.php    # PDO database connection
│   ├── login_handler.php    # Login authentication logic
│   └── register_handler.php # User registration logic
├── Frontend/
│   ├── public/              # Public web root
│   │   ├── AdminDashboard/  # Admin interface
│   │   ├── assets/          # Images, CSS, JS
│   │   └── index.php        # Main entry point
│   └── src/
│       ├── Controllers/     # Request handlers
│       ├── Functions/       # Business logic
│       └── Includes/        # Page components
├── Initializer/
│   ├── db_schema.sql        # Database schema
│   └── Dummy/               # Test data
├── Documentation/
│   ├── index.html           # Project documentation
│   └── Anleitung.txt        # Setup instructions
├── setup.bat                # Automated setup script
└── Readme.MD                # This file
```

## 🔧 Technologies Used

- **Backend**: PHP 7+
- **Database**: MySQL with PDO
- **Frontend**: HTML5, CSS3, JavaScript
- **Server**: Apache (XAMPP)
- **Architecture**: MVC-inspired pattern with separation of concerns

## 🔒 Security Features

- Password hashing using PHP's password_hash()
- SQL injection protection via PDO prepared statements
- Session-based authentication
- Role-based access control
- Input validation and sanitization
- CSRF protection for forms

## 👥 Team

- **Dominik Kraft** - Database Engineer
- **Artur Sabanadze** - Full-Stack Developer
- **Tobias Heinrich Dyck** - Backend Developer
- **Marcel Czichy** - Frontend Developer

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🤝 Contributing

This is an educational project developed as part of a web development course. Feel free to fork and experiment with the code.

## 📧 Support

For questions or issues:
- Check the Documentation folder for detailed guides
- Review the Anleitung.txt for setup troubleshooting
- Contact through the webshop contact form

---

**Note**: This is a demonstration project for educational purposes. Ensure proper security measures are implemented before deploying to production.