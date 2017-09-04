<?php

require_once('CafeteriaApp.Backend/Controllers/User.php');
require_once('CafeteriaApp.Backend/session.php');
require_once('CafeteriaApp.Backend/Controllers/Customer.php');
require_once('CafeteriaApp.Backend/Controllers//Admin.php');
require_once('CafeteriaApp.Backend/Controllers/Cashier.php');
require_once('CafeteriaApp.Backend/connection.php');
require_once('CheckResult.php');
require_once('TestRequestInput.php');

if ($_SERVER['REQUEST_METHOD'] == "GET")
{
  if ($_SESSION["roleId"] == 1) // admin only can call these methods
  {
    if (isset($_GET["userId"]) && $_GET["userId"] != null)
    {
      checkResult(getUserById($conn,$_GET["userId"]));
    }
    else 
    {
      checkResult(getUsers($conn));
    }
  }
}

if ($_SERVER['REQUEST_METHOD'] == "POST")
{
  if ($_SESSION["roleId"] == 1)
  {
    //decode the json data
    $data = json_decode(file_get_contents("php://input"));
    $result = test_user_input($conn,$data);
    if ($result)
    {
      echo addUser($conn,$data->UserName,$data->FirstName,$data->LastName,$data->Image,$data->Email,$data->PhoneNumber,$data->Password,$data->RoleId,1);
    }
  }
}

if ($_SERVER['REQUEST_METHOD'] == "PUT")
{
  if ($_SESSION["roleId"] == 1)
  {
    //decode the json data
    $data = json_decode(file_get_contents("php://input"));
    $result = test_user_input($conn,$data);
    if ($result)
    {
      editUser($conn,$data->UserName,$data->FirstName,$data->LastName,$data->Email,$data->Image,$data->PhoneNumber,$data->RoleId,$data->Id);
    }
  }
}

if ($_SERVER['REQUEST_METHOD'] == "DELETE")
{
  if ($_SESSION["roleId"] == 1)
  {
    //decode the json data
    if (isset($_GET["userId"]) && $_GET["userId"] != null)
    {
      deleteUser($conn,$_GET["userId"]);
    }
  }
}

require_once("CafeteriaApp.Backend/footer.php");

?>