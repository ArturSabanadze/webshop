<h2>Product Management - <?php echo ucfirst($type); ?> Products</h2>
<?php

require __DIR__ . '/Classes/Product_P.php';
require __DIR__ . '/Classes/Product_L.php';
require __DIR__ . '/Classes/Product_D.php';
require_once __DIR__ . '/Functions/image_upload.php';

$type = $_GET['type'] ?? 'physical';
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $product_list = [];
    switch ($type) {
        case 'physical':
            $p_product = new Product_P([]);
            $product_list = $p_product->read($pdo);
            echo $p_product->new_physical_product_form();
            echo $p_product->listAll($product_list);
            break;
        case 'live':
            $l_product = new Product_L([]);
            $product_list = $l_product->read($pdo);
            echo $l_product->new_live_product_form();
            echo $l_product->listAll($product_list);
            break;
        case 'digital':
        default:
            $d_product = new Product_D([]);
            $product_list = $d_product->read($pdo);
            echo $d_product->new_digital_product_form();
            echo $d_product->listAll($product_list);
            break;
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'create-product') {
    $product_img_url = handleImageUpload();
    $product_data = $_POST;
    $product_type = $_POST['product_type'];
    switch ($product_type) {
        case 'physical':
            $new_p_product = new Product_P($product_data);
            if ($product_img_url !== null) {
                $new_p_product->setImgUrl($product_img_url);
            }
            $new_p_product->create($pdo);
            break;
        case 'live':
            $new_l_product = new Product_L($product_data);
            if ($product_img_url !== null) {
                $new_l_product->setImgUrl($product_img_url);
            }
            $new_l_product->create($pdo);
            break;
        case 'digital':
            $new_d_product = new Product_D($product_data);
            if ($product_img_url !== null) {
                $new_d_product->setImgUrl($product_img_url);
            }
            $new_d_product->create($pdo);
            break;
        default:
            break;
    }
    echo "<script>window.location.href = '" . $_SERVER['HTTP_REFERER'] . "';</script>";
}