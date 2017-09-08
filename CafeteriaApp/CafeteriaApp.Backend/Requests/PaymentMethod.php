<?php

require_once( 'CafeteriaApp.Backend/Controllers/PaymentMethod.php');
require_once("CafeteriaApp.Backend/connection.php");
require('TestRequestInput.php');

if ($_SERVER['REQUEST_METHOD']=="GET")
{
 // if (isset($_GET["action"]) && $_GET["action"]=="getPaymentMethods"){
  checkResult(getPaymentMethods($conn));
 // }
  //else {
   // echo "Error occured while returning PaymentMethods";
  //}
}

if ($_SERVER['REQUEST_METHOD']=="POST")
{
  //decode the json data
  $data = json_decode(file_get_contents("php://input"));
  if (isset($data->action) && $data->action == "addPaymentMethod")
  {
    if ($data->Name != null)
    {
      addPaymentMethod($conn,$data->Name);
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
    editPaymentMethod($conn,$data->Name,$data->Id);
  }
  else
  {
    echo "name is required";
  }
}

require_once("CafeteriaApp.Backend/footer.php");

?>