<?php
// Admin: Seminar-Termine verwalten

// Seminare für Auswahl laden
$stmt = $pdo->query("SELECT id, product_name FROM products ORDER BY product_name");
$seminars = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Termin anlegen
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_date'])) {
    $productId = (int) ($_POST['product_id'] ?? 0);
    $start = $_POST['start_datetime'] ?? '';
    $end = $_POST['end_datetime'] ?? '';
    $room = trim($_POST['room'] ?? '');
    $maxParticipants = (int) ($_POST['max_participants'] ?? 10);

    if ($productId > 0 && $start !== '' && $end !== '') {
        $stmt = $pdo->prepare("
            INSERT INTO seminar_dates (product_id, start_datetime, end_datetime, room, max_participants)
            VALUES (:product_id, :start_dt, :end_dt, :room, :max_participants)
        ");
        $stmt->execute([
            ':product_id' => $productId,
            ':start_dt' => $start,
            ':end_dt' => $end,
            ':room' => $room,
            ':max_participants' => $maxParticipants,
        ]);
        echo '<p>Termin wurde angelegt.</p>';
    } else {
        echo '<p style="color:red;">Seminar, Start- und Endzeit sind Pflichtfelder.</p>';
    }
}

// Bestehende Termine laden + Anzahl Teilnehmer
$stmt = $pdo->query("
    SELECT 
        d.id,
        p.product_name,
        d.start_datetime,
        d.end_datetime,
        d.room,
        d.max_participants,
        COUNT(r.id) AS used_slots
    FROM seminar_dates d
    JOIN products p ON d.product_id = p.id
    LEFT JOIN seminar_registrations r ON r.seminar_date_id = d.id
    GROUP BY d.id, p.product_name, d.start_datetime, d.end_datetime, d.room, d.max_participants
    ORDER BY d.start_datetime DESC
");
$dates = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<section>
    <h2>Seminar-Termine verwalten</h2>

    <h3>Neuen Termin anlegen</h3>
    <form method="post">
        <div class="form-group">
            <label for="product_id">Seminar</label>
            <select name="product_id" id="product_id" required>
                <option value="">Bitte wählen</option>
                <?php foreach ($seminars as $seminar): ?>
                    <option value="<?= (int)$seminar['id'] ?>">
                        <?= htmlspecialchars($seminar['product_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="start_datetime">Start (Datum &amp; Uhrzeit)</label>
            <input type="datetime-local" id="start_datetime" name="start_datetime" required>
        </div>

        <div class="form-group">
            <label for="end_datetime">Ende (Datum &amp; Uhrzeit)</label>
            <input type="datetime-local" id="end_datetime" name="end_datetime" required>
        </div>

        <div class="form-group">
            <label for="room">Raum</label>
            <input type="text" id="room" name="room">
        </div>

        <div class="form-group">
            <label for="max_participants">Max. Teilnehmer</label>
            <input type="number" id="max_participants" name="max_participants" value="10" min="1" max="20">
        </div>

        <button type="submit" name="create_date">Speichern</button>
    </form>

    <h3>Vorhandene Termine</h3>
    <?php if (count($dates) === 0): ?>
        <p>Es sind noch keine Termine angelegt.</p>
    <?php else: ?>
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Seminar</th>
                <th>Start</th>
                <th>Ende</th>
                <th>Raum</th>
                <th>Belegung</th>
                <th>Aktionen</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($dates as $date): ?>
                <tr>
                    <td><?= (int)$date['id'] ?></td>
                    <td><?= htmlspecialchars($date['product_name']) ?></td>
                    <td><?= htmlspecialchars($date['start_datetime']) ?></td>
                    <td><?= htmlspecialchars($date['end_datetime']) ?></td>
                    <td><?= htmlspecialchars($date['room']) ?></td>
                    <td>
                        <?= (int)$date['used_slots'] ?> / <?= (int)$date['max_participants'] ?>
                    </td>
                    <td>
                        <a href="admin_dashboard.php?page=participants&amp;date_id=<?= (int)$date['id'] ?>">Teilnehmer anzeigen</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</section>
