<?php
$path = '../src/Functions/product_card_loader.php';
if (file_exists($path)) {
    require_once $path;
} else {
    die('Required file product_card_loader.php not found.');
}

?>
<!-- SHOP SECTION -->
<section class="main-container">
    <div class="courses-header-filter">

        <!-- Search Input -->
        <input type="text" class="filter-search" placeholder="Search products..." />

        <!-- Category Select -->
        <select class="filter-category">
            <option value="">All Categories</option>
            <option value="software">Software</option>
            <option value="design">Design</option>
            <option value="business">Business</option>
            <option value="marketing">Marketing</option>
        </select>

        <!-- Sort Select -->
        <select class="filter-sort">
            <option value="newest">Newest</option>
            <option value="popular">Most Popular</option>
            <option value="price-low">Price: Low → High</option>
            <option value="price-high">Price: High → Low</option>
        </select>

        <!-- Search Button -->
        <button class="filter-btn">Search</button>

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