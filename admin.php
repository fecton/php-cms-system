<?php
  require_once 'header.php';
  include_once 'src/Database.php';

  echo "<link rel='stylesheet' href='css/admin.css' type='text/css'>";

  $db = new Database();

  if (!isset($_SESSION['user']) || $_SESSION['user'] != 'admin') {
      die("You don't have admin priviliges, aborting...</div></body></html>");
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
    echo "<td><a href='delete.php?user=" . $row['user'] . "'>Delete</a></td>";
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
    echo "<td><a class='edit' href='edit.php?message=" . $row['message'] . "'>Edit</a></td>";
    echo "<td><a class='delete' href='delete.php?message=" . $row['message'] . "'>Delete</a></td>";
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
    echo "<td><a href='delete.php?friend=" . $row['friend'] . "'>Delete</a></td>";
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
    echo "<td><a href='delete.php?profile=" . $row['user'] . "'>Delete</a></td>";
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
