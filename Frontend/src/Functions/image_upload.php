<?php

function handleImageUpload(): ?string
{
    if (isset($_FILES['profile_img_url']) && $_FILES['profile_img_url']['error'] === UPLOAD_ERR_OK) {

        $uploadDir = '../public/assets/profile_images/';
        if (!is_dir($uploadDir)) {
            $_SESSION['register_error'] = 'Failed to create upload directory.';
            return null;
        }

        $fileTmpPath = $_FILES['profile_img_url']['tmp_name'];
        $fileName = $_FILES['profile_img_url']['name'];
        $fileSize = $_FILES['profile_img_url']['size'];
        $fileType = mime_content_type($fileTmpPath);

        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];

        if (!in_array($fileType, $allowedTypes)) {
            $_SESSION['register_error'] = 'Invalid image format.';
            return null;
        }

        if ($fileSize > 2 * 1024 * 1024) { // 2MB
            $_SESSION['register_error'] = 'Profile image too large (max 2MB).';
            return null;
        }

        $extension = pathinfo($fileName, PATHINFO_EXTENSION);
        $newFileName = uniqid('profile_', true) . '.' . $extension;

        $destination = $uploadDir . $newFileName;

        if (move_uploaded_file($fileTmpPath, $destination)) {
            // Save relative path in DB
            $profile_img_url = '/assets/profile_images/' . $newFileName;
        } else {
            $_SESSION['register_error'] = 'Failed to upload profile image.';
            return null;
        }
    } else {
        $profile_img_url = null; // optional image 
    }
    return $profile_img_url;
}