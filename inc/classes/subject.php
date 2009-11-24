<?php
require_once('inc/functions/safe.php');
require_once('inc/classes/debug.php');

class subject extends debug
{
	function create($subject)
	{
		global $db;
		
		$subject = $db->escape($subject);
		
		if (!empty($subject)) {
			$query = $db->query("SELECT `id` FROM {$db->table['subjects']} WHERE `subject` = '$subject'");
			$row = $db->newRow($query);
			
			if ($db->numRows() == 0) {
				$query = $db->query("INSERT INTO {$db->table['subjects']} (`subject`) VALUES ('$subject')");
				$this->addToLog('subject created');
			} else {
				$this->addToLog('invalid subject: already exists');
				return false;
			}
				
		} else {
			$this->addToLog('invalid subject: empty');
			return false;
		}
		
		return true;
	}
	
	function show()
	{
		global $db;
		
		$query = $db->query("SELECT * FROM {$db->table['subjects']}");
		
		while($row = $db->newRow($query)) {
			echo('
								<tr>
									<td><input type="checkbox" name="delete[]" value="'.$row['id'].'"/></td>
									<td>'.$row['subject'].'</td>
									<td><a href="?edit='.$row['id'].'">Edit</a></td>
								</tr>
			');
		}
		
	}
	
	function select($id = 0)
	{
		global $db;
		
		$query = $db->query("SELECT * FROM {$db->table['subjects']}");
		
		while($row = $db->newRow($query)) {
			if ($row['id'] == $id)
				echo('<option selected value="'.$row['id'].'">'.$row['subject'].'</option>');
			else
				echo('<option value="'.$row['id'].'">'.$row['subject'].'</option>');
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
		
		$this->addToLog('subject '.$this->idToName($id).' deleted');
		$query = $db->query("DELETE FROM {$db->table['subjects']} WHERE `id` = '$id'");
	}
	
	function idToName($id)
	{
		global $db;
		
		$id = (int) $db->escape($id);
		
		$query = $db->query("SELECT * FROM {$db->table['subjects']} WHERE `id` = '$id'");
		while($row = $db->newRow($query)) {
			return $row['subject'];
		}
	}
	
	function edit($id, $subject)
	{
		global $db;
		
		$id = (int) $db->escape($id);
		
		$this->addToLog('subject '.$this->idToName($id).' edited');
		$query = $db->query("UPDATE {$db->table['subjects']} SET `subject` = '$subject' WHERE `id` = '$id'");
	}
}
?>