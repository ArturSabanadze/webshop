<?php
require_once __DIR__ . '/db_connection.php'; //Tobis Backend - enthält global $pdo

// User Login POST-Anfragen bearbeiten
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'login') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // Eingabefelder validieren
    if (!$username || !$password) {
        $_SESSION['login_error'] = 'Please enter both username and password.';
    }

    try {
        // Benutzer aus der Datenbank abrufen
        $stmt = $pdo->prepare("SELECT id, username, password_hash, name, surname, gender, birthdate, 
        email, country, postal_index, street, phone, created_at, updated_at, is_active, role  
                               FROM users WHERE username = :username LIMIT 1");
        // Benutzer anhand des Benutzernamens abrufen                       
        $stmt->execute([':username' => $username]);
        // Fetch the user data
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Überprüfen, ob der Benutzer existiert und das Passwort korrekt ist und erstelle Session
        if ($user) {
            if (password_verify($password, $user['password_hash'])) {
                // Erfolgreicher Login = Session token und Benutzerdaten setzen
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
                echo "<script>window.location.href = 'index.php?page=home';</script>";
            } else {
                // Ungültiges Passwort message
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

// Admin-Login POST-Anfragen bearbeiten
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'admin-login') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // Eingabefelder validieren
    if (!$username || !$password) {
        $_SESSION['login_error'] = 'Please enter both username and password.';
    }

    try {
        // Benutzer aus der Datenbank abrufen
        $stmt = $pdo->prepare("SELECT id, username, password_hash, name, surname, 
        email, created_at, updated_at, role FROM admins WHERE username = :username LIMIT 1");
        // Benutzer anhand des Benutzernamens abrufen                       
        $stmt->execute([':username' => $username]);
        // Fetch the user data
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Überprüfen, ob der Benutzer existiert und das Passwort korrekt ist und erstelle Session
        if ($user) {
            if (password_verify($password, $user['password_hash'])) {
                // Erfolgreicher Login = Session token und Benutzerdaten setzen
                $token = bin2hex(random_bytes(16));
                $_SESSION['token'] = $token;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['surname'] = $user['surname'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['login_success'] = 'Login successful! Hello, ' . $user['name'] . ' ' . $user['surname'] . '.';
                header('Location: admin_dashboard.php?page=home');

            } else {
                // Ungültiges Passwort message
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
