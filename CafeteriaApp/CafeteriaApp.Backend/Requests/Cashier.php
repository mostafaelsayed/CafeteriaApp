<?php

require_once('CafeteriaApp.Backend/connection.php');
require_once('CafeteriaApp.Backend/Controllers/Cashier.php');
require_once('CafeteriaApp.Backend/Controllers/User.php');
require_once ('CheckResult.php');

if ($_SERVER['REQUEST_METHOD'] == "POST")
{
	$data = json_decode(file_get_contents("php://input"));
	$user_id = addUser($conn,$data->UserName,$data->FirstName,$data->LastName,"image",$data->Email,$data->PhoneNumber,$data->Password,2);
	//addCashier();
}

?>