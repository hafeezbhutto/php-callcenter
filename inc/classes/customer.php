<?php
require_once('inc/functions/safe.php');
require_once('inc/classes/debug.php');

class customer extends debug
{
	var $items_per_page = 10;
	
	function validCustomer($mail)
	{
		//mail
		if (!(preg_match('/^([a-z0-9])(([-a-z0-9._])*([a-z0-9]))*\@([a-z0-9])*(\.([a-z0-9])([-a-z0-9_-])([a-z0-9])+)*$/i', $mail) > 0)) {
			$this->addToLog('invalid mail: characters');
			$error++;
		}
		
		if ($error != 0)
			return false;
		
		return true;
	}
	
	function create($name, $mail, $city, $country, $phone)
	{
		global $db;
		
		$name = $db->escape($name);
		$mail = $db->escape($mail);
		$city = $db->escape($city);
		$country = $db->escape($country);
		$phone = $db->escape($phone);
		
		if ($this->validCustomer($mail)) {
				if (!($this->exists($mail, false))) {
					$query = $db->query("INSERT INTO {$db->table['customers']} (`name`, `mail`, `city`, `country`, `phone`) VALUES ('$name', '$mail', '$city', '$country', '$phone')");
					$this->addToLog('customer created');
				} else {
					$this->addToLog('invalid customer: already exists');
					return false;
				}
				
		} else {
			return false;
		}
		return true;
	}

	function edit($id, $name, $mail, $city, $country, $phone)
	{
		global $db;
		
		$id = (int) $db->escape($id);
		$name = $db->escape($name);
		$mail = $db->escape($mail);
		$city = $db->escape($city);
		$country = $db->escape($country);
		$phone = $db->escape($phone);
		
		if ($this->validCustomer($mail)) {
			$query = $db->query("UPDATE {$db->table['customers']} set `name` = '$name', `mail` = '$mail', `city` = '$city', `country` = '$country', `phone` = '$phone' WHERE `id` = '$id'");
			$this->addToLog('customer edited');
		} else {
			return false;
		}
		return true;
	}
	
	function printPages($p = 0)
	{
		global $db;
		
		$query = $db->query("SELECT count(*) FROM {$db->table['customers']}");
		$row = $db->newRow($query);
		
		$pages = $row['count(*)'] / $this->items_per_page;
		
		for ($i = 0; $i < $pages; $i++) {
			if ($p == $i)
				echo (' <a href="?p='.$i.'"><b>'.$i.'</b></a> ');
			else
				echo (' <a href="?p='.$i.'"><b>'.$i.'</b></a> ');
		}
	}
	
	function exists($mail, $print = true)
	{
		global $db;
		
		$mail = $db->escape($mail);

		$query = $db->query("SELECT count(*) FROM {$db->table['customers']} WHERE `mail` = '$mail'");
		$row = $db->newRow($query);
			
		if ($row['count(*)'] == 0) {
			if ($print)
				echo ('Invalid mail');
			return false;
		} else {
			if ($print)
				echo ('Valid mail');
			return true;
		}
	}

	function validId($id)
	{
		global $db;
		
		$id = (int) $db->escape($id);

		$query = $db->query("SELECT `id` FROM {$db->table['customers']} WHERE `id` = '$id'");
		$row = $db->newRow($query);

		if ($db->numRows() == 0) {
			$this->addToLog('invalid id');
			return false;
		} else {
			return true;
		}
	}
	
	function MailToId($mail)
	{
		global $db;
		
		$mail = $db->escape($mail);

		$query = $db->query("SELECT * FROM {$db->table['customers']} WHERE `mail` = '$mail'");
		$row = $db->newRow($query);
			
		return $row['id'];
	}
	
	function show($p = 0)
	{
		global $db;
		
		$p = (int) $p * $this->items_per_page;
		
		require_once('inc/classes/country.php');
		$country = new country;
		
		$query = $db->query("SELECT * FROM {$db->table['customers']} ORDER BY `id` DESC LIMIT $p, {$this->items_per_page}");
		
		while($row = $db->newRow($query)) {
			echo('
								<tr>
									<td><input type="checkbox" name="delete[]" value="'.$row['id'].'"/></td>
									<td>'.$row['name'].'</td>
									<td>'.$row['mail'].'</td>
									<td>'.$row['city'].'</td>
									<td>'.$country->idToCountry($row['country']).'</td>
									<td>'.$row['phone'].'</td>
									<td><a href="?edit='.$row['id'].'">Edit</a></td>
								</tr>
			');
		}
		
	}
	
	function deleteSelected()
	{
		global $db;
		
		foreach ($_POST['delete'] as $id) {
			$id = (int) $db->escape($id);
			$this->delete($id);
		}
		
	}
	
	function delete($id)
	{
		global $db;
		
		$id = (int) $db->escape($id);
		
		$this->addToLog('customer '.$this->idToName($id).' deleted');
		$query = $db->query("DELETE FROM {$db->table['customers']} WHERE `id` = '$id'");
	}
	
	function idToName($id)
	{
		global $db;
		
		$id = (int) $db->escape($id);
		
		$query = $db->query("SELECT * FROM {$db->table['customers']} WHERE `id` = '$id'");
		while($row = $db->newRow($query)) {
			return $row['name'];
		}
	}
	
	function lastCustomers()
	{
		global $db;
		
		$query = $db->query("SELECT * FROM {$db->table['customers']} ORDER BY `id` DESC LIMIT 5");
		
		while($row = $db->newRow($query)) {
			echo('<li><a href="customers.php?edit='.$row['id'].'">'.$row['name'].'</a></li>');
		}
		
	}
	
	function getInfo($id)
	{
		global $db;
		
		$id = (int) $db->escape($id);

		$query = $db->query("SELECT * FROM {$db->table['customers']} WHERE `id` = '$id'");
		$row = $db->newRow($query);
		
		if (empty($row)) {
			//$this->addToLog('invalid id');
			return false;
		} else {
			return $row;
		}
		
	}
	
}

?>