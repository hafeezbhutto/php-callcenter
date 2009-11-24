<?php
function formatTime($secs) {
	$times = array(3600, 60, 1);
	$time = '';
	$tmp = '';
	for($i = 0; $i < 3; $i++) {
		$tmp = floor($secs / $times[$i]);
		if ($tmp < 1) {
			$tmp = '00';
		} elseif ($tmp < 10) {
			$tmp = '0' . $tmp;
		}
		$time .= $tmp;
		if($i < 2) {
			$time .= ':';
		}
		$secs = $secs % $times[$i];
	}
	return $time;
}

function printTime($selected = 0)
{
	for($i = 0; $i < 60; $i++) {
		if ($i == $selected)
			echo ('<option selected value="'.$i.'">'. $i.'</option>');
		else
			echo ('<option value="'.$i.'">'. $i.'</option>');
	}
}

?>