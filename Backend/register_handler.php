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

    if (isset($_FILES['profile_img_url']) && $_FILES['profile_img_url']['error'] === UPLOAD_ERR_OK) {

        $uploadDir = '../public/assets/profile_images/';
        if (!is_dir($uploadDir)) {
            $_SESSION['register_error'] = 'Failed to create upload directory.';
            return;
        }
        

        $fileTmpPath = $_FILES['profile_img_url']['tmp_name'];
        $fileName = $_FILES['profile_img_url']['name'];
        $fileSize = $_FILES['profile_img_url']['size'];
        $fileType = mime_content_type($fileTmpPath);

        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];

        if (!in_array($fileType, $allowedTypes)) {
            $_SESSION['register_error'] = 'Invalid image format.';
            return;
        }

        if ($fileSize > 2 * 1024 * 1024) { // 2MB
            $_SESSION['register_error'] = 'Profile image too large (max 2MB).';
            return;
        }

        $extension = pathinfo($fileName, PATHINFO_EXTENSION);
        $newFileName = uniqid('profile_', true) . '.' . $extension;

        $destination = $uploadDir . $newFileName;

        if (move_uploaded_file($fileTmpPath, $destination)) {
            // Save relative path in DB
            $profile_img_url = '/assets/profile_images/' . $newFileName;
        } else {
            $_SESSION['register_error'] = 'Failed to upload profile image.';
            return;
        }
    } else {
        $profile_img_url = null; // optional image
    }

    //users fields new datenbank
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);

    //users_adresses fields
    $country = trim($_POST['country'] ?? '');
    $zip_code = trim($_POST['zip_code'] ?? '');
    $street = trim($_POST['street'] ?? '');
    $street_number = trim($_POST['street_number'] ?? '');
    $state = trim($_POST['state'] ?? '');
    $province = trim($_POST['province'] ?? '');
    
    // users_profile fields
    $name = trim($_POST['name'] ?? '');
    $surname = trim($_POST['surname'] ?? '');
    $biography = trim($_POST['biography'] ?? '');
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
                    (username, password_hash, email)
                    VALUES (:username, :hash, :email);

                    INSERT INTO users_profiles ( user_id, name, surname, biography, profile_img_url, gender, phone, birthdate)
                    VALUES (LAST_INSERT_ID(), :name, :surname, :biography, :profile_img_url, :gender, :phone, :birthdate);

                    INSERT INTO users_addresses (user_id, country, zip_code, street, street_number, state, province)
                    VALUES (LAST_INSERT_ID(), :country, :zip_code, :street, :street_number, :state, :province);
                ");

                $insert->execute([
                    ':username' => $username,
                    ':email' => $email,
                    ':hash' => $hash,
                    ':name' => $name,
                    ':surname' => $surname,
                    ':biography' => $biography,
                    ':profile_img_url' => $profile_img_url,
                    ':gender' => $gender,
                    ':birthdate' => $birthdate,
                    ':country' => $country,
                    ':zip_code' => $zip_code,
                    ':street' => $street,
                    ':street_number' => $street_number,
                    ':state' => $state,
                    ':province' => $province,
                    ':phone' => $phone
                ]);

                $_SESSION['register_success_message'] = 'Registration successful! You can now log in.';
                $_SESSION['register_success'] = true;

                // Clear form
                $name = $surname = $username = $email = $gender = $birthdate =
                    $country = $postal_index = $street = $phone = '';
            }

        } catch (PDOException $e) {
            $_SESSION['register_error'] = 'Database error. Please try again later.' . $e->getMessage();
        }
    }
}
