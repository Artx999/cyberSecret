<?php
require "func.php";
session_start();
$errors = new ErrorMsg();
$rootPath = "";

if (isset($_SESSION["user"])) {
    $currentUser = User::sessionGet();
} else {
    $errors->add("notLoggedIn");
    header("Location: user.php?error={$errors->encode()}");
}
$result = dbQuery("SELECT user.admin FROM lanmine_noneon.user WHERE user_id = $currentUser->userId")->fetch_assoc();
if ($result) {
    if (!$result["admin"]) $errors->add("invalidPermission");
} else $errors->add("somethingWrong");
if ($errors->content) header("Location: user.php?error={$errors->encode()}");

if (isset($_GET["username"]) && isset($_GET["cardID"])) {
    $errors->add("usernameAndCardID");
    header("Location: admin-panel.php?error={$errors->encode()}");
}

if (isset($_GET["username"]) && $_GET["username"]) {
    $username = stripslashes(htmlspecialchars($_GET["username"]));
    if (isset($currentUser) && $username === $currentUser->username) {
        if (isset($_GET["cardScan"])) {
            header("Location: admin-panel.php?username={$username}");
        }
        $displayUser = $currentUser;
    } else {
        $result = dbQuery("SELECT user_id, username, card_id, profile_picture FROM lanmine_noneon.user WHERE username = '{$username}' LIMIT 1")->fetch_assoc();
        if ($result) {
            if (isset($_GET["cardScan"])) {
                header("Location: admin-panel.php?username={$username}");
            } else {
                if (!isset($result["profile_picture"])) $result["profile_picture"] = false;
                $displayUser = new User($result["user_id"], $result["username"], $result["card_id"], $result["profile_picture"]);
            }
        }
        else {
            $errors->add("incorrectUsername");
            header("Location: admin-panel.php?error={$errors->encode()}");
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
                header("Location: admin-panel.php?cardID={$cardID}");
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
            header("Location: admin-panel.php?error={$errors->encode()}");
        }
    }
} else {
    if (isset($currentUser) && !isset($_GET["error"])) header("Location: admin-panel.php?username={$currentUser->username}");
    else {
        // What happens when the user is not logged in, and is not viewing any profile.
        // print "No user specified";
    }
}

if (isset($displayUser) && $displayUser) {
    $stats = $displayUser->getStats();
    $inventory = $displayUser->getInventory();
    $completedQuests = $displayUser->getCompletedQuests();
    $availableQuests = $displayUser->getAvailableQuests();
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
    <script src="javascript/live-search.js" defer></script>
    <script src="javascript/admin-panel.js" defer></script>
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
            <h3>Admin panel</h3>

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

                    </div>

                </div>
                <!-- Profile Stats -->
                <form class="profile-stats" method="post" action="backend/admin-panel-sys.php">
                    <input type='hidden' name='userId' value='<?php print "$displayUser->userId";?>'/>
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
                            $i = 0;
                            foreach ($stats as $key => $val) {
                                $i = $i + 1;
                                $percent = ($val[1] - 5) * 20;
                                $cssVariable = strtolower("--clr-" . $val[0]);
                                print "
                                <div id='pro-swc{$i}' class='pro-swc-column'>
                                    <div class='pro-swc-content-admin pro-swc-content flexbox'>
                                        <p class='pro-swc-c-minus'>-</p>
                                        <input name='$key' class='pro-swc-number' value='{$val[1]}'>
                                        <p class='pro-swc-c-plus'>+</p>
                                    </div>
                                    <div class='pro-swc-bar-wrapper'>
                                        <div class='pro-swc-bar flexbox-left'>
                                            <div class='pro-swc-bar-inner flexbox-left' style='width: {$percent}%; background-color: hsl(var({$cssVariable}));'>
                                                <p class='pro-swc-bar-number'>0</p>
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
                    <button type="submit" class="profile-stats-submit" name="stats">Send</button>
                </form>
                <!-- Profile Stats -->
                <form id="quests" class="flexbox-col-left" method="post" action="backend/admin-panel-sys.php">
                    <input type='hidden' name='userId' value='<?php print "$displayUser->userId";?>'/>
                    <h3>Quests</h3>
                    <div id="search-wrapper" class="flexbox">
                        <input id="search" name="quest" autocomplete="off" placeholder="Legg til quest" value="" aria-label="">
                        <div id="chev" class="flexbox"></div>
                        <div id="search-results"></div>
                    </div>
                    <?php
                    /*
                    foreach ($availableQuests as $item) {
                        print "<p class='quest-name'>{$item->name}</p>";
                    }
                    */
                    ?>
                    <script type="text/javascript">
                        let quests = "<?php foreach ($availableQuests as $item) {
                            print "$item->name" . ",";
                        } ?>";
                        let quest = quests.split(",");
                        quest.pop();

                        let exp = false;

                        const search = document.getElementById("search");
                        const sel = document.getElementById("search-results");
                        const dd = document.getElementById("chev");

                        search.addEventListener("keyup", (e) => {
                            find(search.value);
                        });

                        search.addEventListener("click", (e) => {
                            find(search.value);
                        });

                        dd.addEventListener("click", (e) => {
                            if (exp) {
                                hidelist();
                            } else {
                                /*if (search.value != "") {
                                    find(search.value);
                                } else {*/
                                populate(quest);
                                showlist();
                                //}
                            }
                        });

                        sel.addEventListener("click", (e) => {
                            hidelist();
                            search.value = e.target.innerHTML;
                        });

                        window.addEventListener("click", (e) => {
                            if (!dd.contains(e.target) && !search.contains(e.target)) {
                                if (e.target.className != "uil uil-angle-up") {
                                    hidelist();
                                }
                            }
                        });

                        function showlist() {
                            dd.innerHTML = '<i class="uil uil-angle-up"></i>';
                            sel.style.display = "inline";
                            exp = true;
                        }

                        function hidelist() {
                            sel.style.display = "none";
                            exp = false;
                            dd.innerHTML = '<i class="uil uil-angle-down"></i>';
                        }

                        function find(str) {
                            str = str.toLowerCase();
                            let sres = [];
                            for (i = 0; i < quest.length; i++) {
                                let n = quest[i].indexOf(str);
                                if (n > -1) {
                                    sres.push(quest[i]);
                                }
                            }
                            populate(sres);
                            if (sres.length > 0) {
                                showlist();
                            } else {
                                hidelist();
                            }
                        }

                        function populate(items) {
                            if (items.length > 0) {
                                sel.innerHTML = "";
                                let sorted_list = [];
                                for (i = 0; i < items.length; i++) {
                                    sorted_list.push(items[i]);
                                }
                                sorted_list.sort(function (a, b) {
                                    return a.toLowerCase().localeCompare(b.toLowerCase());
                                });
                                for (i = 0; i < sorted_list.length; i++) {
                                    let item = document.createElement("span");
                                    item.setAttribute("class", "item");
                                    item.innerHTML = sorted_list[i];
                                    sel.appendChild(item);
                                }
                            }
                        }

                        console.log(quest);
                    </script>
                    <button type="submit" class="profile-stats-submit" name="quests">Send</button>
                </form>
                <!-- Inventory -->
                <form id="inventory" class="flexbox-col-left" method="post" action="backend/admin-panel-sys.php">
                    <h3>Inventar</h3>
                    <input class="inventory-item-add" name="item" autocomplete="off" placeholder="Legg til item" aria-label="">
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
                    <button type="submit" class="profile-stats-submit" name="inventory">Send</button>
                </form>
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
