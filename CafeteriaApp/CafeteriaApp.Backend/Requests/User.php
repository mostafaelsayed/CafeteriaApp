<?php

require_once( 'CafeteriaApp.Backend/Controllers/User.php');
require_once('CafeteriaApp.Backend/Controllers/Customer.php');
require_once('CafeteriaApp.Backend/Controllers//Admin.php');
require_once('CafeteriaApp.Backend/Controllers/Cashier.php');
require_once("CafeteriaApp.Backend/connection.php");
require_once ('CheckResult.php');

if ($_SERVER['REQUEST_METHOD']=="GET")
{
  //if (isset($_GET["action"]) && $_GET["action"]=="getUsers")
  //{
  if (isset($_GET["userId"]) && $_GET["userId"] != null)
  {
    checkResult(getUserById($conn,$_GET["userId"]));
  }
  else
  {
    checkResult(getUsers($conn));
  }
  //}
  // else
  // {
  //   echo "Error occured while returning Users";
  // }
}

if ($_SERVER['REQUEST_METHOD']=="POST")
{
  //decode the json data
  $data = json_decode(file_get_contents("php://input"));
  
  
    if ($data->UserName != null)
    {
      echo (addUser($conn,$data->UserName,$data->FirstName,$data->LastName,$data->Image,$data->Email,$data->PhoneNumber,$data->Password,$data->RoleId));
    }
    else
    {
      echo "name is required";
    }
  
}

if ($_SERVER['REQUEST_METHOD']=="PUT")
{
  //decode the json data
  $data = json_decode(file_get_contents("php://input"));
  if ($data->UserName != null && $data->Id != null)
  {
    editUser($conn,$data->UserName,$data->FirstName,$data->LastName,$data->Email,$data->Image,$data->PhoneNumber,$data->RoleId,$data->Id);
    // if ($data->RoleId == 2) // customer role
    // {
    //   editCustomer($conn,$data->Credit,$data->GenderId,$data->DateOfBirth,$data->Id);
    // }
    // elseif ($data->RoleId == 3) // cashier role
    // {
      
    // }
    // elseif ($data->RoleId == 1) // admin role
    // {

    // }
  }
  else
  {
    echo "name is required";
  }
}

if ($_SERVER['REQUEST_METHOD']=="DELETE")
{
  //decode the json data
  if (isset($_GET["userId"]) && $_GET["userId"] != null)
  {
    deleteUser($conn,$_GET["userId"]);
  }
  // else
  // {
  //   echo "name is required";
  // }
}

require_once("CafeteriaApp.Backend/footer.php");

?>