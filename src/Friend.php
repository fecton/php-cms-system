<?php
include_once "src/Database.php";

global $database;
$database = new Database();

class Friend {
    public $user;
    private $friend;
    private $table_name = "friends";

    public function __construct($user) {
        global $database;
        $this->user = $database->sanitizeString($user);
    }

    public function setFriend($friend) {
        global $database;
        $this->friend = $database->sanitizeString($friend);
    }

    public function getFollowersByUser() {
        global $database;

        $result = $database->queryMysql("SELECT * FROM $this->table_name WHERE user='$this->user'");

        return Friend::parseArray($result);
    }

    public function getFollowingByUser() {
        global $database;

        $result = $database->queryMysql("SELECT * FROM $this->table_name WHERE friend='$this->user'");

        return Friend::parseArray($result);
    }

    private static function parseArray($to_parse) {
        $arr = array();
        $j = 0;
        while ($row = $to_parse->fetch())
        {
            $arr[$j++] = $row['user'];
        }
        return $arr;
    }

    public function insertIfExists() {
        global $database;

        $result = $database->queryMysql("SELECT * FROM $this->table_name WHERE user='$this->user' AND friend='$this->friend'");

        if (!$result->rowCount())
            $database->queryMysql("INSERT INTO $this->table_name VALUES ('$this->user', '$this->friend')");
    }

    public function removeFriendship() {
        global $database;

        $database->queryMysql("DELETE FROM $this->table_name WHERE user='$this->user' AND friend='$this->friend'");
    }

    public static function showAll() {
        global $database;

        return $database->queryMysql("SELECT user FROM members ORDER BY user");
    }

    public static function getFollowingStatus($user, $friend) {
        return Friend::getRecord($user, $friend);
    }

    public static function getFollowerStatus($user, $friend) {
        return Friend::getRecord($friend, $user);
    }

    private static function getRecord($user, $friend) {
        global $database;

        return $database->queryMysql("SELECT * FROM friends WHERE user='$user' AND friend='$friend'");
    }
};


?>
