<?php
  require_once 'header.php';
  include_once 'src/Database.php';
  include_once 'src/Member.php';
  include_once 'src/Friend.php';

  $db = new Database();

  if (!$loggedin) die("</div></body></html>");

  if (isset($_GET['view']))
  {
    $view = $db->sanitizeString($_GET['view']);

    if ($view == $user) $name = "Your";
    else                $name = "$view's";

    echo "<h3>$name Profile</h3>";
    $db->showProfile($view);
    echo "<a data-role='button' data-transition='slide'
          href='messages.php?view=$view&r=$randstr'>View $name messages</a>";
    die("</div></body></html>");
  }

  if (isset($_GET['add']))
  {
    $friend = new Friend($_GET['add']);
    $friend->setFriend($user);

    $friend->insertIfExists();
  }
  elseif (isset($_GET['remove']))
  {
    $friend = new Friend($_GET['remove']);
    $friend->setFriend($user);

    $friend->removeFriendship();
  }

  $result = Friend::showAll();
  $num    = $result->rowCount();

  while ($row = $result->fetch())
  {
    if ($row['user'] == $user) continue;

    echo "<li><a data-transition='slide' href='members.php?view=" .
      $row['user'] . "&$randstr'>" . $row['user'] . "</a>";
    $follow = "follow";

    $result1 = Friend::getFollowingStatus($row['user'], $user);
    $t1      = $result1->rowCount();

    $result1 = Friend::getFollowerStatus($row['user'], $user);
    $t2      = $result1->rowCount();

    if (($t1 + $t2) > 1) echo " &harr; is a mutual friend";
    elseif ($t1)         echo " &larr; you are following";
    elseif ($t2)       { echo " &rarr; is following you";
                         $follow = "recip"; }

    if (!$t1) echo " [<a data-transition='slide'
      href='members.php?add=" . $row['user'] . "&r=$randstr'>$follow</a>]";
    else      echo " [<a data-transition='slide'
      href='members.php?remove=" . $row['user'] . "&r=$randstr'>drop</a>]";
  }

?>
    </ul></div>
  </body>
</html>
