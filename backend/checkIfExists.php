<?php
require "../func.php";
$request = $_POST["username"];
$result = dbQuery("SELECT username FROM cyber_secret.user WHERE username='{$request}';");
if ($result->num_rows) print true;
else print false;