<?php
class DbAccess
{
	private $pdo;
	
    public function __construct()
    {
		global $hostname,$database,$username,$password;
		
		$this->pdo = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);		
    }
	
    public function getAllEmployees()
    {
		$stmt = $this->pdo->prepare("SELECT * FROM employee");
		$stmt->execute();
		$employees = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return ($employees);		      
    }
	
    public function getEmployeeById($id)
    {
		$stmt = $this->pdo->prepare("SELECT * FROM employee WHERE id=:id");
		$stmt->execute(['id' => $id]); 
		$employee = $stmt->fetch(PDO::FETCH_ASSOC);
		if (empty($employee))
		{
			throw new RestException("Employee with id=$id does not exist",404,"Not found");
		}
		return($employee);		
    }
	
    public function addEmployee($data)
    {
		$query  =  "INSERT INTO employee (emp_name, emp_code, emp_email, emp_phone, emp_address, emp_designation, emp_joining_date) ";
		$query .=  "VALUES (:emp_name, :emp_code,:emp_email,:emp_phone,:emp_address,:emp_designation,:emp_joining_date)";
		$stmt = $this->pdo->prepare($query);
		$result = $stmt->execute($data);	
		return($result);
    }
	
    public function updateEmployee($id, $data)
    {
		$fields = array('id'=>$id);
		$query = "UPDATE employee SET ";
		$clauses = array();
		foreach($data as $key=>$val)
		{
			$phrase = $key." = :".$key;
			$clauses[] = $phrase;
			$fields[$key] = $val;
		}
		$clauses_str = implode(",",$clauses);
		$query .= $clauses_str;
		$query .=" WHERE id= :id ";
		$fields_str = var_export($fields,true);
		error_log($fields_str);
		error_log($query);
		
	    $stmt = $this->pdo->prepare($query);
		$result = $stmt->execute($fields);		
	    return($result);
    }
	
    public function deleteEmployee($id)
    {
		$query = "DELETE FROM employee WHERE id = :id";
		$stmt = $this->pdo->prepare($query);
		$result = $stmt->execute(['id' => $id]);
		return($result);      
    }
}
?>