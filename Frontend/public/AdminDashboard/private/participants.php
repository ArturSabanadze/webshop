<?php
// Admin: Teilnehmer eines Termins anzeigen

$dateId = isset($_GET['date_id']) ? (int) $_GET['date_id'] : 0;

// Termine für Dropdown (Filter)
$stmt = $pdo->query("
    SELECT d.id, p.product_name, d.start_datetime
    FROM seminar_dates d
    JOIN products p ON d.product_id = p.id
    ORDER BY d.start_datetime DESC
");
$allDates = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Teilnehmer des ausgewählten Termins laden
$participants = [];
$selectedDate = null;

if ($dateId > 0) {
    // Infos zum Termin
    $stmt = $pdo->prepare("
        SELECT d.id, p.product_name, d.start_datetime, d.end_datetime, d.room
        FROM seminar_dates d
        JOIN products p ON d.product_id = p.id
        WHERE d.id = :id
    ");
    $stmt->execute([':id' => $dateId]);
    $selectedDate = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($selectedDate) {
        // Teilnehmer holen (User)
        $stmt = $pdo->prepare("
            SELECT u.id, u.username, u.email, r.registration_datetime
            FROM seminar_registrations r
            JOIN users u ON r.user_id = u.id
            WHERE r.seminar_date_id = :id
            ORDER BY u.username
        ");
        $stmt->execute([':id' => $dateId]);
        $participants = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
<section>
    <h2>Teilnehmer anzeigen</h2>

    <form method="get">
        <input type="hidden" name="page" value="participants">

        <div class="form-group">
            <label for="date_id">Termin auswählen</label>
            <select name="date_id" id="date_id" onchange="this.form.submit()">
                <option value="">Bitte wählen</option>
                <?php foreach ($allDates as $d): ?>
                    <option value="<?= (int)$d['id'] ?>" <?= $d['id'] === $dateId ? 'selected' : '' ?>>
                        <?= htmlspecialchars($d['product_name']) ?>
                        (<?= htmlspecialchars($d['start_datetime']) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <noscript><button type="submit">Anzeigen</button></noscript>
    </form>

    <?php if ($selectedDate): ?>
        <h3>Termin: <?= htmlspecialchars($selectedDate['product_name']) ?></h3>
        <p>
            Start: <?= htmlspecialchars($selectedDate['start_datetime']) ?><br>
            Ende: <?= htmlspecialchars($selectedDate['end_datetime']) ?><br>
            Raum: <?= htmlspecialchars($selectedDate['room']) ?>
        </p>

        <h4>Teilnehmer</h4>
        <?php if (count($participants) === 0): ?>
            <p>Für diesen Termin sind noch keine Teilnehmer angemeldet.</p>
        <?php else: ?>
            <table>
                <thead>
                <tr>
                    <th>User-ID</th>
                    <th>Benutzername</th>
                    <th>E-Mail</th>
                    <th>Angemeldet seit</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($participants as $p): ?>
                    <tr>
                        <td><?= (int)$p['id'] ?></td>
                        <td><?= htmlspecialchars($p['username']) ?></td>
                        <td><?= htmlspecialchars($p['email']) ?></td>
                        <td><?= htmlspecialchars($p['registration_datetime']) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    <?php endif; ?>
</section>
