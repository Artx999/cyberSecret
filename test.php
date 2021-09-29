<?php
require "func.php";
session_start();
$errors = new ErrorMsg();
$rootPath = "";

//$user = User::sessionGet();
$user = User::auth("gamerxxx", "123");
$completedQuests = $user->getCompletedQuests();
$availableQuests = $user->getAvailableQuests();

$test = $user->getUnlockedQuests();

print "Available quests:</br>------</br>";
foreach ($availableQuests as $item) {
    print_r($item->name);
    print "</br>";
}
print "</br></br>";

print "Completed quests:</br>------</br>";
foreach ($completedQuests as $item) {
    print_r($item->name);
    print "</br>";
}