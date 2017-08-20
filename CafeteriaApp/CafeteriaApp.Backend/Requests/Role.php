<?php

require_once( 'CafeteriaApp.Backend/Controllers/Role.php');
require_once("CafeteriaApp.Backend/connection.php");
require_once ('CheckResult.php');

if ($_SERVER['REQUEST_METHOD']=="GET")
{
  //if (isset($_GET["action"]) && $_GET["action"]=="getRoles")
  //{
  if (isset($_GET["id"]) && $_GET["id"] != null)
  {
    checkResult(getRoleById($conn,$_GET["id"]));
  }
  else
  {
    checkResult(getRoles($conn));
  }
  //}
  // else
  // {
  //   echo "Error occured while returning Roles";
  // }
}

if ($_SERVER['REQUEST_METHOD']=="POST")
{
  //decode the json data
  $data = json_decode(file_get_contents("php://input"));
  if (isset($data->action) && $data->action == "addRole")
  {
    if ($data->Name != null)
    {
      addRole($conn,$data->Name);
    }
    else
    {
      echo "name is required";
    }
  }
}

if ($_SERVER['REQUEST_METHOD']=="PUT")
{
  //decode the json data
  $data = json_decode(file_get_contents("php://input"));
  if ($data->Name != null && $data->Id != null)
  {
    editRole($conn,$data->Name,$data->Id);
  }
  else
  {
    echo "name is required";
  }
}

require_once("CafeteriaApp.Backend/footer.php");

?>