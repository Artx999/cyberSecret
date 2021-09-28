<?php
// Simple function that checks if a condition is true or false
function trueOrFalse($i) {
    if ($i) return "true";
    else return "false";
}

// Function that queries the database and returns the result, formatted. All database login credentials can be changed
// TODO: Possibly make this a class that has functionality described in: https://stackoverflow.com/questions/533459/how-to-do-a-php-nested-class-or-nested-methods
function dbQuery($sql, $database = "lanmine_noneon", $server = "localhost", $username="root", $password="") {
    $connection = new mysqli($server, $username, $password, $database);
    if ($connection -> connect_error) return false;
    else {
        $result = $connection->query($sql);
        if ($connection->errno === 1062) return "duplicateKey";
        return $result;
    }
}


// Class for storing and handling errors, as well as printing them
class ErrorMsg {
    public $content;
    public function __construct() {
        $this->content = [];
    }

    // Function for adding errors to the object
    public function add($message) {
        array_push($this->content, $message);
    }

    // Function that encodes the error object to base64
    public function encode() {
        return base64_encode(json_encode($this->content));
    }

    // Static function that decodes error message object, and returns all the errors in a readable and formatted way
    public static function decode($error) {
        $error = json_decode(base64_decode($error));
        $errorList = fopen("errors.json", "r");
        $errorList = json_decode(fread($errorList, filesize("errors.json")));
        $errorMessage = "";
        foreach ($error as $value) {
            if (isset($errorList->$value)) $errorMessage .= $errorList->$value . "<br/>";
            else $errorMessage .= "Unknown error: {$value} !</br>";
        }
        return $errorMessage;
    }
}


// Class for users logged in
class User {
    public $userId, $username, $cardID, $profilePicture;
    function __construct($userId, $username, $cardID, $profilePicture) {
        $this->userId = $userId;
        $this->username = $username;
        $this->cardID = $cardID;
        if ($profilePicture) {
            $this->profilePicture = $profilePicture;
        } else $this->profilePicture = file_get_contents("images/profile-pic.jpg");
    }

    // Function that adds user to session (should be used with user object)
    public function sessionSet() {
        $_SESSION["user"] = serialize($this);
    }

    // Function that gets the current user from session (should be used with user object)
    public static function sessionGet() {
        return unserialize($_SESSION["user"]);
    }

    // Static function that authenticates user and returns user object
    public static function auth($uname, $password) {
        $hashedPass = User::getHashedPass($uname);
        if (password_verify($password, $hashedPass)) {
            $userInfo = dbQuery("SELECT user_id, username, card_id, profile_picture FROM lanmine_noneon.user WHERE username = '$uname' LIMIT 1")->fetch_assoc();
            return new User($userInfo["user_id"], $userInfo["username"], $userInfo["card_id"], $userInfo["profile_picture"]);
        } else return false;
    }

    // Private static function that returns hashed password from username
    private static function getHashedPass($uname) {
        $result = dbQuery("SELECT username, password FROM lanmine_noneon.user WHERE username = '$uname' LIMIT 1;");
        if ($result = $result->fetch_assoc()) return $result["password"];
        else return false;
    }

    // Function that returns user stats as stat object
    public function getStats() {
        $i = dbQuery("SELECT * FROM lanmine_noneon.stats WHERE user_id='$this->userId'")->fetch_assoc();
        if ($i)return new Stats($i["strength"], $i["dexterity"], $i["intelligence"], $i["wisdom"], $i["charisma"], $i["luck"]);
        else return new Stats(5, 5, 5, 5, 5, 5);
    }

    // Function that returns users inventory
    public function getInventory() {
        $i = dbQuery("SELECT * FROM lanmine_noneon.inventory WHERE user_id='$this->userId'");
        if ($i) return $i;
        else return false;
    }
}


// Class for storing stats
class Stats {
    public $strength, $dexterity, $intelligence, $wisdom, $charisma, $luck;
    public function __construct($strength, $dexterity, $intelligence, $wisdom, $charisma, $luck) {
        $this->strength = ["Styrke", $strength];
        $this->dexterity = ["Smidighet", $dexterity];
        $this->intelligence = ["Intelligens", $intelligence];
        $this->wisdom = ["Visdom", $wisdom];
        $this->charisma = ["Karisma", $charisma];
        $this->luck = ["Flaks", $luck];
    }
}


// Class for variable info for the LAN
class Info {
    public static function maxID() {
        return 172;
    }
}