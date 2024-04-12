<?php
  include_once 'src/Database.php';

  $db = new Database();

  if (isset($_POST['user']))
  {
    $user   = $db->sanitizeString($_POST['user']);
    $result = $db->queryMysql("SELECT * FROM members WHERE user='$user'");

    if ($result->rowCount())
      echo  "<span class='taken'>&nbsp;&#x2718; " .
            "The username '$user' is taken</span>";
    else
      echo "<span class='available'>&nbsp;&#x2714; " .
           "The username '$user' is available</span>";
  }
?>
