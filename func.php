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
    function __construct() {
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

    // Function that returns users stats as stat object
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

    // ## Anything that has anything to do with quests ##
    // Function that returns users completed quests as array of objects
    public function getCompletedQuests() {
        $questList = [];
        $result = dbQuery("SELECT quest.* FROM lanmine_noneon.quest INNER JOIN lanmine_noneon.completed_quests cq on quest.quest_id = cq.quest_id WHERE cq.user_id = $this->userId;");
        foreach ($result as $item) {
            $quest = new Quest(
                $item["quest_id"],
                $item["name"],
                $item["description"],
                $item["unlocks"],
                $item["children"],
                $item["additional_requirements"],
                $item["reward"],
                $item["file"]
            );
            array_push($questList, $quest);
        }
        return $questList;
    }

    // Function that returns children of input array of quests
    private function getChildQuests($questArray) {
        $questList = [];
        // Get one of each child
        $children = [];
        foreach ($questArray as $quest) {
            if ($content = $quest->children) {
                foreach (json_decode($content) as $item) {
                    array_push($children, $item);
                }
            }
        }
        $data = "\"" . implode("\", \"", $children) . "\"";
        $result = dbQuery("SELECT quest.* FROM lanmine_noneon.quest WHERE quest_id IN ($data)");
        foreach ($result as $item) {
            $quest = new Quest(
                $item["quest_id"],
                $item["name"],
                $item["description"],
                $item["unlocks"],
                $item["children"],
                $item["additional_requirements"],
                $item["reward"],
                $item["file"]
            );
            array_push($questList, $quest);
        }
        if (!$questList) return false;
        else return $questList;
    }

    // Function that returns users unlocked quests that are not completed, without children
    public function getUnlockedQuests() {
        $questList = [];
        $children = [];
        $completedQuests = $this->getCompletedQuests();
        foreach ($completedQuests as $quest) {
            if ($quest->unlocks) {
                foreach (json_decode($quest->unlocks) as $item) {
                    array_push($children, $item);
                }
            }
        }
        $data = "\"" . implode("\", \"", $children) . "\"";
        $result = dbQuery("SELECT quest.* FROM lanmine_noneon.quest WHERE quest_id IN ($data)");
        foreach ($result as $item) {
            $check = true;
            foreach ($completedQuests as $quest) {
                if ($item["quest_id"] === $quest->id) $check = false;
            }
            if ($check) {
                $newQuest = new Quest(
                    $item["quest_id"],
                    $item["name"],
                    $item["description"],
                    $item["unlocks"],
                    $item["children"],
                    $item["additional_requirements"],
                    $item["reward"],
                    $item["file"]
                );
                array_push($questList, $newQuest);
            }
        }
        return $questList;
    }

    // Function that returns users available quests as array of objects
    public function getAvailableQuests() {
        $questList = [];
        // Adds unlocked quests
        $unlockedQuests = $this->getUnlockedQuests();
        foreach ($unlockedQuests as $quest) {
            array_push($questList, $quest);
        }
        // Adds child quests
        $currentVal = $this->getChildQuests($unlockedQuests);
        while ($currentVal) {
            foreach ($currentVal as $item) {
                array_push($questList, $item);
            }
            $currentVal = $this->getChildQuests($currentVal);
        }
        return $questList;
    }
    // TODO: Add polymorphism instead of getting shit from other function, if possible.
    // ## --- ###
}


// Class for storing stats
class Stats {
    public $strength, $dexterity, $intelligence, $wisdom, $charisma, $luck;
    public function __construct($strength, $dexterity, $intelligence, $wisdom, $charisma, $luck) {
        // Index 0 = norwegian translation, index 1 = value
        $this->strength = ["Styrke", $strength];
        $this->dexterity = ["Smidighet", $dexterity];
        $this->intelligence = ["Intelligens", $intelligence];
        $this->wisdom = ["Visdom", $wisdom];
        $this->charisma = ["Karisma", $charisma];
        $this->luck = ["Flaks", $luck];
    }
}


// Class for quests
class Quest {
    public $id, $name, $description, $unlocks, $children, $req, $reward, $file;
    function __construct($id, $name, $description, $unlocks, $children, $req, $reward, $file) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->unlocks = $unlocks;
        $this->children = $children;
        $this->req = $req;
        $this->reward = $reward;
        $this->file = $file;
    }
}


// Class for variable info for the LAN
class Info {
    public static function maxID() {
        return 172;
    }
}