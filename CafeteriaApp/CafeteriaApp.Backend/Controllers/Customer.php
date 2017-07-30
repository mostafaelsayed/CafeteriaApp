<?php
include 'CafeteriaApp.Backend\connection.php';


function getCustomers($conn) {
  
  $sql = "select * from Customer";
  if ($conn->query($sql)) {
      $result = $conn->query($sql);
      $customers = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $customers = json_encode($customers);
      $conn->close();
      return $customers;
  } else {
      echo "Error retrieving customers: " . $conn->error;
  }
}

function getCustomerByUserId($conn,$userId) {
  if( !isset($userId)) 
 {
 echo "Error: User Id is not set";
  return;
  }
  else
  {
  $sql = "select * from Customer where UserId =".$userId;
  if ($conn->query($sql)) {
      $result = $conn->query($sql);
      $customer = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $customer = json_encode($customer);
      $conn->close();
      return $customer;
  } else {
      echo "Error retrieving customers: " . $conn->error;
  }
}}


function addCustomer($conn,$cred,$userId) {
   if( !isset($cred)) 
 {
 echo "Error: Credit is not set";
  return;
  }
elseif (!isset($userId)) {
 echo "Error: User Id is not set";
  return;
  }
  else {
  $sql = "insert into Customer (Credit,UserId) values (?,?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("fi",$Credit,$UserId);
  $Credit = $cred;
  $UserId=$userId;
  //$conn->query($sql);
  if ($stmt->execute()===TRUE) {
    return true;
  }
  else {
    return false;
  }
}}


function editCustomerCredit($conn,$cred,$userId) {
  if( !isset($cred)) 
 {
 echo "Error: Credit is not set";
  return;
  }
elseif (!isset($userId)) {
 echo "Error: User Id is not set";
  return;
  }
  else {
  $sql = "update Customer set Credit = (?) where UserId = (?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("fi",$Credit,$UserId);
  $Credit = $cred;
  $UserId = $userId;
  //$conn->query($sql);
  if ($stmt->execute()===TRUE) {
    echo "Customer Credit updated successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}}


// deleting a customer is on cascading

if ($_SERVER['REQUEST_METHOD']=="GET") {
  if (isset($_GET["action"]) && $_GET["action"]=="getCustomers"){
    getCustomer($conn);
  }
  else {
    echo "Error occured while returning Customer";
  }
}

if ($_SERVER['REQUEST_METHOD']=="POST"){
    //decode the json data
    $data = json_decode(file_get_contents("php://input"));
    if (isset($data->action) && $data->action == "addCustomer"){
      if ($data->Name != null){
        addCustomer($conn,$data->Name);
      }
      else{
        echo "name is required";
      }
  }
}

if ($_SERVER['REQUEST_METHOD']=="PUT"){
    //decode the json data
    $data = json_decode(file_get_contents("php://input"));
    //echo $data;
      if ($data->Name != null && $data->Id != null) {
        //if ($data->action == "addcafeteria"){
        editCustomer($conn,$data->Name,$data->Id);
      }
      else{
        echo "name is required";
      }
  //}
}

 ?>
