<?php

class RestException extends Exception
{
	private $status;
	
	public function __construct($msg,$code,$stat)
    {
		parent::__construct($msg,$code);
		$this->status = $stat;
	}
	public function getStatus()
	{
		return ($this->status);
	}
}