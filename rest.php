<?php 

class Rest
{
	private $endpoint;
	private $dbObj;
	
	public function __construct($endpoint)
    {
		$this->endpoint = $endpoint;
		$this->dbObj = new DbAccess();
		$this->validator = new Validator();
	}

	public function get_all_employees()
	{
		if ($this->endpoint === '/employees') 
		{
			$employees = $this->dbObj->getAllEmployees();
			$result = $employees;
		} 
		elseif (preg_match('/^\/employees\/(\d+)$/', $this->endpoint, $matches))     // Get employee by ID
		{
			$employeeId = $matches[1];
			$employee = $this->dbObj->getEmployeeById($employeeId);
			$result = $employee;
		}
		else
		{
			throw new RestException("Wrong endpoint format",400,"Bad request");
		}
		
		return($result);
	}


	public function add_new_employee()
	{
		if ($this->endpoint === '/employees') 
		{
			$data = json_decode(file_get_contents('php://input'), true);	
			$this->validator->check_create_fields($data);
			$result = $this->dbObj->addEmployee($data);
			return($result);          
		}
		else
		{
			throw new RestException("Wrong endpoint format",400,"Bad request");
		}
	}
	
	public function update_employee_details()
	{
		if (preg_match('/^\/employees\/(\d+)$/', $this->endpoint, $matches))
		{
			$employeeId = $matches[1];
			$this->dbObj->getEmployeeById($employeeId); // just check that the employee exists before moving on 	   
			$data = json_decode(file_get_contents('php://input'), true);
			$this->validator->check_update_fields($data);
			$result = $this->dbObj->updateEmployee($employeeId, $data);
			return($result);
		}
		else
		{
			throw new RestException("Wrong endpoint format",400,"Bad request");
		}
	}
	
	public function remove_employee()
	{
		if (preg_match('/^\/employees\/(\d+)$/', $this->endpoint, $matches)) 
		{
			$employeeId = $matches[1];
			$this->dbObj->getEmployeeById($employeeId); // just check that the employee exists before moving on 	   			
			$result = $this->dbObj->deleteEmployee($employeeId);
			return($result);
		}
		else
		{
			throw new RestException("Wrong endpoint format",400,"Bad request");
		}
	}
	
}




