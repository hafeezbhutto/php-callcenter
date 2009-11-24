<?php
require_once('inc/functions/safe.php');
require_once('inc/classes/debug.php');

class web extends debug
{
	function create($web)
	{
		global $db;
		
		$web = $db->escape($web);
		
		if (!empty($web)) {
			$query = $db->query("SELECT `id` FROM {$db->table['webs']} WHERE `web` = '$web'");
			$row = $db->newRow($query);
			
			if ($db->numRows() == 0) {
				$query = $db->query("INSERT INTO {$db->table['webs']} (`web`) VALUES ('$web')");
				$this->addToLog('web created');
			} else {
				$this->addToLog('invalid web: already exists');
				return false;
			}
				
		} else {
			$this->addToLog('invalid web: empty');
			return false;
		}
		
		return true;
	}
	
	function show()
	{
		global $db;
		
		$query = $db->query("SELECT * FROM {$db->table['webs']}");
		
		while($row = $db->newRow($query)) {
			echo('
								<tr>
									<td><input type="checkbox" name="delete[]" value="'.$row['id'].'"/></td>
									<td>'.$row['web'].'</td>
									<td><a href="?edit='.$row['id'].'">Edit</a></td>
								</tr>
			');
		}
		
	}
	
	function select($id = 0)
	{
		global $db;
		
		$query = $db->query("SELECT * FROM {$db->table['webs']}");
		
		while($row = $db->newRow($query)) {
			if ($row['id'] == $id)
				echo('<option selected value="'.$row['id'].'">'.$row['web'].'</option>');
			else
				echo('<option value="'.$row['id'].'">'.$row['web'].'</option>');
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
		
		$this->addToLog('web '.$this->idToName($id).' deleted');
		$query = $db->query("DELETE FROM {$db->table['webs']} WHERE `id` = '$id'");
	}
	
	function idToName($id)
	{
		global $db;
		
		$id = (int) $db->escape($id);
		
		$query = $db->query("SELECT * FROM {$db->table['webs']} WHERE `id` = '$id'");
		while($row = $db->newRow($query)) {
			return $row['web'];
		}
	}
	
	function edit($id, $web)
	{
		global $db;
		
		$id = (int) $db->escape($id);
		
		$this->addToLog('web '.$this->idToName($id).' edited');
		$query = $db->query("UPDATE {$db->table['webs']} SET `web` = '$web' WHERE `id` = '$id'");
	}
}
?>