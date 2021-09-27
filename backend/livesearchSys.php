<?php

require "../func.php";

$search = $_POST["name"];

$result = dbQuery("SELECT username FROM lanmine_noneon.user WHERE username LIKE '%{$search}%' LIMIT 5");

if ($result) {
    if ($result->num_rows) {
        while($user = $result->fetch_assoc()) {
            print "<a class='flexbox' href='user.php?username={$user["username"]}'><span class='material-icons'>search</span> {$user["username"]}</a>";
        }
    } else {
        print "<a class='search-nothing'>Det finnes ingen bruker med dette brukernavnet</a>";
    }
} else {
    print "<a>mordi</a>";
}