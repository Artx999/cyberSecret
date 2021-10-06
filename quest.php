<?php
require "func.php";
session_start();
$errors = new ErrorMsg();
$rootPath = "";
$_SESSION['fileName'] = "user";

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
    <title>Quest</title>
    <?php require "{$rootPath}structure/head/imports.php" ?>
    <script src="javascript/live-search.js" defer></script>
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

    <section id="quest-title" class="view-width">
        <div class="quest-header flexbox-col-left-start">
            <h3>Quest Name</h3>
            <p>Quest children</p>
        </div>
    </section>

    <section id="quest-description" class="view-width">
        <div class="quest-header flexbox-col-left-start">
            <p>Quest Description</p>
            <div class="quest-button">
                <button>Løs oppgave</button>
            </div>
        </div>
    </section>

    <section id="quest-files" class="view-width">
        <div class="quest-header flexbox-col-left-start">
            <a href="">Quest file</a>
        </div>
    </section>

</main>

</body>
<script>
    paceOptions = {
        elements: true
    };
</script>
</html>
