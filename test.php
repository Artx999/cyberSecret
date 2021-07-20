<?php
require "func.php";
session_start();

$user = User::auth("lol", "lol");
$user->sessionSet();

var_dump(User::sessionGet());