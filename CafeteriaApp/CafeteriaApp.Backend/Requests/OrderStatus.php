<?php
require_once( 'CafeteriaApp.Backend/Controllers/OrderStatus.php');
require_once("CafeteriaApp.Backend/connection.php");
require_once ('TestRequestInput.php');


if ($_SERVER['REQUEST_METHOD']=="GET")
{
    checkResult(getOrderStatus($conn));
}

if ($_SERVER['REQUEST_METHOD']=="POST")
{
  $data = json_decode(file_get_contents("php://input"));
  if (isset($data->Name) && normalize_string($conn,$data->Name))
  {
      addOrderStatus($conn,$data->Name);
  }
}

if ($_SERVER['REQUEST_METHOD']=="PUT")
{
  //decode the json data
  $data = json_decode(file_get_contents("php://input"));
  if (isset($data->Name) && normalize_string($conn,$data->Name) &&isset($data->Id)&& test_int($data->Id) )
  {
    editOrderStatus($conn,$data->Name,$data->Id);
  }
  else
  {
    echo "name is required";
  }
}

require_once("CafeteriaApp.Backend/footer.php");

?>