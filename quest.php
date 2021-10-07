<?php
require "func.php";
session_start();
$errors = new ErrorMsg();
$rootPath = "";

if (isset($_SESSION["user"])) {
    $currentUser = User::sessionGet();
}
if (isset($currentUser) && $currentUser) {
    $completedQuests = $currentUser->getCompletedQuests();
    $availableQuests = $currentUser->getAvailableQuests();
}

if (!isset($_GET["error"])) {
    if (isset($_GET["questID"]) && $_GET["questID"]) {
        $questID = $_GET["questID"];
        $result = dbQuery("SELECT quest.* FROM lanmine_noneon.quest WHERE quest_id = '$questID' LIMIT 1;")->fetch_assoc();
        if ($result) {
            $currentQuest = new Quest(
                $result["quest_id"],
                $result["name"],
                $result["description"],
                $result["unlocks"],
                $result["children"],
                $result["additional_requirements"],
                $result["reward"],
                $result["file"]
            );

            $questPermission = false;
            $questCompleted = false;
            foreach ($completedQuests as $item) {
                if ($item->id === $currentQuest->id) {
                    $questPermission = true;
                    $questCompleted = true;
                }
            }
            foreach ($availableQuests as $item) {
                if ($item->id === $currentQuest->id) $questPermission = true;
            }
            if (!$questPermission) $errors->add("questNotUnlocked");

        } else $errors->add("somethingWrong");
    } else $errors->add("somethingWrong");

    if ($errors->content) {
        header("Location: quest.php?error=" . $errors->encode());
    }
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
    <?php
    if (isset($_GET["error"])) {
        print '
        <section id="quest-error" class="view-width">
            <div class="quest-header flexbox-col-left-start">
            <p class="error-msg flexbox-left"><span class="material-icons">warning</span>' . ErrorMsg::decode($_GET["error"]) . '</p>
                die();
            </div>
        </section>';
    }
    ?>
    <section id="quest-title" class="view-width">
        <div class="quest-header flexbox-col-left-start">
            <?php
            if ($questCompleted) {
                print "<p class='completed-quest'>[Completed]</p>";
            }
            ?>
            <h3><?php print $currentQuest->name ?></h3>
            <p><?php print $currentQuest->description ?></p>
            <?php
            $tmpArray = [$currentQuest];
            if ($children = User::getChildQuests($tmpArray)) {
                print "<p>*You need to complete these quests before completing this one: ";
                foreach ($children as $item) {
                    if ($item === $children[0]) print "\"" . $item->name . "\"";
                    else print ", " . "\"" . $item->name . "\"";
                }
                print "</p>";
            }
            ?>
        </div>
    </section>

    <?php
    if ($currentQuest->file) {
        print "
    <section id='quest-files' class='view-width'>
        <div class='quest-header flexbox-col-left-start'>
            ";
        if (file_exists("questFiles/{$currentQuest->id}.php")) include "questFiles/{$currentQuest->id}.php";
        else print "<p class='error-msg flexbox-left'><span class='material-icons'>warning</span>Error!</p>";
        print "
        </div>
    </section>
    ";
    }
    ?>

</main>

</body>
<script>
    paceOptions = {
        elements: true
    };
</script>
</html>
