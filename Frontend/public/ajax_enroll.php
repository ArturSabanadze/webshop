<?php
session_start();
require_once __DIR__ . '/../src/Functions/product_card_loader_pro.php';

header('Content-Type: application/json');

$userId = (int) ($_SESSION['user_id'] ?? 0);
$seminarDateId = (int) ($_POST['seminar_id'] ?? 0);

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
$stmt = $pdo->prepare("SELECT COUNT(*) FROM seminar_participants WHERE user_id = ? AND seminar_id = ?");
$stmt->execute([$userId, $seminarDateId]);

// Prepare log entry as array
$entry = [
    'user_id' => $userId,
    'seminar_id' => $seminarDateId,
    'timestamp' => date('Y-m-d H:i:s')
];

// Prepare serialized log entry
$serialized = serialize($entry) . PHP_EOL;

if ($stmt->fetchColumn() > 0) {
    echo json_encode(['error' => 'You are already enrolled in this seminar']);
    exit;
}

// Check max participant capacity
$capacityQuery = "
    SELECT 
        ls.max_participants,
        COUNT(sp.id) AS current_participants
    FROM live_seminars ls
    LEFT JOIN seminar_participants sp 
        ON sp.seminar_id = ls.id
    WHERE ls.id = ?
    GROUP BY ls.max_participants
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
$stmt = $pdo->prepare("INSERT INTO seminar_participants (seminar_id, user_id) VALUES (?, ?)");
$stmt->execute([$seminarDateId, $userId]);

//speichere die Anmeldung in der Datei wenn es nicht schon existiert
file_put_contents($logFile, $serialized, FILE_APPEND);

echo json_encode(['success' => 'Successfully enrolled!']);
