<?php
function get_user_detail()
{
  include "config.php";
  if (!empty($_SESSION['sess_user']) and !empty($_SESSION['sess_passwd'])) {
    include "dbconnect.php";
    $sql = "SELECT * FROM `staff` WHERE `user` LIKE '" . $_SESSION['sess_user'] . "' AND `passwd` LIKE '" . $_SESSION['sess_passwd'] . "' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 0) {
      #echo "<META HTTP-EQUIV=Refresh content=0;URL=login-form.php?ref=" . $_SERVER['PHP_SELF'] . ">";
      $output['user_id'] = '';
      $output['user_login'] = '';
      $output['user_name'] = '';
      $output['is_login'] = 0;
    } else {

      while ($row = mysqli_fetch_assoc($result)) {
        $output['user_id'] = $row['id'];
        $output['user_login'] = $row['user'];
        $output['user_name'] = $row['name'];
      }

      $output['is_login'] = 1;

      
    }
    mysqli_free_result($result);
    mysqli_close($conn);

    
  } else {
    $output['user_id'] = '';
    $output['user_login'] = '';
    $output['user_name'] = '';
    $output['is_login'] = 0;
    #echo "<META HTTP-EQUIV=Refresh content=0;URL=login-form.php?ref=" . $_SERVER['PHP_SELF'] . ">";
    #exit();
  }

  return $output;
}
