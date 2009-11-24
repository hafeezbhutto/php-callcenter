<?php
//===DATABASE CONFIGURATION===//
//set the db info: server, user, password, table
$db = new db('server', 'user', 'password', 'table');
$db->setLogBuffer(false);

if (!($db->ok)) {
	$db->printNiceLog();
	die();
}

//the prefix of the dbs
$db->prefix = '';

//===OTHER CONFIGURATION===//
define('FOLDER', 'http://www.example.com/callcenter/');
define('THEME', 'default');
?>