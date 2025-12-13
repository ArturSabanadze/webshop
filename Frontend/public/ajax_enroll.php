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
$logFile = __DIR__ . "/../src/Data/enrollments.txt";

// Check if already enrolled
$stmt = $pdo->prepare("SELECT COUNT(*) FROM seminar_registrations WHERE user_id = ? AND seminar_date_id = ?");
$stmt->execute([$userId, $seminarDateId]);

// Prepare log entry as array
$entry = [
    'user_id' => $userId,
    'seminar_date_id' => $seminarDateId,
    'timestamp' => date('Y-m-d H:i:s')
];

// Prepare serialized log entry
$serialized = serialize($entry) . PHP_EOL;

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

// Check max participant capacity
$capacityQuery = "
    SELECT 
        sd.max_participants,
        COUNT(sr.id) AS current_participants
    FROM seminar_dates sd
    LEFT JOIN seminar_registrations sr 
        ON sr.seminar_date_id = sd.id
    WHERE sd.id = ?
    GROUP BY sd.max_participants
";

$stmt = $pdo->prepare($capacityQuery);
$stmt->execute([$seminarDateId]);
$capacity = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$capacity) {
    echo json_encode(['error' => 'Seminar not found']);
    exit;
}

if ($capacity['current_participants'] >= $capacity['max_participants']) {
    echo json_encode(['error' => 'This seminar is already fully booked']);
    exit;
}

// Enroll user, speichere die Anmeldung in der Datenbank
$stmt = $pdo->prepare("INSERT INTO seminar_registrations (user_id, seminar_date_id) VALUES (?, ?)");
$stmt->execute([$userId, $seminarDateId]);

//speichere die Anmeldung in der Datei wenn es nicht schon existiert
file_put_contents($logFile, $serialized, FILE_APPEND);

echo json_encode(['success' => 'Successfully enrolled!']);
