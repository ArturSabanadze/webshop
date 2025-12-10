<?php
require_once __DIR__ . '/../../../Backend/db_connection.php'; //Tobi's Datenbank verbindung code

function getAllProducts()
{
    global $pdo;

    if (!$pdo) {
        throw new Exception("PDO connection missing.");
    }

    $stmt = $pdo->query("SELECT * FROM products");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function generateProductCard(array $row): string
{
    // Dauer berechnen
    if (!empty($row['start_date']) && !empty($row['end_date'])) {
        $start = new DateTime($row['start_date']);
        $end = new DateTime($row['end_date']);
        $duration = $start->diff($end)->days . " days";
    } else {
        $duration = "Flexible";
    }

    // HTML als String zurückgeben
    return '
        <div class="course-card">
            <img src="' . htmlspecialchars($row['image_url']) . '" alt="Course thumbnail">

            <div class="course-info">
                <h3 class="course-title">' . htmlspecialchars($row['product_name']) . '</h3>

                <p class="course-desc">' . htmlspecialchars($row['description']) . '</p>
            

                <div class="course-meta">
                    <span>€ ' . number_format($row['price'], 2) . '</span>
                    <span>' . $duration . '</span>
                </div>

                <button class="course-btn">View Details</button>
            </div>
        </div>
    ';
}

function getFilteredProducts($search = '', $category = '', $sort = 'newest')
{
    global $pdo;

    //Select all products and also join their categories (if they have any),
    //keeping products even if they have zero categories.
    //Start with WHERE 1 so we can add dynamic filters.
    $query = "SELECT p.* FROM products p
        LEFT JOIN products_categories pc ON p.id = pc.product_id
        LEFT JOIN categories c ON c.id = pc.category_id
        WHERE 1";

    $params = [];

    // Search
    if (!empty($search)) {
        $query .= " AND (p.product_name LIKE ? OR p.description LIKE ?)";
        $params[] = "%$search%";
        $params[] = "%$search%";
    }


    // Category
    if (!empty($category)) {
        $query .= " AND c.category_name = ?";
        $params[] = $category;
    }


    // Sorting
    switch ($sort) {
        case 'price-low':
            $query .= " ORDER BY p.price ASC";
            break;
        case 'price-high':
            $query .= " ORDER BY p.price DESC";
            break;
        case 'newest':
        default:
            $query .= " ORDER BY p.created_at DESC";
            break;
    }


    $stmt = $pdo->prepare($query);
    $stmt->execute($params);


    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}