<?php
  include_once 'src/Member.php';

  $db = new Database();

  if (isset($_POST['user']))
  {
    $member = new Member($_POST['user']);
    $result = $member->findRecordByUser();

    if ($result->rowCount())
      echo  "<span class='taken'>&nbsp;&#x2718; " .
            "The username '$member->user' is taken</span>";
    else
      echo "<span class='available'>&nbsp;&#x2714; " .
           "The username '$member->user' is available</span>";
  }
?>
