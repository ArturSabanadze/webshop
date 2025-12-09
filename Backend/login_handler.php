<?php
require_once __DIR__ . '/db_connection.php'; //Tobis Backend - enthält global $pdo

// POST-Anfragen bearbeiten
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'login') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!$username || !$password) {
        $_SESSION['login_error'] = 'Please enter both username and password.';
    }

    try {
        $stmt = $pdo->prepare("SELECT id, username, password_hash, name, surname, gender, birthdate, 
        email, country, postal_index, street, phone, created_at, updated_at, is_active, role  
                               FROM users WHERE username = :username LIMIT 1");
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if (password_verify($password, $user['password_hash'])) {
                // Erfolgreicher Login
                $token = bin2hex(random_bytes(16));
                $_SESSION['token'] = $token;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['surname'] = $user['surname'];
                $_SESSION['gender'] = $user['gender'];
                $_SESSION['birthdate'] = $user['birthdate'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['country'] = $user['country'];
                $_SESSION['postal_index'] = $user['postal_index'];
                $_SESSION['street'] = $user['street'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['login_success'] = 'Login successful! Hello, ' . $user['name'] . ' ' . $user['surname'] . '.';
            } else {
                $_SESSION['login_error'] = 'Invalid username or password.';
            }
        } else {
            $_SESSION['login_error'] = 'User does not exist.';
        }
    } catch (PDOException $e) {
        // Optional: Fehler für Admin-Logging
        $_SESSION['login_error'] = 'Database error. Please try again later.';
    }

}
