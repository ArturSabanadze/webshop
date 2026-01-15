<!-- Title -->
<h2>Product Management -
    <?= ucfirst($_GET['type']) ?> Products
</h2>

<!-- Include the product CRUD action handler -->
<?php
include_once __DIR__ . '/action_handlers/product_crud.php';
?>