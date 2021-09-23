<?php
require "func.php";
session_start();
$rootPath = "";
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
    <title>Profile</title>
    <?php require "{$rootPath}structure/head/imports.php" ?>
</head>
<body>

<!-- Loading - Pace -->
<div class="pace">
    <div class="pace-progress"></div>
</div>

<!-- Main -->
<main id="main" class="flexbox-col">

    <form class="search-wrapper view-width flexbox-col-left-start" method="get" action="">
        <label class="search-label" for="username">Søk etter brukere</label>
        <div class="search-input-wrapper flexbox">
            <input id="username" type="search" class="search-input" placeholder="Fyll inn brukernavn" name="username" aria-label="" required>
            <button class="search-button flexbox"><span class="material-icons">search</span></button>
        </div>
    </form>

    <div class="search-output">

        <?php
        if (isset($_GET["username"]) && $_GET["username"]) {
            $username = stripslashes(htmlspecialchars($_GET["username"]));
            $result = dbQuery("SELECT * FROM lanmine_noneon.user WHERE username='$username'");

            while ($res = $result->fetch_assoc()) {

                print $res["username"] . "</br>";
                print $res["card_id"];
            }
        }
        ?>

    </div>

</main>

</body>
<script>
    paceOptions = {
        elements: true
    };
</script>
</html>
