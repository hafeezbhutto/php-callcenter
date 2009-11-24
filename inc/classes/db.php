<?php
require_once('inc/classes/debug.php');

class db extends debug
{
	public $db, $link, $num_queries, $ok, $num_rows;
	
	public $prefix;
	public $prefix_user;
	
	public $table;
	
	function addPrefix($table)
	{
		$final = $this->prefix.$table;
		return $final;
	}

	function addPrefixUser($table)
	{
		$final = $this->prefix_user.$table;
		return $final;
	}
	
	function __construct($server, $user, $password, $database) //connect()
	{
		$this->db['server'] = $server;
		$this->db['user'] =	$user;
		$this->db['password'] = $password;
		$this->db['database'] = $database;
		$this->db['error'] = $error;
	
		$this->link = @mysql_connect($this->db['server'], $this->db['user'], $this->db['password']);
		if ($this->link) {
			if (!mysql_select_db($this->db['database'])) {
				$this->addToLog('Unable to connect to the database');
				$this->ok = false;
			} else {
				$this->ok = true;
			}
		} else {
			$this->addToLog('Unable to connect to the database');
			$this->ok = false;
		}
		
	}
	
	function __destruct() //disconnect()
	{
		if ($this->link)
			mysql_close();
	}
	
	function query($query, $debug = false, $no_errors = false)
	{
		if ($this->link) {
			@$result = mysql_query($query);
			$this->num_queries++;
			@$this->num_rows = mysql_num_rows($result);
			if (($result) || ($no_errors)) {
				
				if ($debug) {

					$count = 0;
					while($row = @mysql_fetch_array($result, MYSQL_BOTH)) {
						$count++;
					}
					
					$values = print_r($row, true);
					$final = '<b>'.$query.'</b><br><pre>'.$values.'</pre>';
					$this->addToLog($final);
				}
				
				return $result;

			} else {
				$this->addToLog(mysql_error());
			}
			
		} else {
			$this->addToLog(mysql_error());
		}
	}
	
	function numRows() {
		return $this->num_rows;
	}
	
	function newRow($query)
	{
		if ($query)
			return mysql_fetch_assoc($query);
	}
	
	function getNumQueries()
	{
		return $this->num_queries;
	}

	//from WP 2.8.1
	function _real_escape($string)
	{
		if ($this->link)
			return mysql_real_escape_string($string, $this->link);
		else
			return addslashes($string);
	}

	//original function is called _escape
	function escape($data)
	{
		if (is_array($data)) {
			foreach ((array)$data as $k => $v) {
				if (is_array($v))
					$data[$k] = $this->_escape($v);
				else
					$data[$k] = $this->_real_escape($v);
			}
		} else {
			$data = $this->_real_escape($data);
		}

		return $data;
	}
	
	function escape_by_ref(&$string) {
		$string = $this->_real_escape($string);
	}

	function prepare($query = null) 
	{
		if ( is_null( $query ) )
			return;
		$args = func_get_args();
		array_shift($args);
		// If args were passed as an array (as in vsprintf), move them up
		if ( isset($args[0]) && is_array($args[0]) )
			$args = $args[0];
		$query = str_replace("'%s'", '%s', $query); // in case someone mistakenly already singlequoted it
		$query = str_replace('"%s"', '%s', $query); // doublequote unquoting
		$query = str_replace('%s', "'%s'", $query); // quote the strings
		array_walk($args, array(&$this, 'escape_by_ref'));
		return @vsprintf($query, $args);
	}	
	
}
?>