<?php

global $pdo;

class Database {
    private $host = 'localhost';
    private $data = 'main_andrii_campfire';
    private $user = 'root';
    private $pass = '';
    private $chrs = 'utf8mb4';
    private $attr;
    private $opts =
    [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    public function __construct() {
        // Try to establish a connection to the database
        global $pdo;

        $this->attr = "mysql:host=$this->host;dbname=$this->data;charset=$this->chrs";
        try
        {
            $pdo = new PDO($this->attr, $this->user, $this->pass, $this->opts);
        }
        catch (PDOException $e)
        {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function createTable($name, $query)
    {
        $this->queryMysql("CREATE TABLE IF NOT EXISTS $name($query)");
        echo "Table '$name' created or already exists.<br>";
    }


    public function queryMysql($query)
    {
        global $pdo;
        return $pdo->query($query);
    }

    public function destroySession()
    {
        $_SESSION=array();

        if (session_id() != "" || isset($_COOKIE[session_name()]))
            setcookie(session_name(), '', time()-2592000, '/');

        session_destroy();
    }

    public function sanitizeString($var)
    {
        global $pdo;

        $var = strip_tags($var);
        $var = htmlentities($var);
        $var = stripslashes($var);

        $result = $pdo->quote($var);          // This adds single quotes
        return str_replace("'", "", $result); // So now remove them
    }

    public function showProfile($user)
    {
        global $pdo;

        if (file_exists("$user.jpg"))
            echo "<img src='$user.jpg' style='float:left;'>";

        $result = $pdo->query("SELECT * FROM profiles WHERE user='$user'");

        while ($row = $result->fetch())
        {
            die(stripslashes($row['text']) . "<br style='clear:left;'><br>");
        }

        echo "<p>Nothing to see here, yet</p><br>";
    }

}
?>
