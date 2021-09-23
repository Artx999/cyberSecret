<?php
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
<main id="main" class="flexbox">

    <form class="search-wrapper view-width flexbox-col-left-start" method="post" action="backend/searchSys.php">
        <label class="search-label" for="search">Søk etter brukere</label>
        <div class="search-input-wrapper flexbox">
            <input id="search" type="search" class="search-input" placeholder="Fyll inn brukernavn" name="search" aria-label="" required>
            <button class="search-button flexbox"><span class="material-icons">search</span></button>
        </div>
    </form>

    <div class="search-output">
        <?php

        $url = 'http://'. $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
        $parts = explode('=', $url);
        $path = $parts[1];

        print '<p style="color: hsl(var(--white));">url = ' . $path . '</p>';

        $result = dbQuery("SELECT * FROM lanmine_noneon.user WHERE username='$path'");

        while ($res = $result->fetch_assoc()) {
            $username = $res["username"];
            $cardId = $res["cardId"];
        }

        print $username;
        print $cardId;

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
