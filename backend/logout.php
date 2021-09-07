<?php
// This file should be deleted later on
session_start();
session_destroy();
header("Location: ../login.php");