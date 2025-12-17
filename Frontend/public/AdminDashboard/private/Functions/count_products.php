<?php

require_once '../../../../../Backend/db_connection.php';

//Return the count of preoducts, optionally filtered by date range
function count_products($start_date = null, $end_date = null): string
{
    global $pdo;

    if (!$start_date || !$end_date) {
        $stmt = $pdo->prepare("SELECT COUNT(*) AS count FROM products");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] ?? '0';
    }

    $stmt = $pdo->prepare("SELECT COUNT(*) AS count FROM products WHERE start_date >= ? AND end_date <= ?");
    $stmt->execute([$start_date, $end_date]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['count'] ?? '0';
}

//test the function
/* echo count_seminars();
echo count_products('2024-01-01', '2025-07-15'); */