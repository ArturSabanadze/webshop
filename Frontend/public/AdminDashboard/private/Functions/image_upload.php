<?php

function handleImageUpload(): ?string
{
    if (!isset($_FILES['product_image']) || $_FILES['product_image']['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }

    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {

        $uploadDir = __DIR__ . '/../../../assets/product_images/';
        if (!is_dir($uploadDir)) {
            $_SESSION['img_upload_error'] = 'Failed to create upload directory.';
            echo 'Failed to create upload directory.';
            return null;
        }

        $fileTmpPath = $_FILES['product_image']['tmp_name'];
        $fileName = $_FILES['product_image']['name'];
        $fileSize = $_FILES['product_image']['size'];
        $fileType = mime_content_type($fileTmpPath);

        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];

        if (!in_array($fileType, $allowedTypes)) {
            $_SESSION['img_upload_error'] = 'Invalid image format.';
            return null;
        }

        if ($fileSize > 2 * 1024 * 1024) { // 2MB
            $_SESSION['img_upload_error'] = 'Product image too large (max 2MB).';
            return null;
        }

        $extension = pathinfo($fileName, PATHINFO_EXTENSION);
        $newFileName = uniqid('product_', true) . '.' . $extension;

        $destination = $uploadDir . $newFileName;

        if (move_uploaded_file($fileTmpPath, $destination)) {
            // Save relative path in DB
            $product_image_url = '../../../assets/product_images/' . $newFileName;
        } else {
            $_SESSION['img_upload_error'] = 'Failed to upload product image.';
            return null;
        }
    } else {
        $product_image_url = null; // optional image 
    }
    return $product_image_url;
}