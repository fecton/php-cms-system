<!DOCTYPE html>
<html>
  <head>
    <title>Setting up database</title>
  </head>
  <body>
    <h3>Creating tables</h3>

<?php
  include_once 'src/Database.php';
  $db = new Database();

  $db->createTable('members',
              'user VARCHAR(16),
              pass VARCHAR(16),
              INDEX(user(6))');

  $db->createTable('messages',
              'id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              auth VARCHAR(16),
              recip VARCHAR(16),
              pm CHAR(1),
              time INT UNSIGNED,
              message VARCHAR(4096),
              INDEX(auth(6)),
              INDEX(recip(6))');

  $db->createTable('friends',
              'user VARCHAR(16),
              friend VARCHAR(16),
              INDEX(user(6)),
              INDEX(friend(6))');

  $db->createTable('profiles',
              'user VARCHAR(16),
              text VARCHAR(4096),
              INDEX(user(6))');
?>

    <br>...done.

    <h3>Inserting admin user</h3>
    <?php
      $result = $db->queryMysql("SELECT * FROM members WHERE user='admin'");
      if ($result->rowCount() == 0) {
        $db->queryMysql("INSERT INTO members VALUES('admin', 'admin')");
        $db->queryMysql("INSERT INTO profiles VALUES('admin', 'The admin user. Can do anything.')");
        echo "Admin user inserted";
      } else {
        echo "Admin user already exists";
      }
    ?>
    <br>...done.
  </body>
</html>
