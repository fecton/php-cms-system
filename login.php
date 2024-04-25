<?php
  require_once 'header.php';
  include_once 'src/Database.php';
  include_once 'src/Encryption.php';

  $error = $user = $pass = "";

  $db = new Database();

  if (isset($_POST['user']))
  {
    $user = $db->sanitizeString($_POST['user']);
    $pass = $db->sanitizeString($_POST['pass']);

    if ($user == "" || $pass == "")
      $error = 'Not all fields were entered';
    else
    {
      $encrypted_password = Encryption::hash($pass);
      echo "SELECT user,pass FROM members WHERE user='$user' AND pass='$encrypted_password'";
      $result = $db->queryMySQL("SELECT user,pass FROM members
        WHERE user='$user' AND pass='$encrypted_password'");

      if ($result->rowCount() == 0)
      {
        $error = "Invalid login attempt";
      }
      else
      {
        $_SESSION['user'] = $user;
        $_SESSION['pass'] = $pass;
        die("<div class='center'>You are now logged in. Please
             <a data-transition='slide'
               href='members.php?view=$user&r=$randstr'>click here</a>
               to continue.</div></div></body></html>");
      }
    }
  }

echo <<<_END
      <form method='post' action='login.php?r=$randstr'>
        <div data-role='fieldcontain'>
          <label></label>
          <span class='error'>$error</span>
        </div>
        <div data-role='fieldcontain'>
          <label></label>
          Please enter your details to log in
        </div>
        <div data-role='fieldcontain'>
          <label>Username</label>
          <input type='text' maxlength='16' name='user' value='$user'>
        </div>
        <div data-role='fieldcontain'>
          <label>Password</label>
          <input type='password' maxlength='16' name='pass' value='$pass'>
        </div>
        <div data-role='fieldcontain'>
          <label></label>
          <input data-transition='slide' type='submit' value='Login'>
        </div>
      </form>
    </div>
  </body>
</html>
_END;
?>
