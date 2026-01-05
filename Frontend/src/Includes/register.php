<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../../Backend/register_handler.php';


$email = $email ?? '';
$username = $username ?? '';

$name = $name ?? '';
$surname = $surname ?? '';
$biography = $biography ?? '';
$profile_img_url = $profile_img_url ?? '';
$gender = $gender ?? '';
$phone = $phone ?? '';
$birthdate = $birthdate ?? '';

$type = $type ?? '';
$street = $street ?? '';
$street_number = $street_number ?? '';
$state = $state ?? '';
$province = $province ?? '';
$country = $country ?? '';
$zip_code = $zip_code ?? '';

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
                <!-- Users fields -->

                <label>Username
                    <input type="text" minlength="3" maxlength="32" name="username" required
                        placeholder="3-32 chars: letters, numbers, spaces, hyphens" autocomplete="username"
                        value="<?= htmlspecialchars($username) ?>">
                </label>

                <label>Password
                    <input type="password" name="password" autocomplete="new-password" required placeholder="Choose a strong password">
                </label>
                
                <label>Email
                    <input type="email" name="email" autocomplete="email" required placeholder="Your email"
                        value="<?= htmlspecialchars($email) ?>">
                </label>                

                <!-- User profile fields -->
                <label>Name
                    <input type="text" name="name" autocomplete="name" required placeholder="Only letters and spaces allowed"
                        value="<?= htmlspecialchars($name) ?>">
                </label>

                <label>Surname
                    <input type="text" name="surname" autocomplete="family-name" required placeholder="Only letters and spaces allowed"
                        value="<?= htmlspecialchars($surname) ?>">
                </label>

                <label>Gender
                    <select name="gender">
                        <option value="" <?= $gender === '' ? 'selected' : '' ?>>Select</option>
                        <option value="male" <?= $gender === 'male' ? 'selected' : '' ?>>Male</option>
                        <option value="female" <?= $gender === 'female' ? 'selected' : '' ?>>Female</option>
                        <option value="other" <?= $gender === 'other' ? 'selected' : '' ?>>Other</option>
                    </select>
                </label>

                <label>Birthdate
                    <input type="date" name="birthdate" value="<?= htmlspecialchars($birthdate) ?>">
                </label>

                <label>Phone
                    <input type="text" name="phone" autocomplete="tel" value="<?= htmlspecialchars($phone) ?>">
                </label>

                <label>Profile Image
                    <input type="file" name="profile_img_url" value="<?= htmlspecialchars($profile_img_url) ?>">
                </label>

                <label>Biography
                    <textarea name="biography" rows="5" style="width: 100%;" placeholder="Tell us something about yourself..."><?= htmlspecialchars($biography) ?></textarea>
                </label>

                <!-- Address fields -->
                 <label>Private / Business type
                    <select name="type">
                        <option value="" <?= $type === '' ? 'selected' : '' ?>>Select</option>
                        <option value="private" <?= $type === 'private' ? 'selected' : '' ?>>Private</option>
                        <option value="business" <?= $type === 'business' ? 'selected' : '' ?>>Business</option>
                        <option value="general" <?= $type === 'general' ? 'selected' : '' ?>>General</option>
                    </select>
                </label>

                <label>Street
                    <input type="text" name="street" autocomplete="address-line1" value="<?= htmlspecialchars($street) ?>">
                </label>

                <label>Street Nr.
                    <input type="number" name="street_number" autocomplete="address-line2" value="<?= htmlspecialchars($street_number) ?>">
                </label>

                <label>State
                    <input type="text" name="state" autocomplete="address-level1" value="<?= htmlspecialchars($state) ?>">
                </label>

                <label>Province
                    <input type="text" name="province" autocomplete="address-level2" value="<?= htmlspecialchars($province) ?>">
                </label>

                <label>Country
                    <input type="text" name="country" autocomplete="country" value="<?= htmlspecialchars($country) ?>">
                </label>

                <label>Postal Index
                    <input type="text" name="zip_code" autocomplete="postal-code" value="<?= htmlspecialchars($zip_code) ?>">
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