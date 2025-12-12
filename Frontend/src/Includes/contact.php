<?php
require_once __DIR__ . '/../Functions/save_contact_messages.php';

$error = "";
$captchaCorrect = false;
$formSubmitted = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_contact'])) {
    $formSubmitted = true;

    // Validate captcha
    if (trim($_POST['captcha']) === "7") {
        $captchaCorrect = true;

        // ----- Sanitization -----
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $message = strip_tags($_POST['message']); // entfernt HTML, behält Text

        // Validierung
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Bitte eine gültige E-Mail-Adresse eingeben.";
            $captchaCorrect = false;
        }

        if (strlen(trim($name)) < 2) {
            $error = "Bitte einen gültigen Namen eingeben.";
            $captchaCorrect = false;
        }

        if (strlen(trim($message)) < 5) {
            $error = "Bitte eine aussagekräftige Nachricht eingeben.";
            $captchaCorrect = false;
        }

    } else {
        $error = "Das Captcha ist falsch. Bitte erneut versuchen.";
    }
}
?>
<section class="main-container">
    <div class="content-contact-page">
        <h1>Kontakt</h1>
        <p>Sie haben Fragen zu unseren Seminaren oder Ihrem Zugang? Schreiben Sie uns gern eine Nachricht.</p>

        <?php if (!$formSubmitted || !$captchaCorrect): ?>


            <!-- Sichere sanitizierte Kontakt formular -->
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
                    <textarea id="contact_message" name="message"
                        required><?= isset($_POST['message']) ? htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8') : '' ?></textarea>
                </div>

                <!-- Captcha -->
                <div class="form-group">
                    <label for="contact_captcha">Was ist 3 + 4? (Anti-Spam)</label>
                    <input type="text" id="contact_captcha" name="captcha" required>
                </div>

                <?php if ($formSubmitted && !$captchaCorrect): ?>
                    <p style="color:red; font-weight:bold;"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
                <?php endif; ?>

                <button type="submit" name="send_contact" class="login-btn-main">Nachricht senden</button>
            </form>

        <?php else: ?>

            <?php
            // Save message to serialized data file
            // Die Werte wurden oben bereits sanitiziert & validiert
            $caseId = saveContactMessage($name, $email, $message);
            ?>

            <p class="info-message">
                Vielen Dank für Ihre Nachricht. <br>
                Ihr Ticket wurde erfolgreich erstellt.<br>
                <strong>Fallnummer (Case ID): <?= htmlspecialchars($caseId, ENT_QUOTES, 'UTF-8') ?></strong>
            </p>

        <?php endif; ?>

    </div>
</section>