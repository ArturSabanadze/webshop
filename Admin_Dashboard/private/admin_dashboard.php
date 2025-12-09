<?php
session_start();

// Nur Admin-Benutzer zulassen
if (empty($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header('Location: /Backend/admin_login.php');
    exit;
}

// Datenbankverbindung einbinden
require_once __DIR__ . '/../../Backend/db_connection.php';

// Seite bestimmen
$page = $_GET['page'] ?? 'home';
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Admin-Dashboard</title>
    <link rel="stylesheet" href="/Admin_Dashboard/assets/admin.css">
</head>
<body>
<header class="admin-header">
    <h1>Admin-Dashboard</h1>
    <nav class="admin-nav">
        <a href="admin_dashboard.php?page=home">Übersicht</a>
        <a href="admin_dashboard.php?page=seminars">Seminare</a>
        <a href="admin_dashboard.php?page=dates">Termine</a>
        <a href="admin_dashboard.php?page=participants">Teilnehmer</a>
        <a href="/Backend/admin_logout.php">Logout</a>
    </nav>
</header>

<main class="admin-main">
    <?php
    switch ($page) {
        case 'seminars':
            require __DIR__ . '/seminars.php';
            break;
        case 'dates':
            require __DIR__ . '/seminar_dates.php';
            break;
        case 'participants':
            require __DIR__ . '/participants.php';
            break;
        default:
            ?>
            <section>
                <h2>Willkommen im Admin-Dashboard</h2>
                <p>Wählen Sie eine Funktion in der Navigation aus, um Seminare, Termine oder Teilnehmer zu verwalten.</p>
            </section>
            <?php
            break;
    }
    ?>
</main>
</body>
</html>
