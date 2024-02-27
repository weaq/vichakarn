<?php
include "config.php";
if (!empty($_SESSION['sess_user']) and !empty($_SESSION['sess_passwd'])) {
  include "dbconnect.php";
  $sql = "SELECT * FROM `staff` WHERE `user` LIKE '" . $_SESSION['sess_user'] . "' AND `passwd` LIKE '" . $_SESSION['sess_passwd'] . "' LIMIT 1";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) == 0) {
    echo "<META HTTP-EQUIV=Refresh content=0;URL=login-form.php?ref=" . $_SERVER['PHP_SELF'] . ">";
  } else {
    // get data
    while ($row = mysqli_fetch_assoc($result)) {
      $_SESSION['sess_user_id'] = $row['id'];
    }

    // update last login
    $sql = "UPDATE `staff` SET id = LAST_INSERT_ID(id), last_login = now() WHERE `user` LIKE '$_SESSION[sess_user]' ";
    mysqli_query($conn, $sql);
  }
  mysqli_free_result($result);
  mysqli_close($conn);
} else {
  echo "<META HTTP-EQUIV=Refresh content=0;URL=login-form.php?ref=" . $_SERVER['PHP_SELF'] . ">";
  exit();
}
