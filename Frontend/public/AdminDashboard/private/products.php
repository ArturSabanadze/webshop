<?php
// Admin: Seminare verwalten
// $pdo is provided by admin_dashboard.php

/* ================== CONFIG ================== */
require_once __DIR__ . '/Functions/admin_image_upload.php'; // image upload function
require_once __DIR__ . '/Classes/Product.php'; // Product class

$uploadDir = __DIR__ . '/../../assets/product_images/';
/* $uploadUrlBase = '../../assets/product_images/'; path for developing via VSC Server*/
$uploadUrlBase = '/Die_Fantastische_4/Frontend/public/assets/product_images/'; //path for XAMPP server

/* ================== HELPERS ================== */
function e($v)
{
    return htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');
}

/* ================== STATE ================== */
$editId = isset($_GET['edit_id']) ? (int) $_GET['edit_id'] : null;

/* ================== CREATE ================== */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_product'])) {

    $name = trim($_POST['title'] ?? '');
    $desc = trim($_POST['description'] ?? '');
    $price = $_POST['price'] ?? null;
    $min = (int) ($_POST['min_capacity'] ?? 0);
    $max = (int) ($_POST['max_capacity'] ?? 0);
    $start = $_POST['start_date'] ?? null;
    $end = $_POST['end_date'] ?? null;
    if ($start !== '')
        $startDT = new DateTime($start);
    if ($end !== '')
        $endDT = new DateTime($end);

    //Invalid input handling
    if ($name === '' || mb_strlen(trim($name)) < 3) {
        die('<p style="color:red;">Titel Name empty or too short</p>');
    }
    if (is_numeric($name)) {
        die('<p style="color:red;">Titel cant be numeric</p>');
    }
    if (!is_numeric($price) || $price < 0) {
        die('<p style="color:red;">Price invalid</p>');
    }
    if ($max < $min) {
        die('<p style="color:red;">Participant max capacity can not be less than min capacity</p>');
    }
    if ($endDT < $startDT) {
        die('<p style="color:red;">End date must be after start date</p>');
    }



    $imageUrl = handleImageUpload($uploadDir, $uploadUrlBase);

    $stmt = $pdo->prepare("
        INSERT INTO products
        (title, description, image_url, price, status, created_at, start_selling_date)
        VALUES (?, ?, ?, ?, ?, NOW(), ?)
    ");
    $stmt->execute([$name, $desc, $imageUrl, $price, $status, $starting]);

    header("Location: admin_dashboard.php?page=products");
    exit;
}

