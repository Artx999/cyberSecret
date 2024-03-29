<?php
require "func.php";
session_start();
if (!isset($_SESSION["user"])) header("Location: login.php");
$user = User::sessionGet();
$stats = $user->getStats();
$inventory = $user->getInventory();
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
<main id="main" class="flexbox-col-start-center">

    <section id="profile-section" class="view-width">
        <div class="profile-inner flexbox-col">
            <!-- Profile Header -->
            <div class="profile-header">

                <div class="profile-header-content flexbox-left">
                    <div class="profile-picture-wrapper flexbox">
                        <div class="profile-picture-inner flexbox">
                            <img class="profile-picture" src="images/profile-pic.jpg" alt="">
                        </div>
                        <img class="profile-picture-glow" src="images/profile-pic.jpg" alt="">
                    </div>
                    <div class="profile-username-wrapper flexbox-col-left">
                        <h3 class="profile-username"><?php print $user->username?></h3>
                        <p class="profile-at-username">@<?php print strtolower($user->username) ?></p>
                    </div>
                </div>

                <div class="profile-header-logout flexbox">
                    <a href="backend/logout.php"><button class="logout-button">Logout</button></a>
                </div>

            </div>
            <!-- Profile Stats -->
            <div class="profile-stats">
                <div class="profile-stats-wrapper">
                    <div class="pro-sw-titles">
                        <?php
                        foreach ($stats as $key => $val) {
                            print "
                            <div class='pro-swt-column'>
                                <h3 class='pro-swt-title'>{$val[0]}:</h3>
                            </div>
                            ";
                        }
                        ?>
                    </div>

                    <div class="pro-sw-content">
                        <?php
                        foreach ($stats as $key => $val) {
                            $percent = ($val[1] - 5) * 20;
                            $cssVariable = strtolower("--clr-" . $val[0]);
                            print "
                            <div class='pro-swc-column'>
                            <div class='pro-swc-content flexbox'>
                                <h3 class='pro-swc-number'>{$val[1]}</h3>
                            </div>
                            <div class='pro-swc-bar-wrapper'>
                                <div class='pro-swc-bar flexbox-left'>
                                    <div class='pro-swc-bar-inner' style='width: {$percent}%; background-color: hsl(var({$cssVariable}));'>
                                        <div class='pro-swc-bar-glow'></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            ";
                        }
                        ?>
                    </div>

                </div>
            </div>
            <!-- Inventory -->
            <div id="inventory" class="flexbox-col-left">
                <h3>Inventory</h3>
                <?php
                if ($inventory->fetch_assoc()) {
                    print "<div class='inventory-inner'>";
                    foreach ($inventory as $row) {
                        print "
                        <div class='inventory-cell flexbox'>
                            <p class='inventory-cell-title'>{$row["item"]}</p>
                        </div>
                        ";
                    }
                    print "</div>";
                } else {
                    print "
                    <div class='inventory-inner-empty'>
                        <div class='inv-empty'>
                            <p>Inventaret ditt er tomt</p>
                        </div>
                    </div>
                    ";
                }
                ?>
            </div>
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