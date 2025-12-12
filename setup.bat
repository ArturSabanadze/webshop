@echo off
echo ===============================
echo Webshop Setup Script
echo ===============================

:: -------------------------------
:: Pfade setzen
:: -------------------------------
set XAMPP_PATH=C:\xampp
set Htdocs_PATH=%XAMPP_PATH%\htdocs
set SQL_PATH=%~dp0Initializer\
set DummyData_PATH=%SQL_PATH%Dummy\
set CSV_PATH=%~dp0Initializer\Dummy\products_for_xampp.csv

:: -------------------------------
:: Webshop-Ordner erstellen
:: -------------------------------
mkdir "%Htdocs_PATH%\Die_Fantastische_4"
set Project_PATH=%Htdocs_PATH%\Die_Fantastische_4

:: -------------------------------
:: Prüfen, ob XAMPP existiert
:: -------------------------------
if not exist "%XAMPP_PATH%" (
    echo XAMPP-Pfad nicht gefunden: %XAMPP_PATH%
    pause
    exit /b
)

:: -------------------------------
:: Backend kopieren
:: -------------------------------
echo Kopiere Backend nach %Project_PATH%\Backend...
C:\Windows\System32\xcopy.exe /E /I /Y "%~dp0Backend" "%Project_PATH%\Backend"

:: -------------------------------
:: Frontend kopieren
:: -------------------------------
echo Kopiere Frontend nach %Project_PATH%\Frontend...
C:\Windows\System32\xcopy.exe /E /I /Y "%~dp0Frontend" "%Project_PATH%\Frontend"

:: -------------------------------
:: Documentation kopieren
:: -------------------------------
echo Kopiere Frontend nach %Project_PATH%\Documentation...
C:\Windows\System32\xcopy.exe /E /I /Y "%~dp0Documentation" "%Project_PATH%\Documentation"

:: -------------------------------
:: Prüfen, ob mysql.exe existiert
:: -------------------------------
if not exist "%XAMPP_PATH%\mysql\bin\mysql.exe" (
    echo mysql.exe nicht gefunden!
    pause
    exit /b
)

:: -------------------------------
:: Datenbank erstellen
:: -------------------------------
echo Erstelle Datenbank 'webshop'...
"%XAMPP_PATH%\mysql\bin\mysql.exe" -u root -e "CREATE DATABASE IF NOT EXISTS webshop;"

:: -------------------------------
:: Initial-SQL importieren
:: -------------------------------
echo Importiere Initial SQL ...
"%XAMPP_PATH%\mysql\bin\mysql.exe" -u root webshop < "%SQL_PATH%db_schema.sql"

:: -------------------------------
:: CSV-Datei in products importieren
:: -------------------------------
echo Importiere products.csv ...
"%XAMPP_PATH%\mysql\bin\mysql.exe" -u root webshop -e "LOAD DATA LOCAL INFILE '%CSV_PATH:\=/%' INTO TABLE products FIELDS TERMINATED BY ';' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\r\n' IGNORE 1 LINES (product_name, image_url, description, price, min_capacity, max_capacity, start_date, end_date, valid_to_start, available_for_reservation);"


:: -------------------------------
:: Restliche Dummy-Daten importieren
:: -------------------------------
echo Importiere Dummy Daten ...
"%XAMPP_PATH%\mysql\bin\mysql.exe" -u root webshop < "%SQL_PATH%dummy_data.sql"


:: -------------------------------
:: Fertig
:: -------------------------------
echo Setup abgeschlossen!
pause
