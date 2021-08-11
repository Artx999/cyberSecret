<?php
require "../func.php";

$errors = new ErrorMsg();
// Username
if (isset($_POST["username"]) && $_POST["username"]) {
    $username = stripslashes(htmlspecialchars($_POST["username"]));
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
// Seat number
if (isset($_POST["seatNumber"]) && $_POST["seatNumber"]) {
    $seatNumber = stripslashes(htmlspecialchars($_POST["seatNumber"]));
    if ($seatNumber < 1 || $seatNumber > Info::maxSeats()) $errors->add("invalidSeatNumber");
} else $errors->add("noSeatNumber");

// Handles the errors
$keyExists = dbQuery("SELECT username, seat_number FROM `cyber_secret`.`user` WHERE username='$username' OR seat_number='$seatNumber'");
foreach ($keyExists as $row) {
    if ($row["username"] === $username) $errors->add("usernameExists");
    if ($row["seat_number"] === $seatNumber) $errors->add("seatNumberExists");
}

if ($errors->content) {
    header("Location: ../signup.php?error=" . $errors->encode());
} elseif ($sql = dbQuery("INSERT INTO `cyber_secret`.`user` (`username`, `password`, `seat_number`) VALUES ('$username', '$hashedPwd', '$seatNumber');")) {
    if ($sql === "duplicateKey") {
        $errors->add("duplicateKey");
        header("Location: ../signup.php?error=" . $errors->encode());
    }
    else header("Location: ../login.php");
} else {
    $errors->add("somethingWrong");
    header("Location: ../signup.php?error=" . $errors->encode());
}