<?php
require "../func.php";

$error = [];
// Username
if (isset($_POST["username"]) && $_POST["username"]) {
    $user = stripslashes(htmlspecialchars($_POST["username"]));
} else array_push($error, "noUsername");
// Password
if (isset($_POST["password"]) && $_POST["password"]) {
    $pwd = stripslashes(htmlspecialchars($_POST["password"]));
} else array_push($error, "noPassword");

// Handles the errors
if ($error) {
    $error = base64_encode(json_encode($error));
    header("Location: ../login.php?error=" . $error);
} elseif (auth($user, $pwd)) {
    $_SESSION["user"] = $user;
    header("Location: ../index.php");
} else {
    array_push($error, "incorrectUsernameOrPassword");
    header("Location: ../login.php?error=" . base64_encode(json_encode($error)));
}
