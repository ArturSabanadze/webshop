<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../../Backend/register_handler.php';

$name = $name ?? '';
$surname = $surname ?? '';
$email = $email ?? '';
$gender = $gender ?? '';
$username = $username ?? '';
$birthdate = $birthdate ?? '';
$country = $country ?? '';
$postal_index = $postal_index ?? '';
$street = $street ?? '';
$phone = $phone ?? '';
$biography = $biography ?? '';

$error = $_SESSION['register_error'] ?? '';
$success_message = $_SESSION['register_success_message'] ?? '';
$success = $_SESSION['register_success'] ?? false;
?>

<div class="register-container">
    <?php if ($error): ?>
        <div class="register-msg-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="register-msg-ok">
            Registration successful! You can now <a href="index.php?page=login">login</a>.
        </div>
    <?php else: ?>
        <form method="post" action="" class="register-form">
            <input type="hidden" name="action" value="register">
            <div class="register-grid">
                <label>Name
                    <input type="text" name="name" required placeholder="Only letters and spaces allowed"
                        value="<?= htmlspecialchars($name) ?>">
                </label>

                <label>Surname
                    <input type="text" name="surname" required placeholder="Only letters and spaces allowed"
                        value="<?= htmlspecialchars($surname) ?>">
                </label>

                <label>Email
                    <input type="email" name="email" required placeholder="Your email"
                        value="<?= htmlspecialchars($email) ?>">
                </label>
                <label>Gender
                    <select name="gender">
                        <option value="" <?= $gender === '' ? 'selected' : '' ?>>Select</option>
                        <option value="male" <?= $gender === 'male' ? 'selected' : '' ?>>Male</option>
                        <option value="female" <?= $gender === 'female' ? 'selected' : '' ?>>Female</option>
                        <option value="other" <?= $gender === 'other' ? 'selected' : '' ?>>Other</option>
                    </select>
                </label>

                <label>Username
                    <input type="text" minlength="3" maxlength="32" name="username" required
                        placeholder="3-32 chars: letters, numbers, spaces, hyphens"
                        value="<?= htmlspecialchars($username) ?>">
                </label>

                <label>Password
                    <input type="password" name="password" required placeholder="Choose a strong password">
                </label>

                <label>Birthdate
                    <input type="date" name="birthdate" value="<?= htmlspecialchars($birthdate) ?>">
                </label>

                <label>Country
                    <input type="text" name="country" value="<?= htmlspecialchars($country) ?>">
                </label>

                <label>Postal Index
                    <input type="text" name="postal_index" value="<?= htmlspecialchars($postal_index) ?>">
                </label>

                <label>Street
                    <input type="text" name="street" value="<?= htmlspecialchars($street) ?>">
                </label>

                <label>Phone
                    <input type="text" name="phone" value="<?= htmlspecialchars($phone) ?>">
                </label>

                <label for="biography">Biography
                    <textarea name="biography" rows="5" style="width: 100%;" placeholder="Tell us something about yourself..."><?= htmlspecialchars($biography) ?></textarea>
                </label>

            </div>

            <button type="submit" class="register-btn-main">Register</button>

            <hr class="register-divider">

            <p class="register-login-text">Already have an account?</p>

            <button type="button" class="register-btn-secondary"
                onclick="window.location.href='index.php?page=login'">Login</button>
        </form>
    <?php endif; ?>
</div>