<?php
  session_start();
  require_once 'header.php';
  include_once 'src/Database.php';

  echo "<div class='center'>Welcome to Andrii's Campfire,";

  if ($loggedin) echo " $user, you are logged in";
  else           echo ' please sign up or log in';

  echo <<<_END
      </div><br>
    </div>
    <div data-role="footer">
      <h4>Andrii is on <i><a href='https://github.com/fecton'
      target='_blank'>GitHub</a></i></h4>
    </div>
  </body>
</html>
_END;

