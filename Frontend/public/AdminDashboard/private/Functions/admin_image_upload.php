<?php
function handleImageUpload(string $uploadDir, string $uploadUrlBase, ?string $oldImage = null): string
{
    if (empty($_FILES['image_file']['name'])) {
        return $oldImage ?? '';
    }

    if ($_FILES['image_file']['error'] !== UPLOAD_ERR_OK) {
        die('<p style="color:red;">Upload fehlgeschlagen</p>');
    }

    if ($_FILES['image_file']['size'] > 1024 * 1024) {
        die('<p style="color:red;">Bild darf maximal 1 MB groß sein</p>');
    }

    $info = getimagesize($_FILES['image_file']['tmp_name']);
    if ($info === false) {
        die('<p style="color:red;">Datei ist kein gültiges Bild</p>');
    }

    $allowed = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
        'image/gif' => 'gif'
    ];

    if (!isset($allowed[$info['mime']])) {
        die('<p style="color:red;">Nur JPG, PNG, WEBP oder GIF erlaubt</p>');
    }

    $filename = uniqid('product_', true) . '.' . $allowed[$info['mime']];

    if (!move_uploaded_file($_FILES['image_file']['tmp_name'], $uploadDir . $filename)) {
        die('<p style="color:red;">Datei konnte nicht gespeichert werden</p>');
    }

    if ($oldImage) {
        @unlink($uploadDir . basename($oldImage));
    }

    return $uploadUrlBase . $filename;
}