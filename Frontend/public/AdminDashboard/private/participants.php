<?php
$seminarId = isset($_GET['seminar_id']) ? (int) $_GET['seminar_id'] : null;

// Fetch seminar date details
$stmt = $pdo->query("
    SELECT ls.id, ls.start_date, ls.end_date, p.title
    FROM live_seminars ls
    JOIN products p ON ls.product_id = p.id
    ORDER BY ls.start_date DESC
");
$allDates = $stmt->fetchAll(PDO::FETCH_ASSOC);

//fetch participants from certain seminar date
$stmt = $pdo->query("
    SELECT sp.user_id, up.name, up.surname, ls.product_id, p.title, p.id, sl.id 
    FROM seminar_participants sp
    JOIN users_profiles up ON sp.user_id = up.user_id
    JOIN live_seminars ls ON sp.seminar_id = ls.id
    JOIN seminars_locations sl ON ls.location_id = sl.id
    JOIN products p ON ls.product_id = p.id 
    WHERE sp.seminar_id = " . (int) $seminarId . "
");
$participants = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section>
    <h2>Teilnehmer anzeigen</h2>

    <form method="get">
        <input type="hidden" name="page" value="participants">

        <label for="seminar_id">Choice Seminar</label>
        <select name="seminar_id" id="seminar_id" onchange="this.form.submit()">
            <option value="">Please choose</option>
            <?php foreach ($allDates as $d): ?>
                <option value="<?= (int) $d['id'] ?>" <?= $d['id'] == $seminarId ? 'selected' : '' ?>>
                    <?= htmlspecialchars($d['title']) ?> (<?= htmlspecialchars($d['start_date']) ?>)
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <h3>Participants</h3>
    <table>
        <thead>
            <tr>
                <th>User-ID</th>
                <th>Name</th>
                <th>Surname</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($participants as $p): ?>
                <tr>
                    <td><?= (int) $p['user_id'] ?></td>
                    <td><?= htmlspecialchars($p['name']) ?></td>
                    <td><?= htmlspecialchars($p['surname']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>