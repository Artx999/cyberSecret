<?php
require "../func.php";

$errors = new ErrorMsg();
// Username
if (isset($_POST["username"]) && $_POST["username"]) {
    $username = stripslashes(htmlspecialchars($_POST["username"]));
} else $errors->add("noUsername");
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
// Card ID
if (isset($_POST["cardID"]) && $_POST["cardID"]) {
    $cardID = stripslashes(htmlspecialchars($_POST["cardID"]));
    if ($cardID < 1 || $cardID > Info::maxID()) $errors->add("invalidCardID");
} else $errors->add("noCardID");
// First Name
if (isset($_POST["firstName"]) && $_POST["firstName"]) {
    $firstName = stripslashes(htmlspecialchars($_POST["firstName"]));
} else $errors->add("noFirstName");
// Last name
if (isset($_POST["lastName"]) && $_POST["lastName"]) {
    $lastName = stripslashes(htmlspecialchars($_POST["lastName"]));
} else $errors->add("noLastName");

// Checks if username or card ID exists
$keyExists = dbQuery("SELECT username, card_ID FROM lanmine_noneon.user WHERE username='$username' OR card_ID='$cardID'");
foreach ($keyExists as $row) {
    if ($row["username"] === $username) $errors->add("usernameExists");
    if ($row["seat_number"] === $cardID) $errors->add("cardIDExists");
}

// Handles the errors
if ($errors->content) {
    header("Location: ../signup.php?error=" . $errors->encode());
} elseif ($sql = dbQuery("INSERT INTO lanmine_noneon.user (username, password, card_id, first_name, last_name) VALUES ('$username', '$hashedPwd', '$cardID', '$firstName', '$lastName');")) {
    if ($sql === "duplicateKey") {
        $errors->add("duplicateKey");
        header("Location: ../signup.php?error=" . $errors->encode());
    }
    else header("Location: ../login.php");
} else {
    $errors->add("somethingWrong");
    header("Location: ../signup.php?error=" . $errors->encode());
}