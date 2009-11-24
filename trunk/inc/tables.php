<?php
$db->table = array('users' => $db->addPrefix('users'),
					 'customers' => $db->addPrefix('customers'),
					 'calls' => $db->addPrefix('calls'),
					 'webs' => $db->addPrefix('webs'),
					 'subjects' => $db->addPrefix('subjects'),
					 'options' => $db->addPrefix('options')
			 );
?>