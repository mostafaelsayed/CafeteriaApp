<?php

require_once('CafeteriaApp.Backend/connection.php');
require_once('CafeteriaApp.Backend/Controllers/Cashier.php');
//require_once('CafeteriaApp.Backend/Controllers/User.php');
require_once ('CheckResult.php');

if ($_SERVER['REQUEST_METHOD'] == "POST")
{
	$data = json_decode(file_get_contents("php://input"));
	addCashier($conn,$data->UserId);
}

if ($_SERVER["REQUEST_METHOD"] == "DELETE")
{
	if (isset($_GET["userId"]) && $_GET["userId"] != null)
	{
		deleteCashierByUserId($conn,$_GET["userId"]);
	}
	else if (isset($_GET["cashierId"]) && $_GET["cashierId"] != null)
	{
		deleteCashier($conn,$_GET["cashierId"]);
	}
}

?>