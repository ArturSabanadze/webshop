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