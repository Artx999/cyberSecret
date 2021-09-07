<?php
session_start();
if (isset($_SESSION["user"])) header("Location: index.php");
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
    <title>Login</title>
    <?php require "{$rootPath}structure/head/imports.php" ?>
</head>
<body>

<!-- Loading - Pace -->
<div class="pace">
    <div class="pace-progress"></div>
</div>

<!-- Main -->
<main id="main" class="flexbox-col">

    <form class="user-form view-width flexbox-col" method="post" action="backend/loginSys.php">
        <div class="user-form-top">
            <h2>Login</h2>
            <a href="signup.php">Eller register deg</a>
        </div>
        <?php

        require "func.php";
        if (isset($_GET["error"])) {
            print '<p class="error-msg flexbox-left"><span class="material-icons">warning</span>' . ErrorMsg::decode($_GET["error"]) . '</p>'; // Prints error messages
        }

        ?>
        <div class="user-form-center">
            <fieldset class="input-grid inpt-grd-2">
                <div class="input-wrapper ufi-input-wrapper">
                    <label for="username">Brukernavn*</label>
                    <div class="ufi-input-inner flexbox">
                        <span class="material-icons">person</span>
                        <input id="username" type="text" class="ufi-input" placeholder="Brukernavn" name="username" aria-label="" required>
                    </div>
                </div>
                <div class="input-wrapper ufi-input-wrapper">
                    <label for="password">Passord*</label>
                    <div class="ufi-input-inner flexbox">
                        <span class="material-icons">password</span>
                        <input id="password" type="password" class="ufi-input" placeholder="Passord" name="password" aria-label="" required>
                    </div>
                </div>
            </fieldset>
            <fieldset class="input-grid inpt-grd-2">
                <div class="ufi-button-wrapper">
                    <button type="submit" class="ufi-button flexbox">
                        Login
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