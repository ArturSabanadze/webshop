<?php
require_once __DIR__ . '/../db_connection.php';


function getCategories(): array
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT id, category_name FROM categories ORDER BY category_name ASC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC); // returns an array of categories
}

// ===== FETCH PRODUCTS =====
function getProducts(string $search = '', string $category = '', string $sort = 'newest'): array
{
    global $pdo;

    $query = "SELECT p.* FROM products p
              LEFT JOIN product_categories pc ON p.id = pc.product_id
              LEFT JOIN categories c ON c.id = pc.category_id
              WHERE p.status = 'active'";

    $params = [];

    if (!empty($search)) {
        $query .= " AND (p.title LIKE ? OR p.description LIKE ?)";
        $params[] = "%$search%";
        $params[] = "%$search%";
    }

    if (!empty($category)) {
        $query .= " AND c.category_name = ?";
        $params[] = $category;
    }

    switch ($sort) {
        case 'price-low':
            $query .= " ORDER BY p.price ASC";
            break;
        case 'price-high':
            $query .= " ORDER BY p.price DESC";
            break;
        default:
            $query .= " ORDER BY p.created_at DESC";
            break;
    }

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}




