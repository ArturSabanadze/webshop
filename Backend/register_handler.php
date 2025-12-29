<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect if logged in
if (isset($_SESSION['token'])) {
    $_SESSION['flash_message'] = 'You are logged in. Please logout before registering.';
    header('Location: index.php');
    exit;
}

require_once __DIR__ . '/db_connection.php'; // gives you $pdo (PDO)

$namePattern = '/^[a-zA-Z\s-]+$/';
$usernamePattern = '/^[a-zA-Z0-9\s-]+$/';

$_SESSION['register_error'] = '';
$_SESSION['register_success_message'] = '';
$_SESSION['register_success'] = false;


if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'register') {

    //users fields
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);

    //users_adresses fields
    $country = trim($_POST['country'] ?? '');
    $zip_code = trim($_POST['zip_code'] ?? '');
    $street = trim($_POST['street'] ?? '');
    
    // users_profile fields
    $name = trim($_POST['name'] ?? '');
    $surname = trim($_POST['surname'] ?? '');
    $biography = trim($_POST['biography'] ?? '');
    $profile_img_url = trim($_POST['profile_img_url'] ?? '');
    $gender = trim($_POST['gender'] ?? '');
    $birthdate = $_POST['birthdate'] ?? '';
    $phone = trim($_POST['phone'] ?? '');

    // Validation
    if (!$name || !$surname || !$username || !$password || !$email) {
        $_SESSION['register_error'] = 'Name, surname, username, password, and email are required.';
    } elseif (!preg_match($namePattern, $name)) {
        $_SESSION['register_error'] = 'Name contains invalid characters.';
    } elseif (!preg_match($namePattern, $surname)) {
        $_SESSION['register_error'] = 'Surname contains invalid characters.';
    } elseif (!preg_match($usernamePattern, $username)) {
        $_SESSION['register_error'] = 'Username contains invalid characters.';
    } else {

        try {
            // Check duplicates
            $stmt = $pdo->prepare("SELECT id FROM users WHERE username = :u OR email = :e LIMIT 1");
            $stmt->execute([':u' => $username, ':e' => $email]);

            if ($stmt->fetch()) {
                $_SESSION['register_error'] = 'Username or email already exists.';
            } else {
                // Hash password
                $hash = password_hash($password, PASSWORD_DEFAULT);

                // Insert new user
                $insert = $pdo->prepare("
                    INSERT INTO users 
                    (username, password_hash, name, surname, email, gender, birthdate, country, zip_code, street, phone)
                    VALUES (:username, :hash, :name, :surname, :email, :gender, :birthdate, :country, :zip_code, :street, :phone)
                ");

                $insert->execute([
                    ':username' => $username,
                    ':hash' => $hash,
                    ':name' => $name,
                    ':surname' => $surname,
                    ':email' => $email,
                    ':gender' => $gender,
                    ':birthdate' => $birthdate,
                    ':country' => $country,
                    ':postal_index' => $postal_index,
                    ':street' => $street,
                    ':phone' => $phone
                ]);

                $_SESSION['register_success_message'] = 'Registration successful! You can now log in.';
                $_SESSION['register_success'] = true;

                // Clear form
                $name = $surname = $username = $email = $gender = $birthdate =
                    $country = $postal_index = $street = $phone = '';
            }

        } catch (PDOException $e) {
            $_SESSION['register_error'] = 'Database error. Please try again later.';
        }
    }
}
