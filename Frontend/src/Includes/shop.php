<?php
require_once '../src/Functions/product_card_loader.php';
require_once '../api/products_api.php';

// ===== GET FILTER VALUES =====
$search = $_GET['search'] ?? '';
$category = $_GET['category'] ?? '';  // <- use this for filtering
$selectedCategory = $category;        // <- use this for marking selected option
$sort = $_GET['sort'] ?? 'newest';

// ===== FETCH DATA =====
$categories = getCategories();
$products = getProducts($search, $category, $sort);
?>

<section class="main-container">
    <div class="courses-header-filter">
        <input type="text" class="filter-search" placeholder="Search products..."
            value="<?= htmlspecialchars($search) ?>" />
        <select class="filter-category" name="category">
            <option value="">All Categories</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= htmlspecialchars($cat['category_name']) ?>" <?= $selectedCategory === $cat['category_name'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['category_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <select class="filter-sort">
            <option value="newest" <?= $sort === 'newest' ? 'selected' : '' ?>>Newest</option>
            <option value="price-low" <?= $sort === 'price-low' ? 'selected' : '' ?>>Price: Low → High</option>
            <option value="price-high" <?= $sort === 'price-high' ? 'selected' : '' ?>>Price: High → Low</option>
        </select>
        <button class="filter-btn" type="button">Search</button>
    </div>

    <div class="courses-grid">
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $row): ?>
                <?= generateProductCard($row) ?>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No products found.</p>
        <?php endif; ?>
    </div>

    <!-- ENROLL MODAL -->
    <div id="enrollModal" class="modal-overlay" style="display:none;">
        <div class="modal">
            <span class="modal-close" onclick="closeEnrollModal()">×</span>
            <h3>Wähle ein Seminar-Datum</h3>
            <form id="enrollForm">
                <input type="hidden" name="seminar_date_id" id="modal_seminar_date_id">
                <select id="seminar_date_select" required></select>
                <button type="submit">Enroll</button>
            </form>
        </div>
    </div>
</section>

<script>
    // FILTER BUTTON
    document.querySelector('.filter-btn').addEventListener('click', () => {
        const search = document.querySelector('.filter-search').value;
        const category = document.querySelector('.filter-category').value;
        const sort = document.querySelector('.filter-sort').value;
        const params = new URLSearchParams({ search, category, sort });
        window.location.href = `?page=shop&${params.toString()}`;
    });

    // OPEN MODAL AND FETCH SEMINAR DATES
    document.querySelectorAll('.course-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const productId = this.dataset.id;
            const seminarSelect = document.getElementById('seminar_date_select');
            seminarSelect.innerHTML = '';

            fetch('ajax_get_seminar_dates.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'product_id=' + encodeURIComponent(productId)
            })
                .then(res => res.json())
                .then(dates => {
                    if (dates.error) {
                        alert(dates.error);
                        return;
                    }

                    if (dates.length === 0) {
                        const opt = document.createElement('option');
                        opt.value = '';
                        opt.textContent = 'No available dates';
                        seminarSelect.appendChild(opt);
                    } else {
                        dates.forEach(d => {
                            const opt = document.createElement('option');
                            opt.value = d.id;
                            opt.textContent = d.start_datetime + ' - ' + d.end_datetime;
                            seminarSelect.appendChild(opt);
                        });
                    }

                    document.getElementById('enrollModal').style.display = 'flex';
                })
                .catch(err => console.error('Error fetching seminar dates:', err));
        });
    });

    // ENROLL FORM SUBMIT
    document.getElementById('enrollForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const seminarDateId = document.getElementById('seminar_date_select').value;

        fetch('ajax_enroll.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'seminar_date_id=' + encodeURIComponent(seminarDateId)
        })
            .then(res => res.json())
            .then(result => {
                if (result.error) {
                    alert(result.error);
                } else {
                    alert(result.success);
                }
                closeEnrollModal();
            })
            .catch(err => console.error('Error during enrollment:', err));
    });

    function closeEnrollModal() {
        document.getElementById('enrollModal').style.display = 'none';
    }
</script>