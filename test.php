<?php
require "func.php";
session_start();
$errors = new ErrorMsg();
$rootPath = "";

$user = User::sessionGet();
//$user = User::auth("gamerxxx", "123");
$completedQuests = $user->getCompletedQuests();
$availableQuests = $user->getAvailableQuests();

$test = $user->getUnlockedQuests();

foreach ($availableQuests as $item) {
    print_r($item);
    print "</br>";
}