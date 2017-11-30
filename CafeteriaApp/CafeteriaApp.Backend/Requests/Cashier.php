<?php

require('CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/connection.php');
require('CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Controllers/Cashier.php');
require('TestRequestInput.php');

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	$data = json_decode(file_get_contents("php://input"));
	if (isset($data->UserId) && test_int($data->UserId))
	{
		addCashier($conn,$data->UserId);
	}
}

if ($_SERVER["REQUEST_METHOD"] == "DELETE")
{
	if (isset($_GET["userId"]) && test_int($_GET["userId"]))
	{
		deleteCashierByUserId($conn,$_GET["userId"]);
	}
}

require('CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/footer.php');

?>