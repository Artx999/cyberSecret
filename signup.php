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
    <title>Registrer deg</title>
    <?php require "{$rootPath}structure/head/imports.php" ?>
    <script src="javascript/signup.js" defer></script>
</head>
<body>

<!-- Loading - Pace -->
<div class="pace">
    <div class="pace-progress"></div>
</div>

<!-- Main -->
<main id="main" class="flexbox-col">

    <form class="user-form view-width flexbox-col" method="post" action="backend/signupSys.php">
        <div class="user-form-top">
            <h2>Registrer deg</h2>
            <a href="login.php">Eller login</a>
        </div>
        <?php

        require "func.php";
        if (isset($_GET["error"])) {
            print ErrorMsg::decode($_GET["error"]); // Prints error messages
        }

        ?>
        <div class="user-form-center">
            <fieldset class="input-grid inpt-grd-2">
                <div class="input-wrapper ufi-input-wrapper">
                    <label for="username">Brukernavn* (Maks 25)</label>
                    <div class="ufi-input-inner flexbox">
                        <span class="material-icons">person</span>
                        <input id="username" type="text" class="ufi-input" placeholder="Brukernavn" name="username" aria-label="" required>
                    </div>
                </div>
                <div class="input-wrapper ufi-input-wrapper">
                    <label for="cardID">ID-nummer* (Maks <?php print Info::maxID() ?>)</label>
                    <div class="ufi-input-inner flexbox">
                        <span class="material-icons">fact_check</span>
                        <input id="cardID" type="number" class="ufi-input" placeholder="ID-nummer" name="cardID" min="1" max="<?php print Info::maxID()?>" aria-label="" <?php if (isset($_GET["id"])) print "value='{$_GET["id"]}' readonly" ?>required>
                    </div>
                </div>
            </fieldset>
            <fieldset class="input-grid inpt-grd-2">
                <div class="input-wrapper ufi-input-wrapper">
                    <label for="password">Passord* (Maks 255)</label>
                    <div class="ufi-input-inner flexbox">
                        <span class="material-icons">password</span>
                        <input id="password" type="password" class="ufi-input" placeholder="Passord" name="password" aria-label="" required>
                    </div>
                </div>
                <div class="input-wrapper ufi-input-wrapper">
                    <label for="confirmPassword">Gjenta Passord*</label>
                    <div class="ufi-input-inner flexbox">
                        <span class="material-icons">password</span>
                        <input id="confirmPassword" type="password" class="ufi-input" placeholder="Gjenta Passord" name="confirmPassword" aria-label="" required>
                    </div>
                </div>
            </fieldset>
            <fieldset class="input-grid inpt-grd-2">
                <div class="input-wrapper ufi-input-wrapper">
                    <label for="firstName">Fornavn</label>
                    <div class="ufi-input-inner flexbox">
                        <span class="material-icons">badge</span>
                        <input id="firstName" type="text" class="ufi-input" placeholder="Fornavn" name="firstName" aria-label="" required>
                    </div>
                </div>
                <div class="input-wrapper ufi-input-wrapper">
                    <label for="lastName">Etternavn</label>
                    <div class="ufi-input-inner flexbox">
                        <span class="material-icons">badge</span>
                        <input id="lastName" type="text" class="ufi-input" placeholder="Etternavn" name="lastName" aria-label="" required>
                    </div>
                </div>
            </fieldset>
            <fieldset class="input-grid inpt-grd-1">
                <div class="input-wrapper ufi-input-wrapper">
                    <label for="password">Terms of service*</label>
                    <div class="ufi-input-inner-check flexbox-left">
                        <input id="" type="checkbox" class="ufi-input-check" name="" aria-label="" required>
                        <p>For å registrere deg må du akseptere våre <a href="">terms of service</a></p>
                    </div>
                </div>
            </fieldset>
            <fieldset class="input-grid inpt-grd-2">
                <div class="ufi-button-wrapper">
                    <button id="submit" type="submit" class="ufi-button flexbox">
                        Lag bruker
                    </button>
                </div>
            </fieldset>
        </div>
    </form>

</main>

</body>
<script>
    paceOptions = {
        elements: true
    };
</script>
</html>