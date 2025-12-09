<?php
// Kontakt-Seite
?>
<section class="content contact-page">
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

        <button type="submit" name="send_contact">Nachricht senden</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_contact'])) {
        // In einer echten Anwendung würde hier z.B. eine E-Mail versendet oder in der Datenbank gespeichert.
        echo '<p class="info-message">Vielen Dank für Ihre Nachricht. Wir werden uns zeitnah bei Ihnen melden.</p>';
    }
    ?>
</section>
