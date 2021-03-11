<?php
// ----------------
function trueOrFalse($i) {
    if ($i) return "true";
    else return "false";
}
function dbQuery($sql, $database = "cyberSecret", $server = "localhost", $username="root", $password="") {
    $connection = new mysqli($server, $username, $password, $database);
    if ($connection -> connect_error) return false;
    else return $connection -> query($sql);
}

// ----------------
function errorDecode($error) {
    $error = json_decode(base64_decode($error));
    $errorList = fopen("errors.json", "r");
    $errorList = json_decode(fread($errorList, filesize("errors.json")));
    $errorMessage = "";
    foreach ($error as $value) {
        if (isset($errorList->$value)) $errorMessage .= $errorList->$value . "<br/>";
    }
    return $errorMessage;
}




function auth() {
}

function signup() {

}