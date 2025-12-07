<?php 
require_once __DIR__ . '/../../../Backend/db_connection.php'; //Tobi's Datenbank verbindung code
require_once 'htmlscpecialchars_short.php'; //hsc(column_name);

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
        $end   = new DateTime($row['end_date']);
        $duration = $start->diff($end)->days . " days";
    } else {
        $duration = "Flexible";
    }

    $hsc = '';

    // HTML als String zurückgeben
    return '
        <div class="course-card">
            <img src="' . hsc($row, 'image') . '" alt="Course thumbnail">

            <div class="course-info">
                <h3 class="course-title">' . hsc($row, 'product_name') . '</h3>

                <p class="course-desc">' . hsc($row, 'description') . '</p>

                <div class="course-meta">
                    <span>€ ' . number_format($row['price'], 2) . '</span>
                    <span>' . $duration . '</span>
                </div>

                <button class="course-btn">View Details</button>
            </div>
        </div>
    ';
}