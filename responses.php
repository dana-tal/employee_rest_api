
<?php 

function valid_response($response)
{
	$res_obj  = new stdClass();
	$res_obj->msg = 'O.K';
	$res_obj->code = 200;
	$res_obj->data = $response;
	header('Content-Type: application/json');
	echo json_encode($res_obj,JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
}

function invalid_response($e)
{
	$res_obj  = new stdClass();
	$res_obj->msg = 'ERROR';
	$res_obj->explanation = $e->getMessage();
	$res_obj->code = $e->getCode();
	$res_obj->status = $e->getStatus();
	header('Content-Type: application/json');
	echo json_encode($res_obj,JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
}