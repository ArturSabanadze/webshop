<!-- MAIN SECTION -->
<?php
$path = '../src/Functions/product_card_loader.php';
if (file_exists($path)) {
    require_once $path;
} else {
    die('Required file product_card_loader.php not found.');
}

?>
<section class="main-container">
    <div class="courses-header">
        <h2>Explore Our Courses</h2>
        <h3>Choose from a wide range of expertly crafted online courses.</h3>
    </div>

    <div class="courses-grid">
        <?php
        try {
            $products = getAllProducts();

            if (!empty($products)) {
                foreach ($products as $row) {
                    echo generateProductCard($row);
                }
            } else {
                echo "<p>No courses available at the moment.</p>";
            }
        } catch (Exception $e) {
            echo "<p>Error loading courses: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
        ?>
    </div>
</section>