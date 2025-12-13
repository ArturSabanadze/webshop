<?php
// Admin: Seminare verwalten
// $pdo is provided by admin_dashboard.php

/* ================== CONFIG ================== */
$uploadDir = __DIR__ . '/../../assets/product_images/';
$uploadUrlBase = '../../assets/product_images/';

/* ================== HELPERS ================== */
function e($v)
{
    return htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');
}

/* ================== STATE ================== */
$editId = isset($_GET['edit_id']) ? (int) $_GET['edit_id'] : null;

/* ================== IMAGE UPLOAD HELPER ================== */
function handleImageUpload(string $uploadDir, string $uploadUrlBase, ?string $oldImage = null): string
{
    if (empty($_FILES['image_file']['name'])) {
        return $oldImage ?? '';
    }

    if ($_FILES['image_file']['error'] !== UPLOAD_ERR_OK) {
        die('<p style="color:red;">Upload fehlgeschlagen</p>');
    }

    if ($_FILES['image_file']['size'] > 1024 * 1024) {
        die('<p style="color:red;">Bild darf maximal 1 MB groß sein</p>');
    }

    $info = getimagesize($_FILES['image_file']['tmp_name']);
    if ($info === false) {
        die('<p style="color:red;">Datei ist kein gültiges Bild</p>');
    }

    $allowed = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
        'image/gif' => 'gif'
    ];

    if (!isset($allowed[$info['mime']])) {
        die('<p style="color:red;">Nur JPG, PNG, WEBP oder GIF erlaubt</p>');
    }

    $filename = uniqid('product_', true) . '.' . $allowed[$info['mime']];

    if (!move_uploaded_file($_FILES['image_file']['tmp_name'], $uploadDir . $filename)) {
        die('<p style="color:red;">Datei konnte nicht gespeichert werden</p>');
    }

    if ($oldImage) {
        @unlink($uploadDir . basename($oldImage));
    }

    return $uploadUrlBase . $filename;
}

/* ================== CREATE ================== */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_seminar'])) {

    $name = trim($_POST['name'] ?? '');
    $desc = trim($_POST['description'] ?? '');
    $price = $_POST['price'] ?? null;
    $min = (int) ($_POST['min_capacity'] ?? 0);
    $max = (int) ($_POST['max_capacity'] ?? 0);
    $start = $_POST['start_date'] ?? null;
    $end = $_POST['end_date'] ?? null;

    if ($name === '' || !is_numeric($price) || $max < $min) {
        die('<p style="color:red;">Ungültige Eingaben</p>');
    }

    $imageUrl = handleImageUpload($uploadDir, $uploadUrlBase);

    $stmt = $pdo->prepare("
        INSERT INTO products
        (product_name, description, image_url, price, min_capacity, max_capacity, start_date, end_date)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->execute([$name, $desc, $imageUrl, $price, $min, $max, $start, $end]);

    header("Location: admin_dashboard.php?page=seminars");
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
            product_name = ?,
            description  = ?,
            image_url    = ?,
            price        = ?,
            min_capacity = ?,
            max_capacity = ?,
            start_date   = ?,
            end_date     = ?
        WHERE id = ?
    ");

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

    header("Location: admin_dashboard.php?page=seminars");
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

/* ================== LOAD ================== */
$seminars = $pdo->query("SELECT * FROM products ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<section>
    <h2>Seminare verwalten</h2>

    <h3>Neues Seminar anlegen</h3>
    <form method="post" enctype="multipart/form-data">
        <input name="name" placeholder="Titel" required>
        <textarea name="description" placeholder="Beschreibung"></textarea>
        <input type="file" name="image_file" accept="image/jpeg,image/png,image/webp,image/gif">
        <input type="number" step="0.01" name="price" placeholder="Preis" required>
        <input type="number" name="min_capacity" placeholder="Min">
        <input type="number" name="max_capacity" placeholder="Max">
        <input type="date" name="start_date">
        <input type="date" name="end_date">
        <button name="create_seminar">Speichern</button>
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

            <?php foreach ($seminars as $s): ?>
                <tr>
                    <form method="post" enctype="multipart/form-data">

                        <td><?= $s['id'] ?></td>

                        <td><?= $editId === (int) $s['id']
                            ? "<input name='name' value='" . e($s['product_name']) . "'>"
                            : e($s['product_name']) ?>
                        </td>

                        <td><?= $editId === (int) $s['id']
                            ? "<input name='description' value='" . e($s['description']) . "'>"
                            : e($s['description']) ?>
                        </td>

                        <td>
                            <?php if ($s['image_url']): ?>
                                <img src="<?= e($s['image_url']) ?>" style="height:50px; display:block;">
                            <?php endif; ?>

                            <?php if ($editId === (int) $s['id']): ?>
                                <input type="file" name="image_file" accept="image/jpeg,image/png,image/webp,image/gif">
                            <?php endif; ?>
                        </td>

                        <td><?= $editId === (int) $s['id']
                            ? "<input name='price' value='" . e($s['price']) . "'>"
                            : e($s['price']) . ' €' ?>
                        </td>

                        <td><?= $editId === (int) $s['id'] ? "<input name='min_capacity' value='{$s['min_capacity']}'>" : e($s['min_capacity']) ?>
                        </td>
                        <td><?= $editId === (int) $s['id'] ? "<input name='max_capacity' value='{$s['max_capacity']}'>" : e($s['max_capacity']) ?>
                        </td>
                        <td><?= $editId === (int) $s['id'] ? "<input name='start_date' value='{$s['start_date']}'>" : e($s['start_date']) ?>
                        </td>
                        <td><?= $editId === (int) $s['id'] ? "<input name='end_date' value='{$s['end_date']}'>" : e($s['end_date']) ?>
                        </td>

                        <td>
                            <?php if ($editId === (int) $s['id']): ?>
                                <input type="hidden" name="id" value="<?= $s['id'] ?>">
                                <button name="seminar_save">Save</button>
                                <a href="admin_dashboard.php?page=seminars">Cancel</a>
                            <?php else: ?>
                                <a href="?page=seminars&edit_id=<?= $s['id'] ?>">Edit</a>
                                <a href="?page=seminars&delete_id=<?= $s['id'] ?>"
                                    onclick="return confirm('Löschen?')">Delete</a>
                            <?php endif; ?>
                        </td>

                    </form>
                </tr>
            <?php endforeach; ?>

        </tbody>
    </table>
</section>