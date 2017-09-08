<?php

require('CafeteriaApp.Backend/Controllers/MenuItem.php');
require('CafeteriaApp.Backend/connection.php');
require('CafeteriaApp.Backend/session.php');
require('CheckResult.php');
require('TestRequestInput.php');

if ($_SERVER['REQUEST_METHOD'] == "GET")
{
  if (isset($_GET["categoryId"]) && test_int($_GET["categoryId"]))
  {
    checkResult(getMenuItemByCategoryId($conn,$_GET["categoryId"],false,true));
  }
  elseif (isset($_GET["id"]) && test_int($_GET["id"]) && $_SESSION["roleId"] == 1)
  {
    checkResult(getMenuItemById($conn,$_GET["id"]));
  }
  else
  {
    echo "Error while returning MenuItem";
  }
}

// i don't know how to handle
if ($_SERVER['REQUEST_METHOD'] == "POST")
{
  if ($_SESSION["roleId"] == 1)
  {
    //decode the json data
    $data = json_decode(file_get_contents("php://input"));// ????????????
    if (isset($data->CategoryId,$data->Price,$data->Name,$data->Description,$data->Image) && test_int($data->CategoryId) && normalize_string($conn,$data->Name,$data->Description,$data->Image) && test_price($data->Price))
    {
      addMenuItem($conn,$data->Name,$data->Price,$data->Description,$data->CategoryId,$data->Image);
    }
    else
    {
      echo "error while adding menuitem";
    }
  }
}

if ($_SERVER['REQUEST_METHOD'] == "PUT")
{
  if ($_SESSION["roleId"] == 1)
  {
    //decode the json data
    $data = json_decode(file_get_contents("php://input"));
    if (isset($data->Id,$data->Price,$data->Visible,$data->Name,$data->Description,$data->Image) && test_int($data->Id,$data->Visible) && normalize_string($conn,$data->Name,$data->Description,$data->Image) && test_price($data->Price))
    {
      editMenuItem($conn,$data->Name,$data->Price,$data->Description,$data->Id,$data->Image,$data->Visible);
    }
    else
    {
      echo "error while editiing menuitem";
    }
  }
}

if ($_SERVER['REQUEST_METHOD'] == "DELETE")
{
  if ($_SESSION["roleId"] == 1)
  {
    if (isset($_GET["menuItemId"]) && test_int($_GET["menuItemId"]))
    {
      deleteMenuItem($conn,$_GET["menuItemId"]);
    }
    else
    {
      echo "Id error";
    }
  }
}

require('CafeteriaApp.Backend/footer.php');

?>