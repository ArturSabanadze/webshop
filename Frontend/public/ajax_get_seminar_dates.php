<?php
session_start();
require_once __DIR__ . '/../src/Functions/product_card_loader.php';

$productId = (int) ($_POST['product_id'] ?? 0);

header('Content-Type: application/json');

if (!$productId) {
    echo json_encode(['error' => 'Invalid product ID']);
    exit;
}

$dates = getSeminarDates($productId);
echo json_encode($dates);
