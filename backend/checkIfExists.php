<?php
require "../func.php";

if (isset($_POST["username"]) && $_POST["username"]) {
    $request = $_POST["username"];
    $data = "username";
}
else if (isset($_POST["cardID"]) && $_POST["cardID"]) {
    $request = $_POST["cardID"];
    $data = "card_id";
}
else {
    print "error";
    exit();
}

$result = dbQuery("SELECT {$data} FROM lanmine_noneon.user WHERE {$data}='{$request}';");
if ($result->num_rows) print $request . ": " . $data;
else print false;