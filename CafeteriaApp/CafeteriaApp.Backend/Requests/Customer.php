<?php

require_once( 'CafeteriaApp.Backend/Controllers/Customer.php');
require_once('CafeteriaApp.Backend/Controllers/User.php');
require_once("CafeteriaApp.Backend/connection.php");
require_once ('CheckResult.php');

if ($_SERVER['REQUEST_METHOD'] == "GET")
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

if ($_SERVER['REQUEST_METHOD'] == "POST")
{
  //decode the json data
  $data = json_decode(file_get_contents("php://input"));
  $user_id = addUser($conn,$data->UserName,$data->FirstName,$data->LastName,"image",$data->Email,$data->PhoneNumber,$data->Password,3);
  // echo $user_id;
  addCustomer($conn,0.0,$data->DateOfBirth,$user_id,$data->GenderId);
  // if (isset($data->action) && $data->action == "addCustomer")
  // {
  //   if ($data->Name != null)
  //   {
  //     addCustomer($conn,$data->Name);
  //   }
  //   else
  //   {
  //     echo "name is required";
  //   }
  // }
}

// if ($_SERVER['REQUEST_METHOD'] == "PUT")
// {
//   //decode the json data
//   $data = json_decode(file_get_contents("php://input"));
//   if ($data->Name != null && $data->Id != null)
//   {
//     editCustomer($conn,$data->Name,$data->Id);
//   }
//   else
//   {
//     echo "name is required";
//   }
// }

if ($_SERVER['REQUEST_METHOD']=="DELETE")
{
  //decode the json data
  if (isset($_GET["customerId"]) && $_GET["customerId"] != null)
  {
    deleteCustomer($conn,$_GET["customerId"]);
  }
  // else
  // {
  //   echo "name is required";
  // }
}

require_once("CafeteriaApp.Backend/footer.php");

?>