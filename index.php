<?php
require "func.php";
session_start();
if (!isset($_SESSION["user"])) header("Location: login.php");
$user = User::sessionGet();
$stats = $user->getStats();
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
                            <img class="profile-picture" src="https://images.unsplash.com/photo-1599476913208-072a43d63922?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80" alt="">
                        </div>
                        <img class="profile-picture-glow" src="https://images.unsplash.com/photo-1599476913208-072a43d63922?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80" alt="">
                    </div>
                    <div class="profile-username-wrapper flexbox-col-left">
                        <h3 class="profile-username"><?php print $user->username?></h3>
                        <p class="profile-at-username">@<?php print strtolower($user->username) ?></p>
                    </div>
                </div>

            </div>
            <!-- Profile Stats -->
            <div class="profile-stats">
                <div class="profile-stats-wrapper">

                    <div class="pro-sw-titles">
                        <div class="pro-swt-column">
                            <h3 class="pro-swt-title">Styrke:</h3>
                        </div>
                        <div class="pro-swt-column">
                            <h3 class="pro-swt-title">Intelligens:</h3>
                        </div>
                        <div class="pro-swt-column">
                            <h3 class="pro-swt-title">Karisma:</h3>
                        </div>
                        <div class="pro-swt-column">
                            <h3 class="pro-swt-title">Smidighet:</h3>
                        </div>
                        <div class="pro-swt-column">
                            <h3 class="pro-swt-title">Visdom:</h3>
                        </div>
                        <div class="pro-swt-column">
                            <h3 class="pro-swt-title">Flaks:</h3>
                        </div>
                    </div>

                    <div class="pro-sw-content">
                        <div class="pro-swc-column">
                            <div class="pro-swc-content flexbox">
                                <h3 class="pro-swc-number">5</h3>
                            </div>
                            <div class="pro-swc-bar-wrapper">
                                <div id="styrke" class="pro-swc-bar flexbox-left">
                                    <p class="pro-swc-bar-perc">95%</p>
                                    <div class="pro-swc-bar-inner">
                                        <div class="pro-swc-bar-glow"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pro-swc-column">
                            <div class="pro-swc-content flexbox">
                                <h3 class="pro-swc-number">6</h3>
                            </div>
                            <div class="pro-swc-bar-wrapper">
                                <div id="intelligens" class="pro-swc-bar flexbox-left">
                                    <p class="pro-swc-bar-perc">30%</p>
                                    <div class="pro-swc-bar-inner">
                                        <div class="pro-swc-bar-glow"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pro-swc-column">
                            <div class="pro-swc-content flexbox">
                                <h3 class="pro-swc-number">8</h3>
                            </div>
                            <div class="pro-swc-bar-wrapper">
                                <div id="karisma" class="pro-swc-bar flexbox-left">
                                    <p class="pro-swc-bar-perc">10%</p>
                                    <div class="pro-swc-bar-inner">
                                        <div class="pro-swc-bar-glow"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pro-swc-column">
                            <div class="pro-swc-content flexbox">
                                <h3 class="pro-swc-number">7</h3>
                            </div>
                            <div class="pro-swc-bar-wrapper">
                                <div id="smidighet" class="pro-swc-bar flexbox-left">
                                    <p class="pro-swc-bar-perc">66%</p>
                                    <div class="pro-swc-bar-inner">
                                        <div class="pro-swc-bar-glow"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pro-swc-column">
                            <div class="pro-swc-content flexbox">
                                <h3 class="pro-swc-number">6</h3>
                            </div>
                            <div class="pro-swc-bar-wrapper">
                                <div id="visdom" class="pro-swc-bar flexbox-left">
                                    <p class="pro-swc-bar-perc">34%</p>
                                    <div class="pro-swc-bar-inner">
                                        <div class="pro-swc-bar-glow"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pro-swc-column">
                            <div class="pro-swc-content flexbox">
                                <h3 class="pro-swc-number">8</h3>
                            </div>
                            <div class="pro-swc-bar-wrapper">
                                <div id="flaks" class="pro-swc-bar flexbox-left">
                                    <p class="pro-swc-bar-perc">75%</p>
                                    <div class="pro-swc-bar-inner">
                                        <div class="pro-swc-bar-glow"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
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