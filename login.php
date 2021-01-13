<?php
require "func.php";
if (isset($_GET["error"])) {
    print errorDecode($_GET["error"]);
}
if (isset($_GET["incorrect"])) print "<script>alert('Incorrect username or password!')</script>"; // Should be made sexier
?>
<form action="backend/loginSys.php" method="post">
    <label for="username">Username</label>
    <input name="username" id="username" type="text">
    <label for="password">Password</label>
    <input name="password" id="password" type="password">
    <button type="submit">Login</button>
</form>