<?php
require "func.php";
session_start();

$user = User::sessionGet();
var_dump($user);
$stats = $user->getStats();
var_dump($stats);