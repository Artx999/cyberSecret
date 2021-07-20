<?php
// ----------------
function trueOrFalse($i) {
    if ($i) return "true";
    else return "false";
}
// Possibly make this a class that has functionality described in: https://stackoverflow.com/questions/533459/how-to-do-a-php-nested-class-or-nested-methods
function dbQuery($sql, $database = "cyber_secret", $server = "localhost", $username="root", $password="") {
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
        }
        return $errorMessage;
    }
}




class User {
    public $userId, $username;
    function __construct($userId, $username) {
        $this->username = $username;
        $this->userId = $userId;
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
            $userInfo = dbQuery("SELECT user_id, username FROM cyber_secret.user WHERE username = '$uname' LIMIT 1")->fetch_assoc();
            return new User($userInfo["user_id"], $userInfo["username"]);
        } else return false;
    }

    private static function getHashedPass($uname) {
        $result = dbQuery("SELECT username, password FROM cyber_secret.user WHERE username = '$uname' LIMIT 1;");
        if ($result = $result->fetch_assoc()) return $result["password"];
        else return false;
    }

    public function getStats() {
        $i = dbQuery("SELECT * FROM cyber_secret.stats WHERE user_id='$this->userId'")->fetch_assoc();
        return $stats = new Stats($i["strength"], $i["dexterity"], $i["charisma"], $i["intelligence"]);
    }
}

class Stats {
    public $strength, $dexterity, $charisma, $intelligence;
    public function __construct($strength, $dexterity, $charisma, $intelligence) {
        $this->strength = $strength;
        $this->dexterity = $dexterity;
        $this->charisma = $charisma;
        $this->intelligence = $intelligence;
    }
}
