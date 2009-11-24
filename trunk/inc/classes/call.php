<?php
require_once('inc/classes/debug.php');

class call extends debug
{
	var $items_per_page = 10;

	function validCall()
	{
		return true;
	}
	
	function create($operator, $type, $web, $subject, $duration, $comments, $customer)
	{
		global $db;
		
		$operator = $db->escape($operator);
		$type = $db->escape($type);
		$web = $db->escape($web);
		$subject = $db->escape($subject);
		$duration = $db->escape($duration);
		$comments = $db->escape($comments);
		$customer = $db->escape($customer);
		
		if ($this->validCall()) {
			$query = $db->query("INSERT INTO {$db->table['calls']} (`operator`, `type`, `web`, `subject`, `duration`, `comments`, `customer`, `date`) VALUES ('$operator', '$type', '$web', '$subject', '$duration', '$comments', '$customer', NOW())");
			$this->addToLog('call created');
		} else {
			return false;
		}
		
		return true;
	}

	function edit($id, $operator, $type, $web, $subject, $duration, $comments, $customer)
	{
		global $db;
		
		$id = (int) $db->escape($id);
		$operator = $db->escape($operator);
		$type = $db->escape($type);
		$web = $db->escape($web);
		$subject = $db->escape($subject);
		$duration = $db->escape($duration);
		$comments = $db->escape($comments);
		$customer = $db->escape($customer);
		
		if ($this->validCall()) {
			$query = $db->query("UPDATE {$db->table['calls']} SET `operator` = '$operator', `type` = '$type', `web` = '$web', `subject` = '$subject', `duration` = '$duration', `comments` = '$comments', `customer` = '$customer' WHERE `id` = '$id'");
			$this->addToLog('call edited');
		} else {
			return false;
		}
		
		return true;
	}

	function validId($id)
	{
		global $db;
		
		$id = (int) $db->escape($id);

		$query = $db->query("SELECT `id` FROM `{$db->table['calls']}` WHERE `id` = '$id'");
		$row = $db->newRow($query);

		if ($db->numRows() == 0) {
			$this->addToLog('invalid id');
			return false;
		} else {
			return true;
		}
	}	
	
	function printPages($p = 0)
	{
		global $db;
		
		$where = $this->search();
		$query = $db->query("SELECT count(*) FROM {$db->table['calls']} $where");
		$row = $db->newRow($query);
		
		$pages = $row['count(*)'] / $this->items_per_page;
		
		for ($i = 0; $i < $pages; $i++) {
			if ($p == $i)
				echo (' <a href="?p='.$i.'"><b>'.$i.'</b></a> ');
			else
				echo (' <a href="?p='.$i.'"><b>'.$i.'</b></a> ');
		}
	}
	
	function search()
	{
		global $db;
		
		if ((isset($_GET['date1'])) && (isset($_GET['date2'])) && (isset($_GET['type'])) && (isset($_GET['web'])) && (isset($_GET['subject'])) && (isset($_GET['mail'])) && (isset($_GET['customer']))) {
			$date1 = $db->escape($_GET['date1']);
			$date2 = $db->escape($_GET['date2']);
			$type = $db->escape($_GET['type']);
			$web = $db->escape($_GET['web']);
			$subject = $db->escape($_GET['subject']);
			$mail = $db->escape($_GET['mail']);
			$customer = $db->escape($_GET['customer']);
			
			$where = "WHERE";
			
			if ((!(empty($date1))) && (!(empty($date1))))
				$where .= " (`date` >= '$date1 00:00:00' AND `date` <= '$date2 23:59:59')";
			else 
				$where .= " (1 = 1)";
			if (!(empty($type)))
				$where .= " AND (`type` = '$type')";
			if (!(empty($web)))
				$where .= " AND (`web` = '$web')";
			if (!(empty($subject)))
				$where .= " AND (`subject` = '$subject')";
			if (!(empty($mail)))
				$where .= " AND (`customer` IN (SELECT `id` FROM `customers` WHERE `mail` LIKE '%$mail%'))";
			if (!(empty($customer)))
				$where .= " AND (`customer` IN (SELECT `id` FROM `customers` WHERE `name` LIKE '%$cutomer%'))";				
		}
		
		return $where;
	}
	
	function show($p = 0)
	{
		global $db;
		
		$p = (int) $p * $this->items_per_page;
		$where = $this->search();
		$query = $db->query("SELECT * FROM {$db->table['calls']} $where ORDER BY `id` DESC LIMIT $p, {$this->items_per_page}");
		
		require_once('inc/functions/time.php');
		require_once('inc/classes/user.php');
		require_once('inc/classes/customer.php');
		require_once('inc/classes/web.php');
		require_once('inc/classes/subject.php');
		require_once('inc/classes/country.php');
		
		$user = new user;
		$customer = new customer;
		$web = new web;
		$subject = new subject;
		$country = new country;

		while($row = $db->newRow($query)) {
			$status = '';
		
			if ($row['type'] == 'Incoming')
				$type = 'background-color:red;';
			else if ($row['type'] == 'Outgoing')
				$type = 'background-color:green;';
			else if ($row['type'] == 'Chat')
				$type = 'background-color:blue;';
				
			echo('
								<tr>
									<td style="'.$type.'"><input type="checkbox" name="delete[]" value="'.$row['id'].'"/></td>
									<td>'.$row['id'].'</td>
									<td>'.$user->idToUser($row['operator']).'</td>
									<td>'.$web->idToName($row['web']).'</td>
									<td>'.$subject->idToName($row['subject']).'</td>
									<td>'.formatTime($row['duration']).'</td>
									<td>'.$customer->idToName($row['customer']).'</td>
									<td>'.$row['date'].'</td>
									<td><a href="edit.php?id='.$row['id'].'">Edit</a></td>
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
		
		$this->addToLog('call deleted');
		$query = $db->query("DELETE FROM {$db->table['calls']} WHERE `id` = '$id'");
	}

	function getInfo($id)
	{
		global $db;
		
		$id = (int) $db->escape($id);
		$query = $db->query("SELECT * FROM {$db->table['calls']} WHERE `id` = '$id'");
		$row = $db->newRow($query);
		
		if (empty($row)) {
			//$this->addToLog('invalid id');
			return false;
		} else {
			return $row;
		}
	}
	
	function lastCalls()
	{
		global $db;
		
		$query = $db->query("SELECT * FROM {$db->table['calls']} ORDER BY `id` DESC LIMIT 5");
		
		//require_once('inc/classes/customer.php');
		require_once('inc/classes/web.php');
		require_once('inc/classes/subject.php');
		
		//$customer = new customer;
		$web = new web;
		$subject = new subject;
		
		while($row = $db->newRow($query)) {
		
			if ($row['type'] == 'Incoming')
				$type = 'red';
			else if ($row['type'] == 'Outgoing')
				$type = 'green';
			else if ($row['type'] == 'Outgoing')
				$type = 'blue';
				
			echo('<li><a href="edit.php?id='.$row['id'].'"><font color="'.$type.'">['.$web->idToName($row['web']).'] '.$subject->idToName($row['subject']).'</font></a></li>');
		}
		
	}	
}
?>