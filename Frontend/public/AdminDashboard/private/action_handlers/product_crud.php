<?php

require __DIR__ . '/../Classes/Product_P.php';
require __DIR__ . '/../Classes/Product_L.php';
require __DIR__ . '/../Classes/Product_D.php';
require_once __DIR__ . '/../Functions/image_upload.php';

$type = $_GET['type'] ?? 'physical';


// ================================
// DELETE
// ================================
if (($_GET['action'] ?? '') === 'delete') {
    $page = $_GET['page'] ?? 'products';
    $type = $_GET['type'] ?? 'physical';
    $product_id = $_GET['id'] ?? null;

    if ($product_id) {
        switch ($type) {
            case 'physical':
                $p = new Product_P([]);
                break;
            case 'live':
                $p = new Product_L([]);
                break;
            case 'digital':
                $p = new Product_D([]);
                break;
            default:
                $p = null;
        }

        if ($p) {
            $p->setId($product_id);
            $p->delete($pdo);
        }
    }

    header("Location: ?page=$page&type=$type");
    exit;
}


// ================================
// UPDATE
// ================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'update-product') {

    $product_img_url = handleImageUpload();
    if ($product_img_url === null) {
        $product_img_url = $_POST['existing_image'];
    }

    $product_id = $_POST['product_id'];
    $product_type = $_POST['product_type'];

    switch ($product_type) {
        case 'physical':
            $p = new Product_P($_POST);
            break;
        case 'live':
            $p = new Product_L($_POST);
            break;
        case 'digital':
            $p = new Product_D($_POST);
            break;
        default:
            $p = null;
    }

    if ($p) {
        $p->setId($product_id);
        $p->setImgUrl($product_img_url);
        $p->update($pdo);
    }

    $page = $_GET['page'] ?? 'products';
    $type = $_GET['type'] ?? $product_type;

    header("Location: ?page=$page&type=$type");
    exit;
}


// ================================
// CREATE
// ================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'create-product') {

    $product_img_url = handleImageUpload();
    $product_type = $_POST['product_type'];

    switch ($product_type) {
        case 'physical':
            $p = new Product_P($_POST);
            break;
        case 'live':
            $p = new Product_L($_POST);
            break;
        case 'digital':
            $p = new Product_D($_POST);
            break;
        default:
            $p = null;
    }

    if ($p && $product_img_url !== null) {
        $p->setImgUrl($product_img_url);
    }

    if ($p) {
        $p->create($pdo);
    }

    header("Location: ?page=products&type=$product_type");
    exit;
}


// ================================
// READ (render page) — ALWAYS LAST
// ================================

$product_list = [];

switch ($type) {
    case 'physical':
        $p = new Product_P([]);
        $product_list = $p->read($pdo);
        echo $p->new_physical_product_form();
        echo $p->listAll($product_list);
        break;

    case 'live':
        $p = new Product_L([]);
        $product_list = $p->read($pdo);
        echo $p->new_live_product_form();
        echo $p->listAll($product_list);
        break;

    case 'digital':
    default:
        $p = new Product_D([]);
        $product_list = $p->read($pdo);
        echo $p->new_digital_product_form();
        echo $p->listAll($product_list);
        break;
}
