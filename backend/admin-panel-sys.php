<?php
require "../func.php";
session_start();
$errors = new ErrorMsg();
$rootPath = "";

$userId = $_POST["userId"];

if (isset($userId) && $userId) {
    $result = dbQuery("SELECT user_id, username, card_id, profile_picture FROM lanmine_noneon.user WHERE user_id = $userId");
    $data = $result->fetch_assoc();
    $displayUser = new User($data["user_id"], $data["username"], $data["card_id"], $data["profile_picture"]);
    $stats = $displayUser->getStats();
    $inventory = $displayUser->getInventory();
} else {
    $errors->add("somethingWrong");
    header("Location: admin-panel.php?error={$errors->encode()}");
}

print "User ID: " . $displayUser->userId . "</br>";


if (isset($_POST["stats"])) {
    $displayUser->updateStats(
        $_POST["strength"],
        $_POST["dexterity"],
        $_POST["intelligence"],
        $_POST["wisdom"],
        $_POST["charisma"],
        $_POST["luck"]
    );
    print "</br>";
}
