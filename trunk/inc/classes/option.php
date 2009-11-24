<?php
require_once('inc/functions/safe.php');
require_once('inc/classes/debug.php');

class option extends debug
{
	function show()
	{
		global $db;
		
		echo('
								<tr>
									<td>Calls per page:</td>
									<td><input type="text" name="calls_per_page" value="'.$this->get('calls_per_page').'"/></td>
								</tr>
								<tr>
									<td>Customers per page:</td>
									<td><input type="text" name="customers_per_page" value="'.$this->get('customers_per_page').'"/></td>
								</tr>
		');
		
	}
	
	function get($name)
	{
		global $db;
		
		$name = $db->escape($name);
		
		$query = $db->query("SELECT `value` FROM `{$db->table['options']}` WHERE `name` = '$name'");
		$row = $db->newRow($query);
		
		if ($db->numRows() > 0) {
			return $row['value'];
		} else {
			$this->addToLog('invalid option name');
			return false;
		}
	}
	
	function edit($name, $value)
	{
		global $db;
		
		$name = $db->escape($name);
		$value = $db->escape($value);
		
		$query = $db->query("UPDATE `{$db->table['options']}` SET `value` = '$value' WHERE `name` = '$name'");
	}
}
?>