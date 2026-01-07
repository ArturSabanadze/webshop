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

require_once __DIR__ . '/db_connection.php'; // gives you global $pdo (PDO)
require_once __DIR__ . '/../Frontend/src/Classes/User.php';
require_once __DIR__ . '/../Frontend/src/Classes/UserAddress.php';
require_once __DIR__ . '/../Frontend/src/Classes/UserProfile.php';
require_once __DIR__ . '/../Frontend/src/Functions/image_upload.php';

$namePattern = '/^[a-zA-Z\s-]+$/';
$usernamePattern = '/^[a-zA-Z0-9\s-]+$/';

$_SESSION['register_error'] = '';
$_SESSION['register_success_message'] = '';
$_SESSION['register_success'] = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'register') {

    // Handle image upload
    $profile_img_url = handleImageUpload();

    //users table fields and his object
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $email = $_POST['email'] ?? '';
    $user = new User($username, $password, $email);

    //users_adresses fields
    $country = trim($_POST['country'] ?? '');
    $zip_code = trim($_POST['zip_code'] ?? '');
    $street = trim($_POST['street'] ?? '');
    $street_number = trim($_POST['street_number'] ?? '');
    $state = trim($_POST['state'] ?? '');
    $province = trim($_POST['province'] ?? '');
    $type = trim($_POST['type'] ?? '');
    $userAddress = new UserAddress(
        $user->getId(),
        $type,
        $street,
        $street_number,
        $state,
        $province,
        $country,
        $zip_code
    );
    
    // users_profile fields
    $name = trim($_POST['name'] ?? '');
    $surname = trim($_POST['surname'] ?? '');
    $biography = trim($_POST['biography'] ?? '');
    $gender = trim($_POST['gender'] ?? '');
    $birthdate = $_POST['birthdate'] ?? '';
    $phone = trim($_POST['phone'] ?? '');
    $userProfile = new UserProfile(
        $user->getId(),
        $name,
        $surname,
        $gender,
        $birthdate,
        $phone,
        $biography,
        $profile_img_url
    );

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
            // Check if user exists
            if ($user->exist($pdo)) {
                $_SESSION['register_error'] = 'Username or email already exists.';
            } else {
                $user->save($pdo);
                $userAddress->save($pdo);
                $userProfile->save($pdo);

                $_SESSION['register_success_message'] = 'Registration successful! You can now log in.';
                $_SESSION['register_success'] = true;

                // Clear form
                $password = $email = $name = $surname = $username = $gender = $birthdate = $profile_img_url =
                $country = $postal_index = $street = $street_number = $state = $province = $biography = $phone = '';
            }

        } catch (PDOException $e) {
            $_SESSION['register_error'] = 'Database error. Please try again later.' . $e->getMessage();
        }
    }
}
