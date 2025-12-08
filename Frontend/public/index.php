<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$error = $_SESSION['login_error'] ?? '';
$success_message = $_SESSION['login_success'] ?? '';
$success = !empty($success_message);

// Clear flash messages
unset($_SESSION['login_error']);
unset($_SESSION['login_success']);
include_once '../src/Functions/css_loader.php';
$incl_path = "../src/Includes/";
$content_generator = "../src/Controllers/component_handler.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AcademiaHub</title>
    <!-- loading css styles -->
    <?php echo $css_loader; ?>
</head>

<body>

    <header>
        <!--NAVBAR -->
        <?php include $incl_path . 'navigationbar.php'; ?>
        <!--HEADER-->
        <?php include $incl_path . 'header.php'; ?>
    </header>

    <main>
        <!--MAIN-->
        <?php include $content_generator; ?>
    </main>

    <footer>
        <!--FOOTER-->
        <?php include $incl_path . 'footer.php'; ?>
    </footer>
</body>

</html>