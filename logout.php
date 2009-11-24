<?php
//required includes at start
require_once('inc/top.php');

//others required includes only here
require_once('inc/classes/user.php');

$user = new user;
$user->logout();
header("Location: login.php");

//required includes at end
require_once('inc/bottom.php');
?>