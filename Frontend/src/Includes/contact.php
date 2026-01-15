<?php
require_once __DIR__ . '/../Functions/save_contact_messages.php';

$error = "";
$captchaCorrect = false;
$formSubmitted = false;
$success = isset($_GET['success']);
$caseId = $_GET['caseId'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_contact'])) {
    $formSubmitted = true;

    // Validate captcha
    if (trim($_POST['captcha']) === "7" && isset($_SESSION['username'])) {
        $captchaCorrect = true;

        // ----- Sanitization -----
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $message = strip_tags($_POST['message']); // entfernt HTML, behält Text

        // Validierung
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Please enter a valid email address.";
            $captchaCorrect = false;
        }

        //strlen method to count characters in name
        if (strlen(trim($name)) < 2) {
            $error = "Please enter a valid name.";
            $captchaCorrect = false;
        }

        //strlen method to count characters in message
        if (strlen(trim($message)) < 10) {
            $error = "Please enter a message with at least 10 characters.";
            $captchaCorrect = false;
        }

        // Wenn alles korrekt: speichern & redirect
        if ($captchaCorrect) {
            $caseId = saveContactMessage($name, $email, $message);
            header("Location: index.php?page=contact&success=1&caseId=" . urlencode($caseId));
            exit;
        }

    } else {
        $error = "Captcha is incorrect or user not logged in. Please try again.";
    }
}
?>

<section class="main-container">
    <?php if ($success): ?>

        <p class="info-message">
            Vielen Dank für Ihre Nachricht. <br>
            Ihr Ticket wurde erfolgreich erstellt.<br>
            <strong>Fallnummer (Case ID): <?= htmlspecialchars($caseId) ?></strong>
        </p>

    <?php else: ?>
        <div class="content-contact-page">
            <h1>Contact</h1>
            <p>If you have questions about our seminars or your access, please feel free to send us a message.</p>

            <!-- Form -->
            <form method="post" action="index.php?page=contact">

                <div class="form-group">
                    <label for="contact_name">Name</label>
                    <input type="text" id="contact_name" name="name" required
                        value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8') : '' ?>">
                </div>

                <div class="form-group">
                    <label for="contact_email">E-Mail</label>
                    <input type="email" id="contact_email" name="email" required
                        value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8') : '' ?>">
                </div>

                <div class="form-group">
                    <label for="contact_message">Nachricht</label>
                    <textarea id="contact_message" name="message" required><?=
                        isset($_POST['message']) ? htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8') : ''
                        ?></textarea>
                </div>

                <div class="form-group">
                    <label for="contact_captcha">Was ist 3 + 4? (Anti-Spam)</label>
                    <input type="text" id="contact_captcha" name="captcha" required>
                </div>

                <?php if ($formSubmitted && !$captchaCorrect): ?>
                    <p style="color:red; font-weight:bold;"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
                <?php endif; ?>

                <button type="submit" name="send_contact" class="login-btn-main">Nachricht senden</button>
            </form>
        </div>
    <?php endif; ?>
</section>