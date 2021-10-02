<?php
require "../func.php";
session_start();
$errors = new ErrorMsg();

if (isset($_POST["userId"]) && $_POST["userId"]) {
    $userId = $_POST["userId"];
    $result = dbQuery("SELECT user_id, username, card_id, profile_picture FROM lanmine_noneon.user WHERE user_id = $userId");
    $data = $result->fetch_assoc();
    $displayUser = new User($data["user_id"], $data["username"], $data["card_id"], $data["profile_picture"]);
    $stats = $displayUser->getStats();
    $inventory = $displayUser->getInventory();


    if (isset($_POST["stats"])) {
        $displayUser->updateStats(
            $_POST["strength"],
            $_POST["dexterity"],
            $_POST["intelligence"],
            $_POST["wisdom"],
            $_POST["charisma"],
            $_POST["luck"]
        );
    } elseif (isset($_POST["quests"])) {
        print "There is no way of handling quests here yet!";
        die();
    } elseif (isset($_POST["inventory"])) {
        print "There is no way of handling inventory here yet!";
        die();
    } else {
        $errors->add("somethingWrong");
    }
} else {
    $errors->add("somethingWrong");
}

// Checkout
if ($errors->content) header("Location: ../admin-panel.php?error={$errors->encode()}");
else header("Location: ../admin-panel.php?username={$displayUser->username}");