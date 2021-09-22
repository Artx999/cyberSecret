<?php
require "func.php";
if (isset($_GET["cardID"]) && $_GET["cardID"]) {
    $cardID = stripslashes(htmlspecialchars($_GET["cardID"]));
    $result = dbQuery("SELECT user_id, username, card_id FROM lanmine_noneon.user WHERE card_id = '$cardID' LIMIT 1")->fetch_assoc();
    if ($result) {
        print $result["username"];
        if (isset($_GET["cardScan"]) && $_GET["cardScan"] === "true") {
            header("Location: user.php?cardID=" . $cardID);
        }
    }
    elseif (isset($_GET["cardScan"]) && $_GET["cardScan"] === "true") {
        header("Location: signup.php?cardID=" . $cardID);
    }
    else print "Incorrect user";
} else print "No user specified";