<?php
// DB-Zugangsdaten
$host = "localhost";
$dbname = "webshop";
$user = "root";
$pass = "";

$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

try {
    $pdo = new PDO(
        $dsn,
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Fehler als Exceptions
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Standard Fetch
            PDO::ATTR_PERSISTENT => false                 // keine persistente Verbindung
        ]
    );
} catch (PDOException $e) {
    die("DB-Verbindung fehlgeschlagen: " . $e->getMessage());
}