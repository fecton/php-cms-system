<?php

include_once 'src/Database.php';
include_once 'src/Encryption.php';

global $database;
$database = new Database();

class Member {
    public $user;
    private $password;
    private $table_name = "members";

    public function __construct($user) {
        global $database;
        $this->user = $database->sanitizeString($user);
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        global $database;
        $this->password = Encryption::hash(
            $database->sanitizeString($password)
        );
    }

    public function findRecordByUserPassword() {
        global $database;
        $result = $database->queryMySQL("SELECT user,pass FROM $this->table_name
            WHERE user='$this->user' AND pass='$this->password'");
        return $result;
    }

    public function findRecordByUser() {
        global $database;
        $result = $database->queryMySQL("SELECT user FROM $this->table_name
            WHERE user='$this->user'");
        return $result;
    }

    public function save() {
        global $database;
        $database->queryMySQL("INSERT INTO $this->table_name VALUES('$this->user', '$this->password')");
    }

}
?>

