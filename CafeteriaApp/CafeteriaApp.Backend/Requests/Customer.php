<?php

require_once( 'CafeteriaApp.Backend/Controllers/Customer.php');
require_once("CafeteriaApp.Backend/connection.php");
require_once ('checkResult.php');

if ($_SERVER['REQUEST_METHOD']=="GET")
{
  // if (isset($_GET["action"]) && $_GET["action"]=="getCustomers"){
  //   getCurrentCustomerByUserId($conn);
  // }
  ////else {
    //echo '1';
    // echo "Error occured while returning Customer";
    checkResult(getCurrentCustomerinfoByUserId($conn));
  //}
}

if ($_SERVER['REQUEST_METHOD']=="POST")
{
  //decode the json data
  $data = json_decode(file_get_contents("php://input"));
  if (isset($data->action) && $data->action == "addCustomer")
  {
    if ($data->Name != null)
    {
      addCustomer($conn,$data->Name);
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
    editCustomer($conn,$data->Name,$data->Id);
  }
  else
  {
    echo "name is required";
  }
}

require_once("CafeteriaApp.Backend/footer.php");

?>