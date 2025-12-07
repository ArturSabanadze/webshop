<?php 
    include_once __DIR__ . '/../Functions/card_loader.php';
$products = getAllProducts();
?>

<!-- MAIN SECTION -->
<section class="main-container">
    <div class="courses-header">
        <h2>Explore Our Courses</h2>
        <p>Choose from a wide range of expertly crafted online courses.</p>
    </div>

    <div class="courses-grid">
    <?php if (!empty($products)): ?>
        <?php foreach ($products as $row): ?>
            <?= generateProductCard($row); ?>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No courses available at the moment.</p>
    <?php endif; ?>
</div>
</div>
</section>
