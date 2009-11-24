<?php
require_once('inc/classes/user.php');

$user = new user;
if (!($user->isLogged()))
	header("Location: login.php");
else
	$GLOBALS['group'] = $_SESSION['group'];
?>