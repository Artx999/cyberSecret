<?php
require "../func.php";

$errors = new ErrorMsg();
// Username
if (isset($_POST["username"]) && $_POST["username"]) {
    $user = stripslashes(htmlspecialchars($_POST["username"]));
} else $errors->add("noUsername");
/*
// Email
if (isset($_POST["email"]) && $_POST["email"]) {
    $email = stripslashes(htmlspecialchars($_POST["email"]));
} else $errors->add("noEmail");
*/
// Password
if (isset($_POST["password"]) && $_POST["password"]) {
    $pwd = stripslashes(htmlspecialchars($_POST["password"]));
    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
} else $errors->add("noPassword");
// Confirm password
if (isset($_POST["confirmPassword"]) && $_POST["confirmPassword"]) {
    $cPwd = stripslashes(htmlspecialchars($_POST["confirmPassword"]));
    if (isset($pwd) && $cPwd !== $pwd) $errors->add("noConfirmPasswordMatch");
} else $errors->add("noConfirmPassword");
/*
// Birthday
if (isset($_POST["birthday"]) && $_POST["birthday"]) {
    $birthday = stripslashes(htmlspecialchars($_POST["birthday"]));
}
*/

// Handles the errors
// Maybe only use a single query that gets all info about both username and email
$usernameExists = mysqli_num_rows(dbQuery("SELECT * FROM `cyber_secret`.`user` WHERE username='$user'"));
//$emailExists = mysqli_num_rows(dbQuery("SELECT * FROM `cyber_secret`.`user` WHERE email='$email'"));
if ($usernameExists) $errors->add("usernameExists");
//if ($emailExists) $errors->add("emailExists");

if ($errors->content) {
    header("Location: ../signup.php?error=" . $errors->encode());
} elseif ($sql = dbQuery("INSERT INTO `cyber_secret`.`user` (`username`, `password`) VALUES ('$user', '$hashedPwd');")) {
    if ($sql === "duplicateKey") {
        $errors->add("duplicateKey");
        header("Location: ../signup.php?error=" . $errors->encode());
    }
    else header("Location: ../login.php");
} else {
    $errors->add("somethingWrong");
    header("Location: ../signup.php?error=" . $errors->encode());
}