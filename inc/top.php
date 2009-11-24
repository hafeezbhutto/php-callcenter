<?php
require_once('inc/classes/debug.php');

$debug = new debug;
$debug->setLogBuffer(false);

require_once('inc/classes/db.php');
require_once('inc/config.php');
require_once('inc/tables.php');
?>