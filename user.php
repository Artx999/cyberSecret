<?php
require "func.php";
session_start();
$errors = new ErrorMsg();
$rootPath = "";
$_SESSION['fileName'] = "user";

if (isset($_SESSION["user"])) {
    $currentUser = User::sessionGet();
}

if (isset($_GET["username"]) && isset($_GET["cardID"])) {
    $errors->add("usernameAndCardID");
    header("Location: user.php?error={$errors->encode()}");
}

if (isset($_GET["username"]) && $_GET["username"]) {
    $username = stripslashes(htmlspecialchars($_GET["username"]));
    if (isset($currentUser) && $username === $currentUser->username) {
        if (isset($_GET["cardScan"])) {
            header("Location: user.php?username={$username}");
        }
        $displayUser = $currentUser;
    } else {
        $result = dbQuery("SELECT user_id, username, card_id, profile_picture FROM lanmine_noneon.user WHERE username = '{$username}' LIMIT 1")->fetch_assoc();
        if ($result) {
            if (isset($_GET["cardScan"])) {
                header("Location: user.php?username={$username}");
            } else {
                if (!isset($result["profile_picture"])) $result["profile_picture"] = false;
                $displayUser = new User($result["user_id"], $result["username"], $result["card_id"], $result["profile_picture"]);
            }
        }
        else {
            $errors->add("incorrectUsername");
            header("Location: user.php?error={$errors->encode()}");
        }
    }
} else if (isset($_GET["cardID"]) && $_GET["cardID"]) {
    $cardID = stripslashes(htmlspecialchars($_GET["cardID"]));
    if (isset($currentUser) && $cardID === $currentUser->cardID) {
        $displayUser = $currentUser;
    } else {
        $result = dbQuery("SELECT user_id, username, card_id FROM lanmine_noneon.user WHERE card_id = '{$cardID}' LIMIT 1")->fetch_assoc();
        if ($result) {
            if (isset($_GET["cardScan"])) {
                header("Location: user.php?cardID={$cardID}");
            } else {
                if (!isset($result["profile_picture"])) $result["profile_picture"] = false;
                $displayUser = new User($result["user_id"], $result["username"], $result["card_id"], $result["profile_picture"]);
            }
        }
        elseif (isset($_GET["cardScan"]) && $_GET["cardScan"] === "true") {
            header("Location: signup.php?cardID={$cardID}");
        }
        else {
            $errors->add("incorrectCardID");
            header("Location: user.php?error={$errors->encode()}");
        }
    }
} else {
    if (isset($currentUser) && !isset($_GET["error"])) header("Location: user.php?username={$currentUser->username}");
    else {
        // What happens when the user is not logged in, and is not viewing any profile.
        // print "No user specified";
    }
}

if (isset($displayUser) && $displayUser) {
    $stats = $displayUser->getStats();
    $inventory = $displayUser->getInventory();
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
    <title><?php print $displayUser->username?>'s Profil</title>
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

    <section id="profile-section" class="view-width">
        <div class="profile-inner flexbox-col">

            <!-- Search -->
            <form class="search-wrapper flexbox-col-left-start" autocomplete="off" method="get" action="">
                <label class="search-label" for="search">Søk etter brukere</label>
                <?php
                if (isset($_GET["error"])) {
                    print '<p class="error-msg flexbox-left"><span class="material-icons">warning</span>' . ErrorMsg::decode($_GET["error"]) . '</p>'; // Prints error messages
                }
                ?>
                <div class="search-input-wrapper flexbox">
                    <input onkeyup="getStates(this.value)" id="username" type="search" class="search-input" placeholder="Fyll inn brukernavn" name="username" aria-label="" required>
                    <div id="results" class="flexbox-col-left"></div>
                    <button type="submit" class="search-button flexbox"><span class="material-icons">search</span></button>
                </div>
            </form>

            <?php if (isset($displayUser)) { ?>
            <!-- Profile Header -->
            <div class="profile-header">

                <div class="profile-header-content flexbox-left">
                    <div class="profile-picture-wrapper flexbox">
                        <div class="profile-picture-inner flexbox">
                            <?php print '<img class="profile-picture" src="data:media_type;base64,' . base64_encode($displayUser->profilePicture) . '" alt="">'; ?>
                        </div>
                        <?php print '<img class="profile-picture-glow" src="data:media_type;base64,' . base64_encode($displayUser->profilePicture) . '" alt="">'; ?>
                    </div>
                    <div class="profile-username-wrapper flexbox-col-left">
                        <h3 class="profile-username"><?php print $displayUser->username?></h3>
                        <p class="profile-at-username">@<?php print strtolower($displayUser->username) ?></p>
                    </div>
                </div>

                <div class="profile-header-logout flexbox">
                    <?php
                    if (isset($currentUser) && ((isset($cardID) && $cardID === $currentUser->cardID) || (isset($username) && $username === $currentUser->username))) {
                        print '
                        <a href="backend/logout.php"><button class="logout-button">Logg ut</button></a>
                        ';
                    } else {
                        print '';
                    } ?>
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
                <h3>Inventar</h3>
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
            <?php } ?>
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
