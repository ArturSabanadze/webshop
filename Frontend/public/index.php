<?php
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
    <!-- =========================
            NAVBAR TEMPLATE
        ========================== -->
    <?php include $incl_path . 'navigationbar.php'; ?>
    <!-- =========================
             HEADER TEMPLATE
        ========================== -->
    <?php include $incl_path . 'header.php'; ?>
    <!-- =========================
             MAIN TEMPLATE
        ========================== -->
    <?php include $content_generator; ?>
    <!-- =========================
             FOOTER TEMPLATE
        ========================== -->
    <?php include $incl_path . 'footer.php'; ?>
</body>

</html>