<?php
  require_once 'header.php';
  require_once 'src/Profile.php';

  $db = new Database();

  if (!$loggedin) die("</div></body></html>");


  echo "<h3>Your Profile</h3>";

  $result = new Profile($user);

  if (isset($_POST['text']))
  {
    $result->set_text($_POST['text']);
  }

  if (isset($_FILES['image']['name']))
  {
    $saveto = "$user.jpg";
    move_uploaded_file($_FILES['image']['tmp_name'], $saveto);
    $typeok = TRUE;

    switch($_FILES['image']['type'])
    {
      case "image/gif":   $src = imagecreatefromgif($saveto); break;
      case "image/jpeg":  $src = imagecreatefromjpeg($saveto); break;
      case "image/png":   $src = imagecreatefrompng($saveto); break;
      default:            $typeok = FALSE; break;
    }

    if ($typeok)
    {
      list($w, $h) = getimagesize($saveto);

      $max = 100;
      $tw  = $w;
      $th  = $h;

      if ($w > $h && $max < $w)
      {
        $th = $max / $w * $h;
        $tw = $max;
      }
      elseif ($h > $w && $max < $h)
      {
        $tw = $max / $h * $w;
        $th = $max;
      }
      elseif ($max < $w)
      {
        $tw = $th = $max;
      }

      $tmp = imagecreatetruecolor($tw, $th);
      imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tw, $th, $w, $h);
      imageconvolution($tmp, array(array(-1, -1, -1),
        array(-1, 16, -1), array(-1, -1, -1)), 8, 0);
      imagejpeg($tmp, $saveto);
      imagedestroy($tmp);
      imagedestroy($src);
    }
  }

  $db->showProfile($user);

echo <<<_END
      <form data-ajax='false' method='post'
        action='profile.php?r=$randstr' enctype='multipart/form-data'>
      <h3>Enter or edit your details and/or upload an image</h3>
      <textarea name='text'>$text</textarea><br>
      Image: <input type='file' name='image' size='14'>
      <input type='submit' value='Save Profile'>
      </form>
    </div><br>
  </body>
</html>
_END;
?>
