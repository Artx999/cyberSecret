<?php
session_start();
require "func.php";

$i = new ErrorMsg;
var_dump($i->decode());