<?php

require_once '../../../../../Backend/db_connection.php';

//Return the count of registrations, optionally filtered by date range
function count_registration($from_date = null, $to_date = null): string
{
    global $pdo;

    if (!$from_date || !$to_date) {
        $stmt = $pdo->prepare("SELECT COUNT(*) AS count FROM seminar_registrations");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] ?? '0';
    }

    $stmt = $pdo->prepare("SELECT COUNT(*) AS count FROM seminar_registrations WHERE registration_datetime BETWEEN ? AND ?");
    $stmt->execute([$from_date, $to_date]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['count'] ?? '0';
}

//test the function
/* echo count_registration('2024-01-01', '2026-12-31'); */