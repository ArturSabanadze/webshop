<?php
// Admin: Seminare verwalten
// $pdo wird aus admin_dashboard.php bereitgestellt

// Seminar anlegen
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_seminar'])) {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = $_POST['price'] ?? null;

    if ($name !== '' && $price !== null) {
        $stmt = $pdo->prepare("
            INSERT INTO products (product_name, description, price) 
            VALUES (:name, :description, :price)
        ");
        $stmt->execute([
            ':name' => $name,
            ':description' => $description,
            ':price' => $price,
        ]);
        echo '<p>Seminar wurde angelegt.</p>';
    } else {
        echo '<p style="color:red;">Name und Preis sind Pflichtfelder.</p>';
    }
}

// Seminar löschen
if (isset($_GET['delete_id'])) {
    $deleteId = (int) $_GET['delete_id'];
    if ($deleteId > 0) {
        $stmt = $pdo->prepare("DELETE FROM products WHERE id = :id");
        $stmt->execute([':id' => $deleteId]);
        echo '<p>Seminar wurde gelöscht.</p>';
    }
}

// Seminare laden
$stmt = $pdo->query("SELECT id, product_name, price FROM products ORDER BY id DESC");
$seminars = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<section>
    <h2>Seminare verwalten</h2>

    <h3>Neues Seminar anlegen</h3>
    <form method="post">
        <div class="form-group">
            <label for="name">Titel des Seminars</label>
            <input type="text" id="name" name="name" required>
        </div>

        <div class="form-group">
            <label for="description">Beschreibung</label>
            <textarea id="description" name="description"></textarea>
        </div>

        <div class="form-group">
            <label for="price">Preis (&euro;)</label>
            <input type="number" step="0.01" id="price" name="price" required>
        </div>

        <button type="submit" name="create_seminar">Speichern</button>
    </form>

    <h3>Vorhandene Seminare</h3>
    <?php if (count($seminars) === 0): ?>
        <p>Es sind noch keine Seminare angelegt.</p>
    <?php else: ?>
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Titel</th>
                <th>Preis</th>
                <th>Aktionen</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($seminars as $seminar): ?>
                <tr>
                    <td><?= (int)$seminar['id'] ?></td>
                    <td><?= htmlspecialchars($seminar['product_name']) ?></td>
                    <td><?= htmlspecialchars($seminar['price']) ?> &euro;</td>
                    <td>
                        <a href="admin_dashboard.php?page=seminars&amp;delete_id=<?= (int)$seminar['id'] ?>" 
                           onclick="return confirm('Seminar wirklich löschen?');">Löschen</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</section>
