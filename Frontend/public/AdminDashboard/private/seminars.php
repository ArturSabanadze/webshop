<?php
// Admin: Seminare verwalten
// $pdo wird aus admin_dashboard.php bereitgestellt

// Define upload folder
$uploadDir = __DIR__ . '/../../assets/product_images/'; // adjust path to your project
$uploadUrlBase = '../../assets/product_images/'; // URL prefix to save in DB if you work with Visual Studio Code 
/* $uploadUrlBase = '/Die_Fantastische_4/Frontend/public/assets/product_images/';  */// URL prefix to save in DB if you work xampp. Project root is assumed to be at /Die_Fantastische_4/Frontend/public/


// Seminar anlegen
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_seminar'])) {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = $_POST['price'] ?? null;


    // Datumsprüfung (kommentar arthur das sollte so klappen denn es geht auf meiner maschiene)
    $startDate = $_POST['start_date'] ?? '';
    $endDate = $_POST['end_date'] ?? '';

    // Nur prüfen, wenn Felder gesetzt sind
    if ($startDate !== '')
        $startDT = new DateTime($startDate);
    if ($endDate !== '')
        $endDT = new DateTime($endDate);

    $heute = new DateTime(); // aktuelles Datum

    // Validierung
    if ($startDate === '' || $endDate === '') {
        echo '<p style="color:red;">Start- und Enddatum sind Pflichtfelder.</p>';
        exit;
    } elseif ($startDT < $heute) {
        echo '<p style="color:red;">Das Startdatum darf nicht in der Vergangenheit liegen.</p>';
        exit;
    } elseif ($endDT <= $startDT) {
        echo '<p style="color:red;">Das Enddatum muss nach dem Startdatum liegen.</p>';
        exit;
    } elseif (
        $name !== '' && $price !== null && is_numeric($price)
        && $_POST['max_capacity'] >= $_POST['min_capacity']
    )


        // Handle image upload
        $imageUrl = '';
    if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES['image_file']['tmp_name'];
        $fileName = basename($_FILES['image_file']['name']);
        $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
        $newFileName = uniqid('product_', true) . '.' . $fileExt; // unique name
        $destPath = $uploadDir . $newFileName;

        if (move_uploaded_file($tmpName, $destPath)) {
            $imageUrl = $uploadUrlBase . $newFileName;
        } else {
            echo '<p style="color:red;">Bild konnte nicht hochgeladen werden.</p>';
        }
    }

    if ($name !== '' && $price !== null && is_numeric($price) && $_POST['max_capacity'] >= $_POST['min_capacity']) {
        $stmt = $pdo->prepare("
            INSERT INTO products 
            (product_name, image_url, description, price, min_capacity, max_capacity, start_date, end_date) 
            VALUES 
            (:name, :image_url, :description, :price, :min_capacity, :max_capacity, :start_date, :end_date)
        ");
        $stmt->execute([
            ':name' => $name,
            ':image_url' => $imageUrl,
            ':description' => $description,
            ':price' => $price,
            ':min_capacity' => $_POST['min_capacity'] ?? null,
            ':max_capacity' => $_POST['max_capacity'] ?? null,
            ':start_date' => $_POST['start_date'] ?? null,
            ':end_date' => $_POST['end_date'] ?? null,
        ]);
        echo '<p>Seminar wurde angelegt.</p>';
    } else {
        echo '<p style="color:red;">Name, Preis und Kapazitäten sind Pflichtfelder und müssen korrekt sein.</p>';
    }
}


// Seminar löschen inkl. Bild
if (isset($_GET['delete_id'])) {
    $deleteId = (int) $_GET['delete_id'];
    if ($deleteId > 0) {
        $stmt = $pdo->prepare("SELECT image_url FROM products WHERE id = :id");
        $stmt->execute([':id' => $deleteId]);
        $seminar = $stmt->fetch(PDO::FETCH_ASSOC);

        // Delete image
        if ($seminar && !empty($seminar['image_url'])) {
            $fileName = basename($seminar['image_url']);
            $imagePath = $uploadDir . $fileName;
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // Delete seminar record
        $stmt = $pdo->prepare("DELETE FROM products WHERE id = :id");
        $stmt->execute([':id' => $deleteId]);

        echo '<p>Seminar wurde gelöscht (inkl. Bild).</p>';
    }
}

// Seminare laden
$stmt = $pdo->query("SELECT id, product_name, price, image_url FROM products ORDER BY id DESC");
$seminars = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<section>
    <h2>Seminare verwalten</h2>

    <h3>Neues Seminar anlegen</h3>
    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Titel des Seminars</label>
            <input type="text" id="name" name="name" required>
        </div>

        <div class="form-group">
            <label for="description">Beschreibung</label>
            <textarea id="description" name="description"></textarea>
        </div>

        <div class="form-group">
            <label for="image_file">Bild hochladen</label>
            <input type="file" id="image_file" name="image_file" accept="image/*">
        </div>

        <div class="form-group">
            <label for="price">Preis (&euro;)</label>
            <input type="number" step="0.01" id="price" name="price" required>
        </div>

        <div class="form-group">
            <label for="min_capacity">Minimale Kapazität</label>
            <input type="number" id="min_capacity" name="min_capacity">
        </div>

        <div class="form-group">
            <label for="max_capacity">Maximale Kapazität</label>
            <input type="number" id="max_capacity" name="max_capacity">
        </div>

        <div class="form-group">
            <label for="start_date">Startdatum</label>
            <input type="date" id="start_date" name="start_date">
        </div>

        <div class="form-group">
            <label for="end_date">Enddatum</label>
            <input type="date" id="end_date" name="end_date">
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
                    <th>Bild</th>
                    <th>Preis</th>
                    <th>Aktionen</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($seminars as $seminar): ?>
                    <tr>
                        <td><?= (int) $seminar['id'] ?></td>
                        <td><?= htmlspecialchars($seminar['product_name']) ?></td>
                        <td>
                            <?php if ($seminar['image_url']): ?>
                                <img src="<?= htmlspecialchars($seminar['image_url']) ?>" alt="" style="height:50px;">
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($seminar['price']) ?> &euro;</td>
                        <td>
                            <a href="admin_dashboard.php?page=seminars&amp;delete_id=<?= (int) $seminar['id'] ?>"
                                onclick="return confirm('Seminar wirklich löschen?');">Löschen</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</section>