<?php
// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Redirect if logged in
if (isset($_SESSION['token'])) {
    $_SESSION['flash_message'] = 'You are logged in. Please logout before registering.';
    header('Location: index.php');
    exit;
}
// Include necessary files
require_once __DIR__ . '/db_connection.php'; // gives you global $pdo (PDO)
require_once __DIR__ . '/../Frontend/src/Classes/User.php'; // User class
require_once __DIR__ . '/../Frontend/src/Classes/UserAddress.php'; // UserAddress class
require_once __DIR__ . '/../Frontend/src/Classes/UserProfile.php'; // UserProfile class
require_once __DIR__ . '/../Frontend/src/Functions/image_upload.php'; // image upload function
// Validation patterns
$namePattern = '/^[a-zA-Z\s-]+$/';
$usernamePattern = '/^[a-zA-Z0-9\s-]+$/';
// Initialize session messages
$_SESSION['register_error'] = '';
$_SESSION['register_success_message'] = '';
$_SESSION['register_success'] = false;
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'register') {
    // Handle image upload
    $profile_img_url = handleImageUpload();
    //users table fields and his object
    $user_data = [
        'username' => trim($_POST['username'] ?? ''),
        'plain_password' => $_POST['password'] ?? '',
        'email' => trim($_POST['email'] ?? '')
    ];
    //users_adresses fields
    $address_data = [
        'type' => trim($_POST['type'] ?? ''),
        'country' => trim($_POST['country'] ?? ''),
        'zip_code' => trim($_POST['zip_code'] ?? ''),
        'street' => trim($_POST['street'] ?? ''),
        'street_number' => trim($_POST['street_number'] ?? ''),
        'state' => trim($_POST['state'] ?? ''),
        'province' => trim($_POST['province'] ?? '')
    ];  
    // users_profile fields
    $profile_data = [
        'name' => trim($_POST['name'] ?? ''),
        'surname' => trim($_POST['surname'] ?? ''),
        'biography' => trim($_POST['biography'] ?? ''),
        'gender' => trim($_POST['gender'] ?? ''),
        'birthdate' => $_POST['birthdate'] ?? '',
        'phone' => trim($_POST['phone'] ?? ''),
        'profile_img_url' => $profile_img_url ?? null,
    ];
    // POST Validation
    if ($user_data['username'] === '' /* || !$profile_data['surname'] || !$user_data['username'] || !$user_data['password'] || !$user_data['email'] */) {
        $_SESSION['register_error'] = 'Name are required.';
        return;
    } elseif (!preg_match($namePattern, $profile_data['name'])) {
        $_SESSION['register_error'] = 'Name contains invalid characters.';
    } elseif (!preg_match($namePattern, $profile_data['surname'])) {
        $_SESSION['register_error'] = 'Surname contains invalid characters.';
    } elseif (!preg_match($usernamePattern, $user_data['username'])) {
        $_SESSION['register_error'] = 'Username contains invalid characters.';
    } else {

        try {
            // Create instances of user, address, and profile
                $user = new User($user_data);
                
            // Check if user exists
            if ($user->exist($pdo)) {
                $_SESSION['register_error'] = 'Username or email already exists.';
                return;
            } else {
                // Save to DB
                $user->save($pdo);
                $userAddress = new UserAddress($address_data, $user->getId());
                $userAddress->save($pdo);
                $userProfile = new UserProfile($profile_data, $user->getId());
                $userProfile->save($pdo);
                // set success message
                $_SESSION['register_success_message'] = 'Registration successful! You can now log in.';
                $_SESSION['register_success'] = true;
                // Clear form
                $user_data = $address_data = $profile_data = [];
            }
        } catch (PDOException $e) {
            $_SESSION['register_error'] = 'Database error. Please try again later.' . $e->getMessage();
        }
    }
}
