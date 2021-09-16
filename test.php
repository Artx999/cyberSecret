<?php
require "func.php";
session_start();


$user = User::auth("Artx999", "test");
$inventory = $user->getInventory();
if ($inventory->fetch_assoc()) {
    foreach ($inventory as $row) {
        print_r($row["item"]);
        print "</br>";
    }
} else {
    print "NO!";
}