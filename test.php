<?php
require "func.php";
session_start();

$user = User::sessionGet();
var_dump($user);
print "<br/>";
$stats = $user->getStats();
var_dump($stats);
print "<br/>";
foreach ($stats as $key => $val) {
    $name = ucfirst($key);
    print "<p>{$name}: {$val}<p/>";
};