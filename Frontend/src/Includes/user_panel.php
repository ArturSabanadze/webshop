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

        $user_fields = [
            "username = :new_username",
            "email = :email",
        ];

        $user_profile_fields = [
            "name = :name",
            "surname = :surname",
            "gender = :gender",
            "birthdate = :birthdate",
            "phone = :phone",
        ];

        $user_adresses_fields = [
            "country = :country",
            "zip_code = :zip_code",
            "street = :street",
            "street_number = :street_number",
        ];

        $params = [
            ':name' => $_POST['name'],
            ':surname' => $_POST['surname'],
            ':new_username' => $new_username,
            ':gender' => $_POST['gender'],
            ':birthdate' => $_POST['birthdate'],
            ':email' => $_POST['email'],
            ':country' => $_POST['country'],
            ':zip_code' => $_POST['zip_code'],
            ':province' => $_POST['province'],
            ':street' => $_POST['street'],
            ':street_number' => $_POST['street_number'],
            ':phone' => $_POST['phone'],
            ':current_username' => $current_username,
        ];

        if ($passwordHash) {
            $user_fields[] = "password_hash = :password_hash";
            $params[':password_hash'] = $passwordHash;
        }

        $sql = "UPDATE users SET " . implode(", ", $user_fields) . "
                WHERE username = :current_username LIMIT 1";
        $sql .= " ; UPDATE users_profiles SET " . implode(", ", $user_profile_fields) . "
                WHERE user_id = (SELECT id FROM users WHERE username = :current_username) LIMIT 1";
        $sql .= " ; UPDATE users_addresses SET " . implode(", ", $user_adresses_fields) . "
                WHERE user_id = (SELECT id FROM users WHERE username = :current_username) LIMIT 1";

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
    SELECT u.id, u.username, up.name, up.surname, up.gender, up.birthdate, u.email, ua.country,
           ua.zip_code, ua.province, ua.street, ua.street_number, up.phone, up.profile_img_url, u.role
    FROM users u
    LEFT JOIN users_profiles up ON u.id = up.user_id
    LEFT JOIN users_addresses ua ON u.id = ua.user_id
    WHERE u.username = ?
    LIMIT 1
");
$stmt->execute([$_SESSION['username']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "<div class='register-msg-error'>User not found.</div>";
    exit;
}

function e($v)
{
    return htmlspecialchars((string) ($v ?? ''), ENT_QUOTES, 'UTF-8');
}
?>

<div class="user-panel-container">
    <?php if (!empty($success_msg)): ?>
        <div class="register-msg-ok"><?= e($success_msg) ?></div>
    <?php endif; ?>

    <?php if (!empty($error_msg)): ?>
        <div class="register-msg-error"><?= e($error_msg) ?></div>
    <?php endif; ?>

    
    <p>Welcome, <strong><?= e($user['username']) ?></strong></p>
    <div class="profile-image-container">
    <img src="<?= e($user['profile_img_url'] ?? 'assets/default_profile.png') ?>" alt="Profile Image" class="profile-image">
    </div>
    
        <h2>User Panel</h2>
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
                <strong>Zip Code:</strong><br>
                <?php if ($is_editing): ?>
                    <input type="text" name="zip_code" value="<?= e($user['zip_code'] ?? '') ?>">
                <?php else: ?>
                    <?= e($user['zip_code'] ?? '') ?>
                <?php endif; ?>
            </label>

            <!-- PROVINCE -->
            <label class="user-info-item">
                <strong>Province:</strong><br>
                <?php if ($is_editing): ?>
                    <input type="text" name="province" value="<?= e($user['province'] ?? '') ?>">
                <?php else: ?>
                    <?= e($user['province'] ?? '') ?>
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

            <!-- STREET NUMBER -->
            <label class="user-info-item">
                <strong>Street Number:</strong><br>
                <?php if ($is_editing): ?>
                    <input type="text" name="street_number" value="<?= e($user['street_number'] ?? '') ?>">
                <?php else: ?>
                    <?= e($user['street_number'] ?? '') ?>
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

    
</div>