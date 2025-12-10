# Webshop

## Projektbeschreibung

Dieses Projekt ist ein einfacher Webshop, der es Benutzern ermöglicht, Produkte zu durchsuchen, in den Warenkorb zu legen und Bestellungen aufzugeben. Das Ziel ist es, eine benutzerfreundliche und performante Plattform für den Online-Handel bereitzustellen.

## Hauptfunktionalitäten

### 1. **Produktanzeige**

- **Datei:** `Frontend/src/Includes/main.php`
- **Beschreibung:** Diese Komponente zeigt eine Grid aller verfügbaren Produkte an. Sie ruft die Produktdaten von der Datenbank ab und rendert sie in einer übersichtlichen Kartenansicht.

### 2. **Produktsuche**

- **Datei:** `Frontend/src/Includes/shop.php`,
  `Frontend/src/Functions/product_card_loader.php`
- **Beschreibung:** Ermöglicht Benutzern, Produkte anhand von Schlüsselwörtern, Categorien zu suchen und nach Preise sortieren. Die Suchanfragen werden mit hilfe der getFilteredProducts funktion verarbeitet.

### 4. **Enrollprozess**

- **Datei:** `Frontend/src/Includes/shop.php`
- **Beschreibung:** Führt den Benutzer durch den Enrolllprozess. ajax_enroll.php und ajax_get_seminar_dates.php sind hier die verantwortliche APIs für die verarbeitung der verfügbare Seminare und Enroll anfragen.

### 5. **Benutzerregistrierung und -an und abmeldung**

- **Datei:** `Frontend/src/Includes/login.php`,
  `Frontend/src/Includes/register.php`,
  `Frontend/src/Includes/logout.php`,
  `Backend/login_handler.php`,
  `Backend/register_handler.php`
- **Beschreibung:** Ermöglicht Benutzern, sich zu registrieren oder anzumelden. Die Authentifizierung erfolgt über ein Token-basiertes System.

### 6. **AdminPanel Schnittstelle**

- **Datei:** `Frontend/AdminDashboard/*`
- **Beschreibung:** Admin Panel für Seminare und Termine verwaltung.

## Installation und Ausführung

1. **Repository klonen:**
   ```bash
   git clone https://github.com/ArturSabanadze/webshop.git
   ```
2. **Software installieren:**
   ```bash
   xampp runterladen und installieren (Apache + Mysql)
   ```
3. **Entwicklungsserver starten:**
   ```bash
   Apache und Mysql in xampp panel starten
   Mysql muss kein password enthalten (oder password entsprechend in Backend/config/.env datei sowie auch in setup.bat anpassen)
   ```
4. **Entwicklungsserver starten:**
   setup.bat ausführen um den Projekt ordner in xampp automatisch zu kopieren, Datenbank mit test daten initialisieren.
   in Browser über den link http://localhost/Die_Fantastische_4/Frontend/public/index.php öffnen.

## Lizenz

Dieses Projekt steht unter der [MIT-Lizenz](LICENSE).
