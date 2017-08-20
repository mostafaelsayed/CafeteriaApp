<?php

require_once( 'CafeteriaApp.Backend/Controllers/Customer.php');
//require_once('CafeteriaApp.Backend/Controllers/User.php');
require_once("CafeteriaApp.Backend/connection.php");
require_once ('CheckResult.php');

if ($_SERVER['REQUEST_METHOD'] == "GET")
{
  if (isset($_GET["userId"]) && $_GET["userId"] != null)
  {
    checkResult(getCustomerByUserId($conn,$_GET["userId"]));
  }
  else
  {

  }
}

if ($_SERVER['REQUEST_METHOD'] == "POST")
{
  //decode the json data
  $data = json_decode(file_get_contents("php://input"));
  addCustomer($conn,$data->Credit,$data->DateOfBirth,$data->UserId,$data->GenderId);
}

if ($_SERVER['REQUEST_METHOD'] == "PUT")
{
  //decode the json data
  //echo "1";
  $data = json_decode(file_get_contents("php://input"));
  //if ($data->Credit != null && $data->UserId != null)
  //{
    echo editCustomer($conn,$data->Credit,$data->GenderId,$data->DateOfBirth,$data->UserId);
  //}
  //else
  //{
    //echo "name is required";
  //}
}

if ($_SERVER['REQUEST_METHOD']=="DELETE")
{
  if (isset($_GET["userId"]) && $_GET["userId"] != null)
  {
    deleteCustomerByUserId($conn,$_GET["userId"]);
  }
  else if (isset($_GET["customerId"]) && $_GET["customerId"] != null)
  {
    deleteCustomer($conn,$_GET["customerId"]);
  }
}

require_once("CafeteriaApp.Backend/footer.php");

?>