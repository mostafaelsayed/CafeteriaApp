<?php
include 'CafeteriaApp.Backend\connection.php';


function getCustomers($conn,$backend=false){
  
  $sql = "select * from Customer";
  $result = $conn->query($sql);
  if ($result) {
      $result = $conn->query($sql);
      $customers = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $customers = json_encode($customers);
      $conn->close();
      if($backend)
      { 
        return $customers;   
      }
      else
      {
       echo $customers;
      }
    
  } else {
      echo "Error retrieving customers: " . $conn->error;
  }
}


function getCustomerById($conn ,$id,$backend=false) {
   if( !isset($id)) 
 {
 echo "Error: Customer Id is not set";
  return;
  }
  else
  {
  $sql = "select * from Customer where Id =".$id." LIMIT 1";
  $result = $conn->query($sql);
  if ($result) {
      $customers = mysqli_fetch_assoc($result);
      $customers = json_encode($customers);
      $conn->close();
      if($backend)
      { 
        return $customers;   
      }
      else
      {
       echo $customers;
      }
  } else {
      echo "Error retrieving Customer: " . $conn->error;
  }
}
}


function getCustomerByUserId($conn,$userId,$backend=false) {
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
      $customer = mysqli_fetch_assoc($result);
      $customer = json_encode($customer);
      $conn->close();
      if($backend)
      { 
        return $customer;   
      }
      else
      {
       echo $customer;
      }
     
  } else {
      echo "Error retrieving customer: " . $conn->error;
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
