<?php

class Validator
{
	public function __construct()
    {
		
	}
	
	
	public function check_create_fields($data)
	{
		$all_ok = true;
		$all_keys = array('emp_name','emp_code','emp_email','emp_phone','emp_address','emp_designation','emp_joining_date');		
		$missing_fields = array();
		
		if (empty($data) || !is_array($data))
		{
			throw new RestException("Could not parse request input",400,"Bad request");
		}
		$data_keys = array_keys($data);
		foreach($all_keys as $key)
		{
			if (!in_array($key,$data_keys) || empty($data[$key]))
			{
				$all_ok = false;
				$missing_fields[] = $key;		
			}
		}
		if (!$all_ok)
		{
			$missing= implode(",",$missing_fields);
			throw new RestException("missing or empty  fields: ".$missing,400,"Bad request");
		}
		$this->check_date_format($data['emp_joining_date']);
		$this->check_phone_format($data['emp_phone']);
		$this->check_email_format($data['emp_email']);
	}
	
	public function check_update_fields($data)
	{
		$all_ok = true;
		$all_keys = array('emp_name','emp_code','emp_email','emp_phone','emp_address','emp_designation','emp_joining_date');		
		$empty_fields = array();
		$data_keys = array_keys($data);
		
		foreach($all_keys as $key)
		{
			if (!in_array($key,$data_keys))
			{
				continue;
			}
			if ( empty($data[$key]))
			{
				$all_ok = false;
				$empty_fields[] = $key;		
			}
			else
			{
				switch($key)
				{
					case 'emp_email':
					     $this->check_email_format($data['emp_email']);
						 break;
					case 'emp_phone':
					     $this->check_phone_format($data['emp_phone']);
						 break;
					case 'emp_joining_date':
					     $this->check_date_format($data['emp_joining_date']);
					    break;
				}
			}
		}
		if (!$all_ok)
		{
			$empty_str = implode(",",$empty_fields);
			throw new RestException("Empty  fields: ".$empty_fields,400,"Bad request");
		}
	}
	
	public function check_date_format($date_val)
	{
		if (!preg_match('/^\d{4}\-\d{2}\-\d{2}$/',$date_val,$matches))
		{
			throw new RestException("Date format is invalid, should be YYYY-MM-DD ",400,"Bad request");
		}		
	}
	
	public function check_phone_format($phone_val)
	{
		if (!preg_match('/^[0-9]+$/',$phone_val,$matches))
		{
			throw new RestException("Phone format is invalid, should be only digits",400,"Bad request");
		}
	}
	
	public function check_email_format($email)
	{
		if (!filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			throw new RestException("Email format is invalid",400,"Bad request");
		}
	}

}