<?php
require_once('inc/functions/safe.php');
require_once('inc/classes/debug.php');

class user extends debug
{
	private $permissions = array('administrator', 'operator');

	function validUser($user, $password, $mail)
	{
		//user
		if ((strlen($user) < 3) || (strlen($user) > 15)) {
			$this->addToLog('invalid user: length');
			$error++;
		}
		if (!preg_match('/^[a-z0-9]+$/', $user)) {
			$this->addToLog('invalid user: characters');
			$error++;
		}
		
		//password
		if ((strlen($password) < 3) || (strlen($password) > 255)) {
			$this->addToLog('invalid password: length');
			$error++;
		}
		
		//mail
		if (!(preg_match('/^([a-z0-9])(([-a-z0-9._])*([a-z0-9]))*\@([a-z0-9])*(\.([a-z0-9])([-a-z0-9_-])([a-z0-9])+)*$/i', $mail) > 0)) {
			$this->addToLog('invalid mail: characters');
			$error++;
		}
		if (!(strlen($mail) <= 255)) {
			$this->addToLog('invalid mail: length');
			$error++;
		}
		
		if ($error != 0)
			return false;
		
		return true;
	}
	
	function create($user, $password, $mail, $permissions = '')
	{
		global $db;
		
		$user = $db->escape($user);
		$password = $db->escape($password);
		$mail = $db->escape($mail);
		
		if ($this->validUser($user, $password, $mail)) {
				if (empty($permissions))
					$permissions = 5;
				
				$query = $db->query("SELECT FROM {$db->table['users']} WHERE `user` = '$user'");
				$row = $db->newRow($query);
			
				if ($db->numRows() == 0)
					$query = $db->query("INSERT INTO {$db->table['users']} (`user`, `password`, `mail`, `permissions`) VALUES ('$user', MD5('$password'), '$mail', '$permissions')");
				else {
					$this->addToLog('invalid user: already exists');
					return false;
				}
				
		} else {
			return false;
		}
		
		return true;
	}
	
	function login($user, $password, $rememberme = '')
	{
		global $db;
		
		$user = $db->escape($user);
		$password = $db->escape($password);
				
		$query = $db->query("SELECT `id`, `user`, `mail` FROM {$db->table['users']} WHERE `user` = '$user' AND `password` = MD5('$password')");
		$row = $db->newRow($query);
		
		if ($db->numRows() == 1) {
			session_start();
		
			$_SESSION['users']['id'] = $row['id'];
			$_SESSION['users']['user'] = $row['user'];
			$_SESSION['users']['mail'] = $row['mail'];
			
			if ($rememberme == 'yes') {
				setcookie("user", $user, time() + 60 * 60 * 24 * 100, "/");
				setcookie("password", $password, time() + 60 * 60 * 24 * 100, "/");
			}
			
			return true;
		} else {
			$this->addToLog('invalid login: incorrect password or user');
			
			return false;
		}
	}

	function logout()
	{
		global $db;
		
		session_start();
		
		unset ($_SESSION['users']['id']);
		unset ($_SESSION['users']['user']);
		unset ($_SESSION['users']['mail']);
		
		unset ($_COOKIE['user']);
		unset ($_COOKIE['password']);
		
		setcookie("user", "", time() - 3600, "/");
		setcookie("password", "", time() - 3600, "/");
		
		session_destroy();	
	}
	
	function isLogged()
	{
		session_start();
		
		if ((isset($_COOKIE['user'])) && (isset($_COOKIE['password'])))
			if ($this->login($_COOKIE['user'], $_COOKIE['password'], NULL))
				return true;
		
		if (!(isset($_SESSION['users']['user'])))
			return false;
		
		return true;
	}
	
	function idToUser($id)
	{
		global $db;
		
		$id = (int) $db->escape($id);
		
		$query = $db->query("SELECT `user` FROM `{$db->table['users']}` WHERE `id` = '$id'");
		$row = $db->newRow($query);
		
		return $row['user'];
	}
	
	function getPermissions($id)
	{
		global $db;
		
		$id = (int) $db->escape($id);
		
		$query = $db->query("SELECT `permissions` FROM `{$db->table['users']}` WHERE `id` = '$id'");
		$row = $db->newRow($query);
		
		return $this->permissions[$row['permissions']];
	}	
}
?>