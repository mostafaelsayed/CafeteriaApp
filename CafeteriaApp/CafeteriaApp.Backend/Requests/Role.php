<?php

require('CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Controllers/Role.php');
require('CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/connection.php');
require('CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/session.php');
require('TestRequestInput.php');

if ($_SERVER['REQUEST_METHOD'] == "GET")
{
  if ($_SESSION["roleId"] == 1)
  {
    if (isset($_GET["id"]) && test_int($_GET["id"]))
    {
      checkResult(getRoleById($conn,$_GET["id"]));
    }
    else
    {
      checkResult(getRoles($conn));
    }
  }
}

if ($_SERVER['REQUEST_METHOD'] == "POST")
{
  if ($_SESSION["roleId"] == 1)
  {
    //decode the json data
    $data = json_decode(file_get_contents("php://input"));
    if (normalize_string($conn,$data->Name))
    {
      addRole($conn,$data->Name);
    }
  }
}

if ($_SERVER['REQUEST_METHOD'] == "PUT")
{
  if ($_SESSION["roleId"] == 1)
  {
    //decode the json data
    $data = json_decode(file_get_contents("php://input"));
    if (isset($data->Id) && test_int($data->Id) && normalize_string($conn,$data->Name))
    {
      editRole($conn,$data->Name,$data->Id);
    }
    else
    {
      echo "name is required";
    }
  }
}

if ($_SERVER['REQUEST_METHOD'] == "DELETE")
{
  if ($_SESSION["roleId"] == 1)
  {
    //decode the json data
    //$data = json_decode(file_get_contents("php://input"));
    if (isset($_GET["id"]) && test_int($_GET["id"]))
    {
      deleteRole($conn,$_GET["id"]);
    }
    else
    {
      echo "name is required";
    }
  }
}

require('CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/footer.php');

?>