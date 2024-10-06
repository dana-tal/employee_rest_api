<?php
	require_once 'dbconfig.php';
	require_once 'db_access.php';
	require_once 'rest.php';
	require_once 'responses.php';
	require_once 'validator.php';
	require_once 'rest_exception.php';

	$method = $_SERVER['REQUEST_METHOD'];  // read the request method
	$endpoint = $_SERVER['PATH_INFO'];   //read  the requested endpoint
	 
	
	try
	{
			$restObj = new Rest($endpoint); // create a Rest instance to handle different requests
			switch ($method) 
			{
				case 'GET':
							$response = $restObj->get_all_employees();
							break;
							
				case 'POST':
							$response = $restObj->add_new_employee();
							break;
					
				case 'PUT':
							$response = $restObj->update_employee_details();
							break;
							
				case 'DELETE':
						   $response = $restObj->remove_employee();					  				
						   break;
			    default:
				         throw new RestException("This api supports only GET,POST,PUT,DELETE methods",400,"Bad request");
			}
			 valid_response($response);
	}
	catch (PDOException $e) 
	{
		$rest_exception = new RestException($e->getMessage(),500,"Internal server error");
		invalid_response($rest_exception);
	}
	catch(Exception $e)
	{
		invalid_response($e);
	}
?>