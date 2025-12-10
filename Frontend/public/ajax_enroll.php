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

// Check if already enrolled
global $pdo;
$stmt = $pdo->prepare("SELECT COUNT(*) FROM seminar_registrations WHERE user_id = ? AND seminar_date_id = ?");
$stmt->execute([$userId, $seminarDateId]);

if ($stmt->fetchColumn() > 0) {
    echo json_encode(['error' => 'You are already enrolled in this seminar']);
    exit;
}

// Enroll
$stmt = $pdo->prepare("INSERT INTO seminar_registrations (user_id, seminar_date_id) VALUES (?, ?)");
$stmt->execute([$userId, $seminarDateId]);

echo json_encode(['success' => 'Successfully enrolled!']);