/* ================== UPDATE ================== */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['seminar_save'])) {

    $id = (int) $_POST['id'];

    $stmt = $pdo->prepare("SELECT image_url FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $oldImage = $stmt->fetchColumn();

    $imageUrl = handleImageUpload($uploadDir, $uploadUrlBase, $oldImage);

    $stmt = $pdo->prepare("
        UPDATE products SET
            title = ?,
            description  = ?,
            image_url    = ?,
            price        = ?,
            status       = ?,
            created_at   = NOW(),
            start_selling_date = ?,

            min_capacity = ?,
            max_capacity = ?,
            start_date   = ?,
            end_date     = ?
        WHERE id = ?
    ");

    if ($_POST['title'] === '' || mb_strlen(trim($_POST['title'])) < 3) {
        die('<p style="color:red;">Titel Name empty or too short</p>');
    }
    if (is_numeric($_POST['title'])) {
        die('<p style="color:red;">Titel cant be numeric</p>');
    }
    if (!is_numeric($_POST['price']) || $_POST['price'] < 0) {
        die('<p style="color:red;">Price invalid</p>');
    }
    if ($_POST['max_capacity'] < $_POST['min_capacity']) {
        die('<p style="color:red;">Participant max capacity can not be less than min capacity</p>');
    }
    if ($_POST['end_date'] < $_POST['start_date']) {
        die('<p style="color:red;">End date must be after start date</p>');
    }

    $stmt->execute([
        $_POST['name'],
        $_POST['description'],
        $imageUrl,
        $_POST['price'],
        $_POST['min_capacity'],
        $_POST['max_capacity'],
        $_POST['start_date'],
        $_POST['end_date'],
        $id
    ]);

    header("Location: admin_dashboard.php?page=products");
    exit;
}

/* ================== DELETE ================== */
if (isset($_GET['delete_id'])) {

    $id = (int) $_GET['delete_id'];

    $stmt = $pdo->prepare("SELECT image_url FROM products WHERE id = ?");
    $stmt->execute([$id]);
    if ($img = $stmt->fetchColumn()) {
        @unlink($uploadDir . basename($img));
    }

    $pdo->prepare("DELETE FROM products WHERE id = ?")->execute([$id]);

    header("Location: admin_dashboard.php?page=seminars");
    exit;
}

/* ================== READ ================== */
$products = $pdo->query("SELECT * FROM products ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);
?>

<section>
    <h2>Product management</h2>

    <h3>Create new Product</h3>
    <form method="post" enctype="multipart/form-data">
        <div>
            <label for="title">Titel</label>
            <input id="title" name="title" placeholder="Titel" required>
        </div>

        <div>
            <label for="description">Beschreibung</label>
            <textarea id="description" name="description" placeholder="Beschreibung"></textarea>
        </div>

        <div>
            <label for="image_file">Bild</label>
            <input type="file" id="image_file" name="image_file" accept="image/jpeg,image/png,image/webp,image/gif">
        </div>

        <div>
            <label for="price">Preis (€)</label>
            <input type="number" step="0.01" id="price" name="price" placeholder="Preis" required>
        </div>

        <div>
            <label for="min_capacity">Min. Teilnehmer</label>
            <input type="number" id="min_capacity" name="min_capacity" placeholder="Min">
        </div>

        <div>
            <label for="max_capacity">Max. Teilnehmer</label>
            <input type="number" id="max_capacity" name="max_capacity" placeholder="Max">
        </div>

        <div>
            <label for="start_date">Startdatum</label>
            <input type="date" id="start_date" name="start_date">
        </div>

        <div>
            <label for="end_date">Endedatum</label>
            <input type="date" id="end_date" name="end_date">
        </div>

        <div>
            <button name="create_seminar" type="submit">Speichern</button>
        </div>
    </form>

    <h3>Vorhandene Seminare</h3>

    <table border="1" cellpadding="6">
        <thead>
            <tr>
                <th>ID</th>
                <th>Titel</th>
                <th>Beschreibung</th>
                <th>Bild</th>
                <th>Preis</th>
                <th>Min</th>
                <th>Max</th>
                <th>Start</th>
                <th>Ende</th>
                <th>Aktionen</th>
            </tr>
        </thead>
        <tbody>

            <?php foreach ($products as $p): ?>
                <tr>
                    <form method="post" enctype="multipart/form-data">

                        <td><?= $p['id'] ?></td>
                        <td><?= $editId === (int) $p['id']
                            ? "<input name='title' value='" . e($p['title']) . "'>"
                            : e($p['title']) ?>
                        </td>

                        <td><?= $editId === (int) $p['id']
                            ? "<input name='description' value='" . e($p['description']) . "'>"
                            : e($p['description']) ?>
                        </td>

                        <td>
                            <?php if ($p['image_url']): ?>
                                <img src="<?= e($p['image_url']) ?>" style="height:50px; display:block;">
                            <?php endif; ?>

                            <?php if ($editId === (int) $p['id']): ?>
                                <input type="file" name="image_file" accept="image/jpeg,image/png,image/webp,image/gif">
                            <?php endif; ?>
                        </td>

                        <td><?= $editId === (int) $p['id']
                            ? "<input name='price' value='" . e($p['price']) . "'>"
                            : e($p['price']) . ' €' ?>
                        </td>

                        <td><?= $editId === (int) $p['id'] ? "<input name='min_capacity' value='{$p['min_capacity']}'>" : e($p['min_capacity']) ?>
                        </td>
                        <td><?= $editId === (int) $p['id'] ? "<input name='max_capacity' value='{$p['max_capacity']}'>" : e($p['max_capacity']) ?>
                        </td>
                        <td><?= $editId === (int) $p['id'] ? "<input name='start_date' value='{$p['start_date']}'>" : e($p['start_date']) ?>
                        </td>
                        <td><?= $editId === (int) $p['id'] ? "<input name='end_date' value='{$p['end_date']}'>" : e($p['end_date']) ?>
                        </td>

                        <td>
                            <?php if ($editId === (int) $p['id']): ?>
                                <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                <button name="seminar_save">Save</button>
                                <a href="admin_dashboard.php?page=products">Cancel</a>
                            <?php else: ?>
                                <a href="?page=products&edit_id=<?= $p['id'] ?>">Edit</a>
                                <a href="?page=products&delete_id=<?= $p['id'] ?>"
                                    onclick="return confirm('Löschen?')">Delete</a>
                            <?php endif; ?>
                        </td>

                    </form>
                </tr>
            <?php endforeach; ?>

        </tbody>
    </table>
</section>