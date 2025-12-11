<?php
session_start();
require_once __DIR__ . '/../src/Functions/product_card_loader.php';

header('Content-Type: application/json');

$userId = (int) ($_SESSION['user_id'] ?? 0);
$seminarDateId = (int) ($_POST['seminar_date_id'] ?? 0);

if (!$userId) {
    echo json_encode(['error' => 'You must be logged in']);
    exit;
}

if (!$seminarDateId) {
    echo json_encode(['error' => 'Invalid seminar selection']);
    exit;
}

global $pdo;

// Check if already enrolled
$stmt = $pdo->prepare("SELECT COUNT(*) FROM seminar_registrations WHERE user_id = ? AND seminar_date_id = ?");
$stmt->execute([$userId, $seminarDateId]);

if ($stmt->fetchColumn() > 0) {
    echo json_encode(['error' => 'You are already enrolled in this seminar']);
    exit;
}

// Check for overlapping seminar dates
$overlapQuery = "
    SELECT COUNT(*) 
    FROM seminar_registrations sr
    JOIN seminar_dates sd_existing ON sr.seminar_date_id = sd_existing.id
    JOIN seminar_dates sd_new ON sd_new.id = ?
    WHERE sr.user_id = ?
    AND (
        sd_existing.start_datetime < sd_new.end_datetime
        AND sd_existing.end_datetime > sd_new.start_datetime
    )
";

$stmt = $pdo->prepare($overlapQuery);
$stmt->execute([$seminarDateId, $userId]);
$overlapCount = $stmt->fetchColumn();

if ($overlapCount > 0) {
    echo json_encode(['error' => 'You are already registered for another seminar that overlaps in time.']);
    exit;
}

// Enroll user
$stmt = $pdo->prepare("INSERT INTO seminar_registrations (user_id, seminar_date_id) VALUES (?, ?)");
$stmt->execute([$userId, $seminarDateId]);

echo json_encode(['success' => 'Successfully enrolled!']);
