<?php
session_start();
$_SESSION['sess_user'] = "";
$_SESSION['sess_passwd'] = "";
$_SESSION['sess_user_id'] = "";

// url server
$url_server = (isset($_SERVER['HTTPS']))? "https://" : "http://" ;
$url_server .= $_SERVER['HTTP_HOST'];

$url = $url_server . dirname($_SERVER['PHP_SELF']);

echo 'Log out success. : redirect to ' . $url;
header( "refresh:2;url=$url" );
exit();
?>
