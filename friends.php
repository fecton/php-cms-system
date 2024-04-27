<?php
  require_once 'header.php';
  include_once 'src/Database.php';
  include_once 'src/Friend.php';

  $db = new Database();

  if (!$loggedin) die("</div></body></html>");

  if (isset($_GET['view'])) $view = $db->sanitizeString($_GET['view']);
  else                      $view = $user;

  if ($view == $user)
  {
    $name1 = $name2 = "Your";
    $name3 =          "You are";
  }
  else
  {
    $name1 = "<a data-transition='slide'
              href='members.php?view=$view&r=$randstr'>$view</a>'s";
    $name2 = "$view's";
    $name3 = "$view is";
  }

  $friend = new Friend($view);
  $followers = $friend->getFollowersByUser();
  $following = $friend->getFollowingByUser();

  $mutual    = array_intersect($followers, $following);
  $followers = array_diff($followers, $mutual);
  $following = array_diff($following, $mutual);
  $friends   = FALSE;

  echo "<br>";

  if (sizeof($mutual))
  {
    echo "<span class='subhead'>$name2 mutual friends</span><ul>";
    foreach($mutual as $friend)
      echo "<li><a data-transition='slide'
            href='members.php?view=$friend&r=$randstr'>$friend</a>";
    echo "</ul>";
    $friends = TRUE;
  }

  if (sizeof($followers))
  {
    echo "<span class='subhead'>$name2 followers</span><ul>";
    foreach($followers as $friend)
      echo "<li><a data-transition='slide'
            href='members.php?view=$friend&r=$randstr'>$friend</a>";
    echo "</ul>";
    $friends = TRUE;
  }

  if (sizeof($following))
  {
    echo "<span class='subhead'>$name3 following</span><ul>";
    foreach($following as $friend)
      echo "<li><a data-transition='slide'
            href='members.php?view=$friend&r=$randstr'>$friend</a>";
    echo "</ul>";
    $friends = TRUE;
  }

  if (!$friends) echo "<br>You don't have any friends yet.";
?>
    </div><br>
  </body>
</html>
