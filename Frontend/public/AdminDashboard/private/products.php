<?php
require __DIR__ . '/Classes/Product_P.php';
require __DIR__ . '/Classes/Product_L.php';
require __DIR__ . '/Classes/Product_D.php';

$type = $_GET['type'] ?? 'physical';


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $p_product = new Product_P([]);
    $d_product = new Product_D([]);
    $l_product = new Product_L([]);

    $product_list = [];

    switch ($type) {
        case 'physical':
            $product_list = $p_product->read($pdo);
            break;

        case 'live':
            $product_list = $l_product->read($pdo);
            break;

        case 'digital':
        default:
            $product_list = $d_product->read($pdo);
            break;
    }
}
?>

<h2>Product Management - <?php echo ucfirst($type); ?> Products</h2>
<?php
switch ($type) {
    case 'physical':
        echo $p_product->listAll($product_list);
        break;
    case 'live':
        echo $l_product->listAll($product_list);
        break;
    case 'digital':
    default:
        echo $d_product->listAll($product_list);
        break;
}
?>