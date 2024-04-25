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

        $result = $database->queryMysql("SELECT * FROM $this->table_name WHERE user='$user'")->fetch();

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

        $result = $database->queryMysql("SELECT * FROM $this->table_name WHERE user='$this->user' AND text='$this->text'")->fetch();

        if ($result->rowCount()) {
            $database->queryMysql("UPDATE $this->table_name SET text='$text' where user='$this->user'");
        } else {
            $database->queryMysql("INSERT INTO $this->table_name VALUES('$this->user', '$text')");
        }
    }

};


?>

<?php
$DEBUG_FLAG = false;

if($DEBUG_FLAG) {
    $profile = new Profile("123");

    echo $profile->user;
    echo "<br>";
    echo $profile->text;
}
?>


