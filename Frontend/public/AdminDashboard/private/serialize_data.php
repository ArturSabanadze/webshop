<?php
// Admin: Benutzer- und Seminar-Daten serialisieren

require_once __DIR__ . '/../../Backend/db_connection.php';

// Benutzer laden
$stmtUsers = $pdo->query("SELECT id, username, email FROM users");
$users = $stmtUsers->fetchAll(PDO::FETCH_ASSOC);

// Seminare laden
$stmtSeminars = $pdo->query("SELECT id, product_name, price FROM products");
$seminars = $stmtSeminars->fetchAll(PDO::FETCH_ASSOC);

// Serialisieren
$serializedUsers = serialize($users);
$serializedSeminars = serialize($seminars);

// Dateien im Admin-Bereich ablegen
$exportDir = __DIR__ . '/../exports';
if (!is_dir($exportDir)) {
    mkdir($exportDir, 0777, true);
}

file_put_contents($exportDir . '/users.serialized', $serializedUsers);
file_put_contents($exportDir . '/seminars.serialized', $serializedSeminars);

echo "<p>Serialisierte Daten wurden erzeugt.</p>";
