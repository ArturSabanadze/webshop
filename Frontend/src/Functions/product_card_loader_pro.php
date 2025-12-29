<?php
require_once '../../Backend/db_connection.php';

function getAllProducts(): array
{
    global $pdo;

    $stmt = $pdo->query("SELECT * FROM products ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getFilteredProducts(string $search = '', string $category = '', string $sort = 'newest'): array
{
    global $pdo;

    $query = "SELECT p.* FROM products p
        LEFT JOIN product_categories pc ON p.id = pc.product_id
        LEFT JOIN categories c ON c.id = pc.category_id
        WHERE 1";
    $params = [];

    if (!empty($search)) {
        $query .= " AND (p.product_name LIKE ? OR p.description LIKE ?)";
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

function generateProductCard(array $row): string
{
    $productId = (int) $row['id'];
    $duration = (!empty($row['start_date']) && !empty($row['end_date']))
        ? (new DateTime($row['start_date']))->diff(new DateTime($row['end_date']))->days . " days"
        : "Flexible";
    $excerpt = mb_substr($row['description'], 0, 100) . (mb_strlen($row['description']) > 100 ? "..." : "");
    $status = $row['status'] === 'active' ? 'Available' : 'Unavailable';
    return '
    <div class="course-card">
        <img src="' . htmlspecialchars($row['image_url'] ?? '') . '" alt="Course thumbnail">
        <div class="course-info">
            <h3 class="course-title">' . htmlspecialchars($row['title']) . '</h3>
            <p class="course-desc">' . htmlspecialchars($excerpt) . '</p>
            <div class="course-meta">
                <span>€ ' . number_format($row['price'], 2) . '</span>
                <span>' . $duration . '</span> 
            </div>
            <span class="course-status ' . ($row['status'] === 'active' ? 'active' : 'inactive') . '">' . $status . '</span>
            <button class="course-btn" data-id="' . $productId . '">Enroll</button>
        </div>
    </div>';
}

function getSeminarDates(int $productId): array
{
    global $pdo;
    $stmt = $pdo->prepare("
        SELECT product_id, start_date, end_date
        FROM live_seminars
        WHERE product_id = ?
        ORDER BY start_date ASC
    ");
    $stmt->execute([$productId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function enrollInSeminar(int $userId, int $seminarDateId): string
{
    global $pdo;

    if (!$userId)
        return "You must be logged in.";
    if (!$seminarDateId)
        return "Invalid seminar selection.";

    // Already enrolled check
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM seminar_registrations WHERE user_id = ? AND seminar_date_id = ?");
    $stmt->execute([$userId, $seminarDateId]);
    if ($stmt->fetchColumn() > 0)
        return "You are already enrolled in this seminar.";

    // Enroll
    $stmt = $pdo->prepare("INSERT INTO seminar_registrations (user_id, seminar_date_id) VALUES (?, ?)");
    $stmt->execute([$userId, $seminarDateId]);

    return "Successfully enrolled!";
}
