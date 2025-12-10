<?php
require_once '../src/Functions/product_card_loader.php';

// Read filter parameters
$search = $_GET['search'] ?? '';
$category = $_GET['category'] ?? '';
$sort = $_GET['sort'] ?? 'newest';
?>

<!-- SHOP SECTION -->
<section class="main-container">
    <div class="courses-header-filter">

        <!-- Search Input -->
        <input type="text" class="filter-search" placeholder="Search products..."
            value="<?= htmlspecialchars($search) ?>" />

        <!-- Category Select -->
        <select class="filter-category">
            <option value="">All Categories</option>
            <option value="software" <?= $category === 'software' ? 'selected' : '' ?>>Software</option>
            <option value="design" <?= $category === 'design' ? 'selected' : '' ?>>Web Development</option>
            <option value="business" <?= $category === 'business' ? 'selected' : '' ?>>Business</option>
            <option value="marketing" <?= $category === 'marketing' ? 'selected' : '' ?>>Marketing</option>
        </select>

        <!-- Sort Select -->
        <select class="filter-sort">
            <option value="newest" <?= $sort === 'newest' ? 'selected' : '' ?>>Newest</option>
            <option value="popular" <?= $sort === 'popular' ? 'selected' : '' ?>>Most Popular</option>
            <option value="price-low" <?= $sort === 'price-low' ? 'selected' : '' ?>>Price: Low → High</option>
            <option value="price-high" <?= $sort === 'price-high' ? 'selected' : '' ?>>Price: High → Low</option>
        </select>

        <!-- Search Button -->
        <button class="filter-btn" type="button">Search</button>

    </div>

    <div class="courses-grid">
        <?php
        try {
            $products = getFilteredProducts($search, $category, $sort);

            if (!empty($products)) {
                foreach ($products as $row) {
                    echo generateProductCard($row);
                }
            } else {
                echo "<p>No products found.</p>";
            }
        } catch (Exception $e) {
            echo "<p>Error loading products: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
        ?>
    </div>
</section>

<script>
    // JS Filter event
    const btn = document.querySelector('.filter-btn');

    btn.addEventListener('click', () => {
        const search = document.querySelector('.filter-search').value;
        const category = document.querySelector('.filter-category').value;
        const sort = document.querySelector('.filter-sort').value;

        const params = new URLSearchParams({ search, category, sort });
        window.location.href = `?page=shop&${params.toString()}`;
    });
</script>