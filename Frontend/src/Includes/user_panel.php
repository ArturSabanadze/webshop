<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once '../../Backend/db_connection.php';

// Redirect if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: index.php?page=login");
    exit;
}

$current_username = $_SESSION['username'];

/* -------------------------------------------
   HANDLE ACTIONS (POST ONLY)
--------------------------------------------*/
$action = $_POST['action'] ?? null;
$is_editing = ($action === "edit");

/* --- DELETE ENROLLMENT --- */
if ($action === "delete_enrollment" && isset($_POST['registration_id'])) {

    $stmt = $pdo->prepare("
        DELETE FROM seminar_registrations
        WHERE id = ?
          AND user_id = (
              SELECT id FROM users WHERE username = ?
          )
    ");

    $stmt->execute([
        $_POST['registration_id'],
        $current_username
    ]);

    if ($stmt->rowCount() > 0) {
        $success_msg = "Enrollment cancelled successfully.";
    } else {
        $error_msg = "Unable to cancel enrollment.";
    }
}

/* --- SAVE PROFILE --- */
if ($action === "save") {
    foreach ($_POST as $k => $v) {
        $_POST[$k] = trim($v) === "" ? null : trim($v);
    }

    $passwordHash = $_POST['password']
        ? password_hash($_POST['password'], PASSWORD_DEFAULT)
        : null;

    try {
        $new_username = $_POST['username'];

        $fields = [
            "name = :name",
            "surname = :surname",
            "username = :new_username",
            "gender = :gender",
            "birthdate = :birthdate",
            "email = :email",
            "country = :country",
            "postal_index = :postal_index",
            "street = :street",
            "phone = :phone",
            "updated_at = NOW()"
        ];

        $params = [
            ':name' => $_POST['name'],
            ':surname' => $_POST['surname'],
            ':new_username' => $new_username,
            ':gender' => $_POST['gender'],
            ':birthdate' => $_POST['birthdate'],
            ':email' => $_POST['email'],
            ':country' => $_POST['country'],
            ':postal_index' => $_POST['postal_index'],
            ':street' => $_POST['street'],
            ':phone' => $_POST['phone'],
            ':current_username' => $current_username,
        ];

        if ($passwordHash) {
            $fields[] = "password_hash = :password_hash";
            $params[':password_hash'] = $passwordHash;
        }

        $sql = "UPDATE users SET " . implode(", ", $fields) . "
                WHERE username = :current_username LIMIT 1";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        $_SESSION['username'] = $new_username;
        $success_msg = "Profile updated successfully!";
        $is_editing = false;

    } catch (PDOException $e) {
        $error_msg = "Database error: " . $e->getMessage();
    }
}

/* -------------------------------------------
   FETCH USER DATA
--------------------------------------------*/
$stmt = $pdo->prepare("
    SELECT id, username, name, surname, gender, birthdate, email, country,
           postal_index, street, phone, created_at, updated_at, is_active, role
    FROM users
    WHERE username = ?
    LIMIT 1
");
$stmt->execute([$_SESSION['username']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "<div class='register-msg-error'>User not found.</div>";
    exit;
}

/* -------------------------------------------
   FETCH USER ENROLLMENTS
--------------------------------------------*/
$stmt = $pdo->prepare("
    SELECT 
        r.id AS registration_id,
        r.registration_datetime,
        d.start_datetime,
        d.end_datetime,
        p.product_name,
        p.price
    FROM seminar_registrations r
    JOIN seminar_dates d ON r.seminar_date_id = d.id
    JOIN products p ON d.product_id = p.id
    WHERE r.user_id = ?
    ORDER BY r.registration_datetime DESC
");
$stmt->execute([$user['id']]);
$user_registrations = $stmt->fetchAll(PDO::FETCH_ASSOC);

function e($v)
{
    return htmlspecialchars((string) ($v ?? ''), ENT_QUOTES, 'UTF-8');
}
?>

<div class="user-panel-container">
    <h2>User Panel</h2>
    <p>Welcome, <strong><?= e($user['username']) ?></strong></p>

    <?php if (!empty($success_msg)): ?>
        <div class="register-msg-ok"><?= e($success_msg) ?></div>
    <?php endif; ?>

    <?php if (!empty($error_msg)): ?>
        <div class="register-msg-error"><?= e($error_msg) ?></div>
    <?php endif; ?>

    <!-- USER ACCOUNT DATA -->
    <form method="post" class="user-form">
        <input type="hidden" name="action" value="<?= $is_editing ? 'save' : '' ?>">

        <div class="user-info-grid">

            <!-- USERNAME -->
            <label class="user-info-item">
                <strong>Username:</strong><br>
                <?php if ($is_editing): ?>
                    <input type="text" name="username" value="<?= e($user['username']) ?>" required>
                <?php else: ?>
                    <?= e($user['username']) ?>
                <?php endif; ?>
            </label>

            <!-- PASSWORD -->
            <label class="user-info-item">
                <strong>Password:</strong><br>
                <?php if ($is_editing): ?>
                    <input type="password" name="password" placeholder="Leave empty to keep current password">
                <?php else: ?>
                    ********
                <?php endif; ?>
            </label>

            <!-- NAME -->
            <label class="user-info-item">
                <strong>Name:</strong><br>
                <?php if ($is_editing): ?>
                    <input type="text" name="name" value="<?= e($user['name']) ?>">
                <?php else: ?>
                    <?= e($user['name']) ?>
                <?php endif; ?>
            </label>

            <!-- SURNAME -->
            <label class="user-info-item">
                <strong>Surname:</strong><br>
                <?php if ($is_editing): ?>
                    <input type="text" name="surname" value="<?= e($user['surname']) ?>">
                <?php else: ?>
                    <?= e($user['surname']) ?>
                <?php endif; ?>
            </label>

            <!-- GENDER -->
            <label class="user-info-item">
                <strong>Gender:</strong><br>
                <?php if ($is_editing): ?>
                    <select name="gender">
                        <option value="Male" <?= $user['gender'] === "Male" ? "selected" : "" ?>>Male</option>
                        <option value="Female" <?= $user['gender'] === "Female" ? "selected" : "" ?>>Female</option>
                        <option value="Other" <?= $user['gender'] === "Other" ? "selected" : "" ?>>Other</option>
                    </select>
                <?php else: ?>
                    <?= e($user['gender']) ?>
                <?php endif; ?>
            </label>

            <!-- BIRTHDATE -->
            <label class="user-info-item">
                <strong>Birthdate:</strong><br>
                <?php if ($is_editing): ?>
                    <input type="date" name="birthdate" value="<?= e($user['birthdate'] ?? '') ?>">
                <?php else: ?>
                    <?= e($user['birthdate'] ?? '') ?>
                <?php endif; ?>
            </label>

            <!-- EMAIL -->
            <label class="user-info-item">
                <strong>Email:</strong><br>
                <?php if ($is_editing): ?>
                    <input type="email" name="email" value="<?= e($user['email']) ?>">
                <?php else: ?>
                    <?= e($user['email']) ?>
                <?php endif; ?>
            </label>

            <!-- COUNTRY -->
            <label class="user-info-item">
                <strong>Country:</strong><br>
                <?php if ($is_editing): ?>
                    <input type="text" name="country" value="<?= e($user['country'] ?? '') ?>">
                <?php else: ?>
                    <?= e($user['country'] ?? '') ?>
                <?php endif; ?>
            </label>

            <!-- POSTAL INDEX -->
            <label class="user-info-item">
                <strong>Postal Code:</strong><br>
                <?php if ($is_editing): ?>
                    <input type="text" name="postal_index" value="<?= e($user['postal_index'] ?? '') ?>">
                <?php else: ?>
                    <?= e($user['postal_index'] ?? '') ?>
                <?php endif; ?>
            </label>

            <!-- STREET -->
            <label class="user-info-item">
                <strong>Street:</strong><br>
                <?php if ($is_editing): ?>
                    <input type="text" name="street" value="<?= e($user['street'] ?? '') ?>">
                <?php else: ?>
                    <?= e($user['street'] ?? '') ?>
                <?php endif; ?>
            </label>

            <!-- PHONE -->
            <label class="user-info-item">
                <strong>Phone:</strong><br>
                <?php if ($is_editing): ?>
                    <input type="text" name="phone" value="<?= e($user['phone'] ?? '') ?>">
                <?php else: ?>
                    <?= e($user['phone'] ?? '') ?>
                <?php endif; ?>
            </label>

            <!-- READ-ONLY FIELDS -->
            <div class="user-info-item"><strong>Account Created:</strong><br><?= e($user['created_at'] ?? '') ?></div>
            <div class="user-info-item"><strong>Last Updated:</strong><br><?= e($user['updated_at'] ?? '') ?></div>
            <div class="user-info-item"><strong>Active:</strong><br><?= $user['is_active'] ? "Yes" : "No" ?></div>
            <div class="user-info-item"><strong>Role:</strong><br><?= e($user['role'] ?? '') ?></div>

        </div>

        <div class="profile-actions">
            <?php if ($is_editing): ?>
                <button type="submit" class="btn-primary">Save Changes</button>
                <button type="button" class="btn-danger" onclick="window.location.href='index.php?page=user-panel'">
                    Cancel
                </button>
            <?php else: ?>
                <button type="submit" name="action" value="edit" class="btn-primary">
                    Edit Profile
                </button>
                <button type="button" class="btn-danger" onclick="window.location.href='index.php?page=logout'">
                    Logout
                </button>
            <?php endif; ?>
        </div>
    </form>

    <!-- ENROLLMENTS -->
    <h3 class="enrollments-title">My Seminar Enrollments</h3>

    <?php if (!$user_registrations): ?>
        <p>You are not enrolled in any seminars yet.</p>
    <?php else: ?>
        <div class="enrollments-table-wrapper">
            <table class="enrollments-table">
                <thead>
                    <tr>
                        <th>Seminar</th>
                        <th>Price</th>
                        <th>Start</th>
                        <th>End</th>
                        <th>Enrolled</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($user_registrations as $reg): ?>
                        <tr>
                            <td><?= e($reg['product_name']) ?></td>
                            <td><?= number_format($reg['price'], 2) ?> €</td>
                            <td><?= e($reg['start_datetime']) ?></td>
                            <td><?= e($reg['end_datetime']) ?></td>
                            <td><?= e($reg['registration_datetime']) ?></td>
                            <td>
                                <form method="post" onsubmit="return confirm('Cancel this enrollment?');">
                                    <input type="hidden" name="action" value="delete_enrollment">
                                    <input type="hidden" name="registration_id" value="<?= (int) $reg['registration_id'] ?>">
                                    <button type="submit" class="btn-danger">
                                        Cancel
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>