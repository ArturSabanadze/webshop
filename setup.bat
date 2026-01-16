@echo off
echo ===============================
echo Webshop App Setup Script
echo ===============================

:: -------------------------------
:: Pfade setzen
:: -------------------------------
set XAMPP_PATH=C:\xampp
set Htdocs_PATH=%XAMPP_PATH%\htdocs
set SQL_PATH=%~dp0Setup\
set DummyData_PATH=%SQL_PATH%Setup\

:: -------------------------------
:: Webshop-Ordner erstellen
:: -------------------------------
mkdir "%Htdocs_PATH%\gruppe1"
set Project_PATH=%Htdocs_PATH%\gruppe1

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
echo Erstelle Datenbank 'gruppe1'...
"%XAMPP_PATH%\mysql\bin\mysql.exe" -u root -e "CREATE DATABASE IF NOT EXISTS gruppe1;"

:: -------------------------------
:: Initial-SQL importieren
:: -------------------------------
echo Importiere Initial SQL ...
"%XAMPP_PATH%\mysql\bin\mysql.exe" -u root gruppe1 < "%SQL_PATH%db_schema.sql"

:: -------------------------------
:: Restliche Dummy-Daten importieren
:: -------------------------------
echo Importiere Dummy Daten ...
"%XAMPP_PATH%\mysql\bin\mysql.exe" -u root gruppe1 < "%SQL_PATH%dummy_data.sql"


:: -------------------------------
:: Fertig
:: -------------------------------
echo Setup abgeschlossen!
pause
