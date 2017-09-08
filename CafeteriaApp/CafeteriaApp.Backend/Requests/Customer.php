<?php

require('CafeteriaApp.Backend/Controllers/Customer.php');
require('CafeteriaApp.Backend/connection.php');
require('CheckResult.php');
require('TestRequestInput.php');

if ($_SERVER['REQUEST_METHOD'] == "GET")
{
  if (isset($_GET["userId"]) && test_int($_GET["userId"]))
  {
    checkResult(getCustomerByUserId($conn,$_GET["userId"]));
  }
  elseif (isset($_SESSION["userId"]) && test_int($_SESSION["userId"]))
  {
    checkResult(getCurrentCustomerinfoByUserId($conn));
  }
}

if ($_SERVER['REQUEST_METHOD'] == "POST")
{
  if ($_SESSION["roleId"] == 1)
  {
    //decode the json data
    $data = json_decode(file_get_contents("php://input"));
    if (isset($data->Credit,$data->DateOfBirth,$data->UserId,$data->GenderId) && test_int($data->GenderId,$data->UserId) && test_price($data->Credit) && test_date_of_birth($data->DateOfBirth))
    {
      addCustomer($conn,$data->Credit,$data->DateOfBirth,$data->UserId,$data->GenderId);
    }
  }
}

if ($_SERVER['REQUEST_METHOD'] == "PUT")
{
  //decode the json data
  $data = json_decode(file_get_contents("php://input"));
  if (isset($data->UserId) && test_int($data->UserId,$data->GenderId) && test_price($data->Credit) && test_date_of_birth($data->DateOfBirth) && ($_SESSION["roleId"] == 1 || $data->UserId == $_SESSION["userId"]))
  {
    echo editCustomer($conn,$data->Credit,$data->GenderId,$data->DateOfBirth,$data->UserId);
  }
  else
  {
    echo "error";
  }
}

if ($_SERVER['REQUEST_METHOD'] == "DELETE")
{
  if ($_SESSION["roleId"] == 1)
  {
    if (isset($_GET["userId"]) && test_int($_GET["userId"]))
    {
      deleteCustomerByUserId($conn,$_GET["userId"]);
    }
    else if (isset($_GET["customerId"]) && test_int($_GET["customerId"]))
    {
      deleteCustomer($conn,$_GET["customerId"]);
    }
  }
}

require('CafeteriaApp.Backend/footer.php');

?>