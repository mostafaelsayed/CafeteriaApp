<?php

require('CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Controllers/User.php');
require('TestRequestInput.php');

if ($_SERVER['REQUEST_METHOD'] == "GET")
{
  if ($_SESSION["roleId"] == 1) // admin only can call these methods
  {
    if (isset($_GET["userId"]) && test_int($_GET["userId"]))
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
    $result = (normalize_string($conn,$data->UserName,$data->FirstName,$data->LastName,$data->Password) && test_phone($data->PhoneNumber) && test_email($data->Email));
    if ($result && isset($data->RoleId) && test_int($data->RoleId))
    {
      normalize_string($conn,$data->Image);
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
    $result = (normalize_string($conn,$data->UserName,$data->FirstName,$data->LastName) && test_phone($data->PhoneNumber) && test_email($data->Email));
    if ($result && isset($data->RoleId,$data->Id) && test_int($data->RoleId,$data->Id))
    {
      echo 1;
      normalize_string($conn,$data->Image);
      editUser($conn,$data->UserName,$data->FirstName,$data->LastName,$data->Email,$data->Image,$data->PhoneNumber,$data->RoleId,$data->Id);
    }
  }
}

if ($_SERVER['REQUEST_METHOD'] == "DELETE")
{
  if ($_SESSION["roleId"] == 1)
  {
    //decode the json data
    if (isset($_GET["userId"]) && test_int($_GET["userId"]))
    {
      deleteUser($conn,$_GET["userId"]);
    }
  }
}

require('CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/footer.php');

?>