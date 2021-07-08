<?php
// ----------------
function trueOrFalse($i) {
    if ($i) return "true";
    else return "false";
}
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
    public static function auth($uname, $password) {
        $hashedPass = User::getHashedPass($uname);
        if (password_verify($password, $hashedPass)) return true;
        else return false;
    }

    private static function getHashedPass($uname) {
        $result = dbQuery("SELECT username, password FROM cyber_secret.user WHERE username = '$uname' LIMIT 1;");
        if ($result = $result->fetch_assoc()) return $result["password"];
        else return false;
    }
}
