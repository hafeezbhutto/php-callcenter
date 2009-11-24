<?php
//required includes at start
require_once('inc/top.php');

//others required includes only here
require_once('inc/session.php');
require_once('inc/classes/customer.php');

$customer = new customer;
$customer->exists($_POST['mail']);

//required includes at end
require_once('inc/bottom.php');
?>