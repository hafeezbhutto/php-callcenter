<?php
function sanitize($val, $htmlentities = false)
{
	$val = mysql_real_escape_string($val);
	
	if ($htmlentities)
		$val = htmlentities($val, ENT_QUOTES);
	
	return $val;
}
?>