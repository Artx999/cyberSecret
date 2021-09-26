<?php
require "func.php";
session_start();
$errors = new ErrorMsg();
$rootPath = "";

if (isset($_SESSION["user"])) {
    $currentUser = User::sessionGet();
}

?>
<!DOCTYPE html>
<html lang="no">
<head>
    <!-- Meta Tags -->
    <?php require "{$rootPath}structure/head/meta.php" ?>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <!-- ======= -->
    <!-- General -->
    <title>Admin Panel</title>
    <?php require "{$rootPath}structure/head/imports.php" ?>
</head>
<body>

<!-- Loading - Pace -->
<div class="pace">
    <div class="pace-progress"></div>
</div>

<!-- Navbar -->
<?php require "structure/items/navbar.php"; ?>

<!-- Main -->
<main id="main" class="flexbox-col-start-center">

    <section class="admin-panel">



    </section>

</main>

</body>
<script>
    paceOptions = {
        elements: true
    };
</script>
</html>
