<?php
  require_once 'header.php';
  include_once 'src/Database.php';

  $db = new Database();

echo <<<_END
  <script src="js/check_user.js"></script>
_END;

  $error = $user = $pass = "";
  if (isset($_SESSION['user'])) $db->destroySession();

  if (isset($_POST['user']))
  {
    $user = $db->sanitizeString($_POST['user']);
    $pass = $db->sanitizeString($_POST['pass']);

    if ($user == "" || $pass == "")
      $error = 'Not all fields were entered<br><br>';
    else
    {
      $result = $db->queryMysql("SELECT * FROM members WHERE user='$user'");

      if ($result->rowCount())
        $error = 'That username already exists<br><br>';
      else
      {
        $db->queryMysql("INSERT INTO members VALUES('$user', '$pass')");
        die('<h4>Account created</h4>Please Log in.</div></body></html>');
      }
    }
  }

echo <<<_END
      <form method='post' action='signup.php?r=$randstr'>$error
      <div data-role='fieldcontain'>
        <label></label>
        Please enter your details to sign up
      </div>
      <div data-role='fieldcontain'>
        <label>Username</label>
        <input type='text' maxlength='16' name='user' value='$user'
          onBlur='checkUser(this)'>
        <label></label><div id='used'>&nbsp;</div>
      </div>
      <div data-role='fieldcontain'>
        <label>Password</label>
        <input type='text' maxlength='16' name='pass' value='$pass'>
      </div>
      <div data-role='fieldcontain'>
        <label></label>
        <input data-transition='slide' type='submit' value='Sign Up'>
      </div>
    </div>
  </body>
</html>
_END;
?>
