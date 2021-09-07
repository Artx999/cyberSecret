<?php
require "func.php";
session_start();


$user = User::auth("Artx999", "test");
$stats = $user->getStats();
print_r($stats);


foreach ($stats as $key => $val) {
    $name = ucfirst($val[0]);
    $percent = ($val[1] -5) * 20;
    print "<p>{$name}: {$val[1]} - {$percent}%<p/>";
}