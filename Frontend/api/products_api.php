<?php
require_once '../../Backend/api/products.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'fetch_products') {
    try{
    $search = $_GET['search'] ?? '';
    $category = $_GET['category'] ?? '';
    $sort = $_GET['sort'] ?? 'newest';

    $products = getProducts($search, $category, $sort);
    header('Content-Type: application/json');
    echo json_encode($products);
}
catch (Exception $e) {
        $_SESSION['login_error'] = 'An error occurred during product retrieval. Please try again later.';
}
}