<?php
session_start();
require_once '../../Backend/db_connection.php';

// Redirect if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: index.php?page=login");
    exit;
}

$username = $_SESSION['username'];

/* -------------------------------------------
   HANDLE ACTIONS (POST ONLY)
--------------------------------------------*/
$action = $_POST['action'] ?? null;
$is_editing = ($action === "edit");
$is_saved = ($action === "save");

if ($action === "save") {

    foreach ($_POST as $k => $v) {
        $_POST[$k] = trim($v) === "" ? null : trim($v);
    }

    try {
        $stmt = $pdo->prepare("
            UPDATE users SET
                name = :name,
                surname = :surname,
                gender = :gender,
                birthdate = :birthdate,
                email = :email,
                country = :country,
                postal_index = :postal_index,
                street = :street,
                phone = :phone,
                updated_at = NOW()
            WHERE username = :username
            LIMIT 1
        ");

        $stmt->execute([
            ':name' => $_POST['name'],
            ':surname' => $_POST['surname'],
            ':gender' => $_POST['gender'],
            ':birthdate' => $_POST['birthdate'],
            ':email' => $_POST['email'],
            ':country' => $_POST['country'],
            ':postal_index' => $_POST['postal_index'],
            ':street' => $_POST['street'],
            ':phone' => $_POST['phone'],
            ':username' => $username
        ]);


        $success_msg = "Profile updated successfully!";
        $is_editing = false;

    } catch (PDOException $e) {
        $error_msg = "Database error: " . $e->getMessage();
    }
}

/* -------------------------------------------
   FETCH USER RECORD
--------------------------------------------*/
$stmt = $pdo->prepare("
    SELECT id, username, name, surname, gender, birthdate, email, country,
           postal_index, street, phone, created_at, updated_at, is_active, role
    FROM users
    WHERE username = ?
    LIMIT 1
");

$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "<div class='register-msg-error'>User not found.</div>";
    exit;
}
//Helper function for escaping output
function e($value)
{
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
}
?>

<div class="user-panel-container">
    <h2>User Panel</h2>
    <p>Welcome, <strong><?= e($user['username']) ?></strong></p>

    <?php if (!empty($success_msg)): ?>
        <div id="successMessage" class="register-msg-ok"><?= e($success_msg) ?></div>
    <?php endif; ?>
    <script>
        setTimeout(() => {
            const msg = document.getElementById("successMessage");
            if (msg) msg.style.display = "none";
        }, 3000);
    </script>

    <?php if (!empty($error_msg)): ?>
        <div id="errorMessage" class="register-msg-error"><?= e($error_msg) ?></div>
    <?php endif; ?>

    <script>
        setTimeout(() => {
            const msg = document.getElementById("errorMessage");
            if (msg) msg.style.display = "none";
        }, 3000);
    </script>

    <form method="post">

        <input type="hidden" name="action" value="<?= $is_editing ? 'save' : '' ?>">

        <div class="user-info-grid">

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
            <div class="user-info-item"><strong>Account
                    Created:</strong><br><?= e($user['created_at'] ?? '') ?></div>
            <div class="user-info-item"><strong>Last
                    Updated:</strong><br><?= e($user['updated_at'] ?? '') ?>
            </div>
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
                <button type="button" onclick="window.location.href='index.php?page=logout'" class="btn-danger">
                    Logout
                </button>
            <?php endif; ?>
        </div>

    </form>
</div>