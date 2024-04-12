<?php
  require_once 'header.php';
  include_once 'src/Database.php';

  $db = new Database();

  if (isset($_SESSION['user']))
  {
    $db->destroySession();
    echo "<br><div class='center'>You have been logged out. Please
         <a data-transition='slide'
           href='index.php?r=$randstr'>click here</a>
           to refresh the screen.</div>";
  }
  else echo "<div class='center'>You cannot log out because
             you are not logged in</div>";
?>
    </div>
  </body>
</html>
