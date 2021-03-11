<?php
require "func.php";
if (isset($_GET["error"])) {
    print errorDecode($_GET["error"]); // Prints error messages.
}
?>
<form action="backend/signupSys.php" method="post">
    <label for="username">Username</label>
    <input id="username" name="username">
    <label for="email">E-mail</label>
    <input id="email" name="email">
    <label for="password">Password</label>
    <input id="password" name="password" type="password">
    <label for="confirmPassword">Confirm password</label>
    <input id="confirmPassword" name="confirmPassword" type="password">
    <label for="birthday">Birthday (optional)</label>
    <input id="birthday" name="birthday" type="date">
    <button type="submit">Sign up</button>
</form>
