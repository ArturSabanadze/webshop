<?php

$storageFile = __DIR__ . '/../Data/messages.txt';
function saveContactMessage(string $name, string $email, string $message, ?string $caseId = null): string
{
    global $storageFile;

    // Load existing data or initialize empty array
    $data = file_exists($storageFile)
        ? unserialize(file_get_contents($storageFile))
        : [];

    // Generate case ID if new
    if ($caseId === null) {
        $caseId = 'case_' . substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZ23456789'), 0, 6);
    }

    // Ensure case container exists
    if (!isset($data[$caseId])) {
        $data[$caseId] = [
            'created_at' => date('Y-m-d H:i:s'),
            'messages' => []
        ];
    }

    // Add message entry
    $data[$caseId]['messages'][] = [
        'timestamp' => date('Y-m-d H:i:s'),
        'name' => $name,
        'email' => $email,
        'message' => $message
    ];

    // Save updated structure
    file_put_contents($storageFile, serialize($data));

    return $caseId;
}

function getMessagesByCaseId(string $caseId): ?array
{
    global $storageFile;

    if (!file_exists($storageFile)) {
        return null;
    }

    $data = unserialize(file_get_contents($storageFile));

    return $data[$caseId] ?? null;
}
