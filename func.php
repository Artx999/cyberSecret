<?php
// ----------------
function trueOrFalse($i) {
    if ($i) return "true";
    else return "false";
}
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

// ----------------
class ErrorMsg {
    public $content;
    public function __construct() {
        $this->content = [];
    }

    public function add($message) {
        array_push($this->content, $message);
    }

    public function encode() {
        return base64_encode(json_encode($this->content));
    }

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

    public function sessionSet() {
        $_SESSION["user"] = serialize($this);
    }

    public static function sessionGet() {
        return unserialize($_SESSION["user"]);
    }

    public static function auth($uname, $password) {
        $hashedPass = User::getHashedPass($uname);
        if (password_verify($password, $hashedPass)) {
            $userInfo = dbQuery("SELECT user_id, username, card_id, profile_picture FROM lanmine_noneon.user WHERE username = '$uname' LIMIT 1")->fetch_assoc();
            return new User($userInfo["user_id"], $userInfo["username"], $userInfo["card_id"], $userInfo["profile_picture"]);
        } else return false;
    }

    private static function getHashedPass($uname) {
        $result = dbQuery("SELECT username, password FROM lanmine_noneon.user WHERE username = '$uname' LIMIT 1;");
        if ($result = $result->fetch_assoc()) return $result["password"];
        else return false;
    }

    public function getStats() {
        $i = dbQuery("SELECT * FROM lanmine_noneon.stats WHERE user_id='$this->userId'")->fetch_assoc();
        if ($i)return new Stats($i["strength"], $i["dexterity"], $i["intelligence"], $i["wisdom"], $i["charisma"], $i["luck"]);
        else return new Stats(5, 5, 5, 5, 5, 5);
    }

    public function getInventory() {
        $i = dbQuery("SELECT * FROM lanmine_noneon.inventory WHERE user_id='$this->userId'");
        if ($i) return $i;
        else return false;
    }
}

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

class Info {
    public static function maxID() {
        return 172; // ! Must ask someone important !
    }
}