<?php
// Admin: Seminar-Termine verwalten
// $pdo provided by admin_dashboard.php

function e($v)
{
    return htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');
}

/* ================== STATE ================== */
$editId = isset($_GET['edit_id']) ? (int) $_GET['edit_id'] : null;

/* ================== LOAD SEMINARS ================== */
$seminars = $pdo->query("
    SELECT id, product_name 
    FROM products 
    ORDER BY product_name
")->fetchAll(PDO::FETCH_ASSOC);

/* ================== CREATE ================== */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_date'])) {

    $stmt = $pdo->prepare("
        INSERT INTO seminar_dates
        (product_id, start_datetime, end_datetime, room, min_participants, max_participants, valid_to_start, available_for_reservation)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        (int) $_POST['product_id'],
        $_POST['start_datetime'],
        $_POST['end_datetime'],
        trim($_POST['room']),
        (int) $_POST['min_participants'],
        (int) $_POST['max_participants'],
        isset($_POST['valid_to_start']) ? 1 : 0,
        isset($_POST['available_for_reservation']) ? 1 : 0,
    ]);

    header("Location: admin_dashboard.php?page=dates");
    exit;
}

/* ================== UPDATE ================== */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_date'])) {

    $stmt = $pdo->prepare("
        UPDATE seminar_dates SET
            product_id = ?,
            start_datetime = ?,
            end_datetime = ?,
            room = ?,
            min_participants = ?,
            max_participants = ?,
            valid_to_start = ?,
            available_for_reservation = ?
        WHERE id = ?
    ");

    $stmt->execute([
        (int) $_POST['product_id'],
        $_POST['start_datetime'],
        $_POST['end_datetime'],
        trim($_POST['room']),
        (int) $_POST['min_participants'],
        (int) $_POST['max_participants'],
        isset($_POST['valid_to_start']) ? 1 : 0,
        isset($_POST['available_for_reservation']) ? 1 : 0,
        (int) $_POST['id'],
    ]);

    header("Location: admin_dashboard.php?page=dates");
    exit;
}

/* ================== DELETE ================== */
if (isset($_GET['delete_id'])) {
    $pdo->prepare("DELETE FROM seminar_dates WHERE id = ?")
        ->execute([(int) $_GET['delete_id']]);

    header("Location: admin_dashboard.php?page=dates");
    exit;
}

/* ================== LOAD DATES ================== */
$dates = $pdo->query("
    SELECT 
        d.*,
        p.product_name,
        COUNT(r.id) AS used_slots
    FROM seminar_dates d
    JOIN products p ON p.id = d.product_id
    LEFT JOIN seminar_registrations r ON r.seminar_date_id = d.id
    GROUP BY d.id
    ORDER BY d.start_datetime DESC
")->fetchAll(PDO::FETCH_ASSOC);
?>

<section>
    <h2>Seminar-Termine verwalten</h2>

    <!-- ================== CREATE FORM ================== -->
    <h3>Neuen Termin anlegen</h3>
    <form method="post">
        <select name="product_id" required>
            <option value="">Seminar wählen</option>
            <?php foreach ($seminars as $s): ?>
                <option value="<?= $s['id'] ?>"><?= e($s['product_name']) ?></option>
            <?php endforeach; ?>
        </select>

        <input type="datetime-local" name="start_datetime" required>
        <input type="datetime-local" name="end_datetime" required>
        <input name="room" placeholder="Raum">
        <input type="number" name="min_participants" value="1" min="1">
        <input type="number" name="max_participants" value="10" min="1">

        <label>
            <input type="checkbox" name="valid_to_start"> gültig zum Start
        </label>

        <label>
            <input type="checkbox" name="available_for_reservation" checked> buchbar
        </label>

        <button name="create_date">Speichern</button>
    </form>

    <!-- ================== LIST ================== -->
    <h3>Vorhandene Termine</h3>

    <table border="1" cellpadding="6">
        <thead>
            <tr>
                <th>ID</th>
                <th>Seminar</th>
                <th>Start</th>
                <th>Ende</th>
                <th>Raum</th>
                <th>Belegung</th>
                <th>Status</th>
                <th>Aktionen</th>
            </tr>
        </thead>
        <tbody>

            <?php foreach ($dates as $d): ?>
                <tr>
                    <form method="post">

                        <td><?= $d['id'] ?></td>

                        <td>
                            <?php if ($editId === (int) $d['id']): ?>
                                <select name="product_id">
                                    <?php foreach ($seminars as $s): ?>
                                        <option value="<?= $s['id'] ?>" <?= $s['id'] == $d['product_id'] ? 'selected' : '' ?>>
                                            <?= e($s['product_name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            <?php else: ?>
                                <?= e($d['product_name']) ?>
                            <?php endif; ?>
                        </td>

                        <td><?= $editId === (int) $d['id'] ? "<input type='datetime-local' name='start_datetime' value='{$d['start_datetime']}'>" : e($d['start_datetime']) ?>
                        </td>
                        <td><?= $editId === (int) $d['id'] ? "<input type='datetime-local' name='end_datetime' value='{$d['end_datetime']}'>" : e($d['end_datetime']) ?>
                        </td>
                        <td><?= $editId === (int) $d['id'] ? "<input name='room' value='" . e($d['room']) . "'>" : e($d['room']) ?>
                        </td>

                        <td><?= (int) $d['used_slots'] ?> / <?= (int) $d['max_participants'] ?></td>

                        <td>
                            <?php if ($editId === (int) $d['id']): ?>
                                <label><input type="checkbox" name="valid_to_start" <?= $d['valid_to_start'] ? 'checked' : '' ?>>
                                    gültig</label>
                                <label><input type="checkbox" name="available_for_reservation"
                                        <?= $d['available_for_reservation'] ? 'checked' : '' ?>> buchbar</label>
                            <?php else: ?>
                                <?= $d['valid_to_start'] ? '✔' : '✖' ?> /
                                <?= $d['available_for_reservation'] ? '✔' : '✖' ?>
                            <?php endif; ?>
                        </td>

                        <td>
                            <?php if ($editId === (int) $d['id']): ?>
                                <input type="hidden" name="id" value="<?= $d['id'] ?>">
                                <input type="hidden" name="min_participants" value="<?= $d['min_participants'] ?>">
                                <input type="hidden" name="max_participants" value="<?= $d['max_participants'] ?>">
                                <button name="save_date">Save</button>
                                <a href="admin_dashboard.php?page=dates">Cancel</a>
                            <?php else: ?>
                                <a href="?page=dates&edit_id=<?= $d['id'] ?>">Edit</a>
                                <a href="?page=dates&delete_id=<?= $d['id'] ?>"
                                    onclick="return confirm('Termin löschen?')">Delete</a>
                            <?php endif; ?>
                        </td>

                    </form>
                </tr>
            <?php endforeach; ?>

        </tbody>
    </table>
</section>