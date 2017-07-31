<?php
include 'CafeteriaApp.Backend\connection.php';


function getCustomers($conn) {
  
  $sql = "select * from Customer";
  $result = $conn->query($sql);
  if ($result) {
      $result = $conn->query($sql);
      $customers = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $customers = json_encode($customers);
      $conn->close();
      return $customers;
  } else {
      echo "Error retrieving customers: " . $conn->error;
  }
}

function getCustomerById($conn ,$id) {
   if( !isset($id)) 
 {
 echo "Error: Customer Id is not set";
  return;
  }
  else
  {
  $sql = "select * from Customer where Id =".$id;
  $result = $conn->query($sql);
  if ($result) {
      $customers = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $customers = json_encode($customers);
      $conn->close();
      return $customers;
  } else {
      echo "Error retrieving customers: " . $conn->error;
  }
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
  $sql = "select Id from Customer where UserId =".$userId." LIMIT 1";
  $result = $conn->query($sql);
  if ($result) {
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
  $stmt->bind_param("di",$Credit,$UserId);
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



 ?>
