<?php
class debug
{
	public $msgs;
	public $buffer = true;
	
	private $div = array('<div style="padding:15px 10px 15px 50px;font-family:Arial, Helvetica, sans-serif;color: #00529B;background-color: #BDE5F8;border: 1px solid;margin: 10px 0px;">', '</div>');
	
	function setLogBuffer($buffer)
	{
		$this->buffer = $buffer;
	}
	
	function addToLog($msg)
	{
		if (!($this->buffer))
			echo ($this->div[0].$msg.$this->div[1]);
			
		$this->msgs[] = $msg;
	}
	
	function printLog()
	{
		print_r($this->msgs);
	}
	
	function printNiceLog($print = true)
	{
		for ($i = 0; $i < count($this->msgs); $i++)
		{
			if ($print)
				echo ($this->div[0].$this->msgs[$i].$this->div[1]);
			else
				$final .= $this->div[0].$this->msgs[$i].$this->div[1];
			
		}
		
		return $final;
	}
}

?>