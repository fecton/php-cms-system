<?php
  require_once 'header.php';
  include_once 'src/Database.php';

  echo "<link rel='stylesheet' href='css/admin.css' type='text/css'>";

  $db = new Database();

  if (!isset($_SESSION['user']) || $_SESSION['user'] != 'admin') {
      die("You don't have admin priviliges, aborting...</div></body></html>");
  }

  if(isset($_GET['control'])) {
    $control = $_GET['control'];

    switch($control) {
      case 'members':
        if(isset($_GET['user'])) {
          $user = $_GET['user'];
          $db->queryMysql("DELETE FROM members WHERE user = '$user'");
        }
        break;
      case 'messages':
        if(isset($_GET['id'])) {
          $id = $_GET['id'];
          $db->queryMysql("DELETE FROM messages WHERE id = '$id'");
        }
        break;
      case 'friends':
        if(isset($_GET['user']) && isset($_GET['friend'])) {
          $user = $_GET['user'];
          $friend = $_GET['friend'];
          $db->queryMysql("DELETE FROM friends WHERE user = '$user' AND friend = '$friend'");
        }
        break;
      case 'profiles':
        if(isset($_GET['user']) && isset($_GET['text'])) {
          $user = $_GET['user'];
          $text = $_GET['text'];
          $db->queryMysql("DELETE FROM profiles WHERE user = '$user' AND text = '$text'");
        }
        break;
    }
  }

  if (!$loggedin) die("</div></body></html>");
  else
  {
    echo "<div class='center'>
    <h1>❗❗❗Admin panel (unrestricted access): be aware about your actions❗❗❗</h1>
    </div><br>";
  }

  echo <<<_LOGGEDIN
        <div class='center'>
          <a data-role='button' data-inline='true' data-icon='edit'
            data-transition="slide" href='setup.php'>Setup</a>
        </div>
  _LOGGEDIN;

  # Show admin panel
  # 1. Query which shows all users and actions to done with them
  echo "<hr>";
  $result = $db->queryMysql("SELECT * FROM members");
  $rows = $result->fetchAll(PDO::FETCH_ASSOC);
  echo "<div class='center'><h2>Delete users (TABLE 'members')</h2>";
  echo "<table align='center'>";
  echo "<tr><th>User</th><th>Password</th><th colspan=2>Actions</th></tr>";
  foreach ($rows as $row) {
    echo "<tr>";
    echo "<td><a href='members.php?view=" . $row['user'] . "'>" . $row['user'] . "</a></td>";
    echo "<td>" . $row['pass'] . "</td>";
    echo "<td><a href='admin.php?control=members&user=" . $row['user'] . "&pass=" . $row['pass'] . "'>Delete</a></td>";
    echo "</tr>";
  }
  echo "</table></div>";
  echo "";
  echo "<hr>";
  echo "";

  # 2. Query which shows all messages and actions to done with them
  $result = $db->queryMysql("SELECT * FROM messages");
  $rows = $result->fetchAll(PDO::FETCH_ASSOC);
  echo "<div class='center'><h2>Delete messages (TABLE 'messages')</h2>";
  echo "<table align='center'>";
  echo "<tr><th>ID</th><th>Sender</th><th>Receiver</th><th>Message</th><th colspan=2>Actions</th></tr>";
  foreach ($rows as $row) {
    echo "<tr>";
    echo "<td>" . $row['id'] . "</td>";
    echo "<td>" . $row['auth'] . "</td>";
    echo "<td>" . $row['recip'] . "</td>";
    echo "<td>" . $row['message'] . "</td>";
    echo "<td><a class='delete' href='admin.php?control=messages&id=" . $row['id'] . "'>Delete</a></td>";
    echo "</tr>";
  }
  echo "</table></div>";
  echo "";
  echo "<hr>";
  echo "";

  # 3. Query which shows all friends relationships between users
  $result = $db->queryMysql("SELECT * FROM friends");
  $rows = $result->fetchAll(PDO::FETCH_ASSOC);
  echo "<div class='center'><h2>Delete friends (TABLE 'friends')</h2>";
  echo "<table align='center'>";
  echo "<tr><th>User</th><th>Friend</th><th colspan=2>Actions</th></tr>";
  foreach ($rows as $row) {
    echo "<tr>";
    echo "<td>" . $row['user'] . "</td>";
    echo "<td>" . $row['friend'] . "</td>";
    echo "<td><a href='admin.php?control=friends&user=" . $row['user'] . "&friend=" . $row['friend'] . "'>Delete</a></td>";
    echo "</tr>";
  }
  echo "</table></div>";
  echo "";
  echo "<hr>";
  echo "";

  # 4. Query which shows all profiles
  $result = $db->queryMysql("SELECT * FROM profiles");
  $rows = $result->fetchAll(PDO::FETCH_ASSOC);
  echo "<div class='center'><h2>Delete profiles (TABLE 'profiles')</h2>";
  echo "<table align='center'>";
  echo "<tr><th>User</th><th>Text</th><th colspan=2>Actions</th></tr>";
  foreach ($rows as $row) {
    echo "<tr>";
    echo "<td>" . $row['user'] . "</td>";
    echo "<td>" . $row['text'] . "</td>";
    echo "<td><a href='admin.php?control=profiles&user=" . $row['user'] . "&text=" . $row['text'] . "'>Delete</a></td>";
    echo "</tr>";
  }
  echo "</table></div>";
  echo "";
  echo "<hr>";
  echo "";

?>
    </ul></div>
  </body>
</html>
