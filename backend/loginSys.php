<?php
require "../func.php";
$error = [];
if (isset($_POST["username"]) && $_POST["username"]) {
    $user = stripslashes(htmlspecialchars($_POST["username"]));
}
else array_push($error, "noUsername");
if (isset($_POST["password"]) && $_POST["password"]) {
    $pwd = stripslashes(htmlspecialchars($_POST["password"]));
}
else array_push($error, "noPassword");

$errorCode = "";
if (isset($error)) header("Location: ../login.php?" . $errorCode);
elseif (auth($user, $pwd)) {
    $_SESSION["user"] = $user;
    header("Location: ../index.php");
}
else header("Location: ../login.php?incorrect");