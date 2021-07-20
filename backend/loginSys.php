<?php
session_start();
require "../func.php";

$errors = new ErrorMsg();
// Username
if (isset($_POST["username"]) && $_POST["username"]) {
    $username = stripslashes(htmlspecialchars($_POST["username"]));
} else $errors->add("noUsername");
// Password
if (isset($_POST["password"]) && $_POST["password"]) {
    $pwd = stripslashes(htmlspecialchars($_POST["password"]));
    $pwd = stripslashes(htmlspecialchars($_POST["password"]));
} else $errors->add("noPassword");

// Handles the errors
if ($errors->content) {
    header("Location: ../login.php?error=" . $errors->encode());
} elseif ($user = User::auth($username, $pwd)) {
    $user->sessionSet();
    header("Location: ../index.php");
} else {
    $errors->add("incorrectUsernameOrPassword");
    header("Location: ../login.php?error=" . $errors->encode());
}
