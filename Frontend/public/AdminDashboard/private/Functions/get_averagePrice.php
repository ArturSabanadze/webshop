<?php

require_once '../../../../../Backend/db_connection.php';

//Return the count of preoducts, optionally filtered by date range
function get_averagePrice(): string
{
    global $pdo;

    $stmt = $pdo->prepare("SELECT AVG(price) AS average_price FROM products");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return number_format($result['average_price'], 2) . ' €' ?? '0 €';

}

//test the function
echo get_averagePrice();