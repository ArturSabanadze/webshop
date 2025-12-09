<?php
$page = $_GET['page'] ?? 'home'; // default page

$allowedPages = [
    'home' => '../src/Includes/main.php',
    'shop' => '../src/Includes/shop.php',
    'membership' => '../src/Includes/membership.php',
    'about' => '../src/Includes/about.php',
    'login' => '../src/Includes/login.php',
    'register' => '../src/Includes/register.php',
    'logout' => '../src/Includes/logout.php',
    'contact' => '../src/Includes/contact.php',
    'impressum' => '../src/Includes/impressum.php',
    'terms' => '../src/Includes/terms.php'
];
if (array_key_exists($page, $allowedPages)) {

    include $allowedPages[$page];

} else {
    include '/src/Includes/main.php';
}