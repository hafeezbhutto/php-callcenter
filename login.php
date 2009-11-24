<?php
//required includes at start
require_once('inc/top.php');

//others required includes only here
require_once('inc/classes/user.php');

if ((isset($_POST['user'])) && (isset($_POST['password']))) {
	$user = new user;
	if ($user->login($_POST['user'], $_POST['password'], $_POST['rememberme']))
		header("Location: index.php");
	else
		$msg = $user->printNiceLog(false);
}

//theme login
include_once('themes/'.THEME.'/login.php');

//required includes at end
require_once('inc/bottom.php');
?>