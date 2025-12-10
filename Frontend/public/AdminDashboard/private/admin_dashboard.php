<?php
session_start();

$page = $_GET['page'] ?? 'home';

// Nur Admin-Benutzer zulassen, außer auf der Login-Seite
if ($page !== 'login' && (empty($_SESSION['role']) || $_SESSION['role'] !== 'admin')) {
    $_SESSION['login_error'] = 'You don’t have Admin rights.';
    header('Location: admin_dashboard.php?page=login');
    exit();
}

if ($page === 'login' && !empty($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    header('Location: admin_dashboard.php?page=home');
    exit();
}

// Datenbankverbindung einbinden
require_once '../../../../Backend/db_connection.php';

// Seite bestimmen
$page = $_GET['page'] ?? 'home';
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Admin-Dashboard</title>
    <link rel="stylesheet" href="../assets/admin.css">
</head>

<body>
    <header class="admin-header">
        <h1>Admin-Dashboard</h1>
        <nav class="admin-nav">
            <a href="admin_dashboard.php?page=home">Home</a>
            <a href="admin_dashboard.php?page=seminars">Seminare</a>
            <a href="admin_dashboard.php?page=dates">Termine</a>
            <a href="admin_dashboard.php?page=participants">Teilnehmer</a>
            <a href="admin_dashboard.php?page=tickets">Tickets</a>
            <a href="admin_dashboard.php?page=login">Login</a>
            <a href="/index.php?page=logout">Logout</a>
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
            case 'tickets':
                require __DIR__ . '/tickets.php';
                break;
            case 'login':
                require __DIR__ . '/admin_login.php';
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