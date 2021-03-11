<?php
require "../func.php";

$error = [];
// Username
if (isset($_POST["username"]) && $_POST["username"]) {
    $user = stripslashes(htmlspecialchars($_POST["username"]));
} else array_push($error, "noUsername");
// Email
if (isset($_POST["email"]) && $_POST["email"]) {
    $email = stripslashes(htmlspecialchars($_POST["email"]));
} else array_push($error, "noEmail");
// Password
if (isset($_POST["password"]) && $_POST["password"]) {
    $pwd = stripslashes(htmlspecialchars($_POST["password"]));
    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
} else array_push($error, "noPassword");
// Confirm password
if (isset($_POST["confirmPassword"]) && $_POST["confirmPassword"]) {
    $cPwd = stripslashes(htmlspecialchars($_POST["confirmPassword"]));
    if (isset($pwd) && $cPwd !== $pwd) array_push($error, "noConfirmPasswordMatch");
} else array_push($error, "noConfirmPassword");
// Birthday
if (isset($_POST["birthday"]) && $_POST["birthday"]) {
    $birthday = stripslashes(htmlspecialchars($_POST["birthday"]));
}

// Handles the errors
if ($error) {
    $error = base64_encode(json_encode($error));
    header("Location: ../signup.php?error=" . $error);
} elseif (dbQuery("INSERT INTO `cybersecret`.`user` (`username`, `email`, `password`, `birthday`) VALUES ('$user', '$email', '$hashedPwd', '$birthday');")) {
    header("Location: ../login.php");
} else {
    array_push($error, "somethingWrong");
    header("Location: ../signup.php?error=" . base64_encode(json_encode($error)));
}