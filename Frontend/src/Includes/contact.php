<?php
require_once __DIR__ . '/../Functions/save_contact_messages.php';
?>
<section class="main-container">
    <div class="content-contact-page">
        <h1>Kontakt</h1>
        <p>Sie haben Fragen zu unseren Seminaren oder Ihrem Zugang? Schreiben Sie uns gern eine Nachricht.</p>

        <form method="post" action="index.php?page=contact">
            <div class="form-group">
                <label for="contact_name">Name</label>
                <input type="text" id="contact_name" name="name" required>
            </div>

            <div class="form-group">
                <label for="contact_email">E-Mail</label>
                <input type="email" id="contact_email" name="email" required>
            </div>

            <div class="form-group">
                <label for="contact_message">Nachricht</label>
                <textarea id="contact_message" name="message" required></textarea>
            </div>

            <button type="submit" name="send_contact" class="login-btn-main">Nachricht senden</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_contact'])) {
            require_once __DIR__ . '/../Functions/save_contact_messages.php';

            $name = $_POST['name'];
            $email = $_POST['email'];
            $message = $_POST['message'];

            $caseId = saveContactMessage($name, $email, $message);

            echo '<p class="info-message">
                    Vielen Dank für Ihre Nachricht. <br>
                    Ihr Ticket wurde erfolgreich erstellt.<br>
                    <strong>Fallnummer (Case ID): ' . htmlspecialchars($caseId) . '</strong>
                  </p>';
        }
        ?>
    </div>
</section>