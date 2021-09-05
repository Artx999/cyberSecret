<?php
require "../func.php";

if (isset($_POST["username"]) && $_POST["username"]) {
    $request = $_POST["username"];
    $data = "username";
}
else if (isset($_POST["cardID"]) && $_POST["cardID"]) {
    $request = $_POST["cardID"];
    $data = "card_ID";
}
else {
    print "error";
    exit();
}

$result = dbQuery("SELECT {$data} FROM cyber_secret.user WHERE {$data}='{$request}';");
if ($result->num_rows) print $request . ": " . $data;
else print false;