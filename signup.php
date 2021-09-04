<head>
    <title>Register</title>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="javascript/script.js" defer></script>
    <style>
        .wait {
            background-color: blue;
        }
        .ok {
            background-color: green;
        }
        .bad {
            background-color: red;
        }
    </style>
</head>
<?php
require "func.php";
if (isset($_GET["error"])) {
    print ErrorMsg::decode($_GET["error"]); // Prints error messages.
}
?>
<form action="backend/signupSys.php" method="post">
    <!-- Username -->
    <label for="username">Username</label>
    <input id="username" name="username">
    <!--
    <label for="email">E-mail</label>
    <input id="email" name="email">
    -->
    <!-- Password -->
    <label for="password">Password</label>
    <input id="password" name="password" type="password">
    <!-- Confirm password -->
    <label for="confirmPassword">Confirm password</label>
    <input id="confirmPassword" name="confirmPassword" type="password">
    <!-- Seat number -->
    <label for="seatNumber">Seat number</label>
    <input id="seatNumber" name="seatNumber" type="number" min="1" max="<?php print Info::maxSeats()?>">

    <button id="submit" type="submit">Sign up</button>
</form>
<a href="login.php"><button>Or login</button></a>