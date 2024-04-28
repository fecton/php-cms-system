<?php
include_once "src/Database.php";

global $database;
$database = new Database();

class Profile {
    public $user;
    public $text;
    private $table_name = "profiles";

    public function __construct($user) {
        global $database;
        $this->user = $user;

        $result = $database->queryMysql("SELECT * FROM $this->table_name WHERE user='$this->user'");

        if (is_array($result) && isset($result['text'])) {
            $this->text = $result['text'];
        } else {
            $this->text = "";
        }
    }

    public function set_text($text) {
        global $database;
        $text = $database->sanitizeString($text);
        $this->text = preg_replace('/\s\s+/', ' ', $text);

        $result = $database->queryMysql("SELECT * FROM $this->table_name WHERE user='$this->user' AND text='$this->text'");

        if ($result->rowCount()) {
            $database->queryMysql("UPDATE $this->table_name SET text='$this->text' where user='$this->user'");
        } else {
            $database->queryMysql("INSERT INTO $this->table_name VALUES('$this->user', '$text')");
        }
    }

};


?>
