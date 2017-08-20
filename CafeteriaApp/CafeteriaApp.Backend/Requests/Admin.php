<?php

require_once('CafeteriaApp.Backend/connection.php');
require_once('CafeteriaApp.Backend/Controllers/Admin.php');
require_once('CafeteriaApp.Backend/Controllers/User.php');
require_once ('CheckResult.php');

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	$data = json_decode(file_get_contents("php://input"));
	addAdmin($conn,$data->UserId);
}

if ($_SERVER["REQUEST_METHOD"] == "DELETE")
{
	if (isset($_GET["userId"]) && $_GET["userId"] != null)
	{
		deleteAdminByUserId($conn,$_GET["userId"]);
	}
	else if (isset($_GET["adminId"]) && $_GET["adminId"] != null)
	{
		deleteAdmin($conn,$_GET["adminId"]);
	}
}

?>