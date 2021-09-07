<?php
require "func.php";
session_start();


$user = User::auth("Artx999", "test");
print_r($user);


//foreach ($stats as $key => $val) {
//    $name = ucfirst($key);
//    print "<p>{$name}: {$val}<p/>";
//}