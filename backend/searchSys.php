<?php
require "../func.php";


if (isset($_POST["search"]) && $_POST["search"]) {
    $search = stripslashes(htmlspecialchars($_POST["search"]));
}


header("Location: ../search.php?brukernavn=" . $search);