<?php
include 'CafeteriaApp.Backend\connection.php';

function getPaymentMethods($conn) {
  
  $sql = "select * from PaymentMethod";
  if ($conn->query($sql)) {
      $result = $conn->query($sql);
      $paymentMethods = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $paymentMethods = json_encode($paymentMethods);
      $conn->close();
      return $paymentMethods;
  } else {
      echo "Error retrieving PaymentMethods : " . $conn->error;
  }

}

function getPaymentMethodById($conn,$id) {
    if( !isset($id)) 
 {
 echo "Error: PaymentMethod Id is not set";
  return;
  }
  else{
  $sql = "select * from PaymentMethod where Id=".$id;
  if ($conn->query($sql)) {
      $result = $conn->query($sql);
      $paymentMethods = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $paymentMethods = json_encode($paymentMethods);
      $conn->close();
      return $paymentMethods;
  } else {
      echo "Error retrieving PaymentMethods : " . $conn->error;
  }
}
}

function addPaymentMethod($conn,$name) {
 if( !isset($name)) 
 {
 echo "Error: PaymentMethod name is not set";
  return;
  }
  else{
  $sql = "insert into PaymentMethod (Name) values (?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s",$Name);
  $Name = $name;
  //$conn->query($sql);
  if ($stmt->execute()===TRUE) {
    echo "PaymentMethod Added successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}}

function editPaymentMethod($conn,$name,$id) {
if( !isset($name)) 
 {
 echo "Error: PaymentMethod name is not set";
  return;
  }
  elseif(!isset($id))
  {
    echo "Error: PaymentMethod id is not set";
  return;
  }
  else{
  $sql = "update PaymentMethod set Name = (?) where Id = (?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("si",$Name,$Id);
  $Name = $name;
  $Id = $id;
  //$conn->query($sql);
  if ($stmt->execute()===TRUE) {
    echo "PaymentMethod updated successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}}

function deletePaymentMethod($conn,$id) {
 if (!isset($id))
  {
     echo "Error: Id is not set";
  return;
  }
  else{
  //$conn->query("set foreign_key_checks = 0"); // ????????/
  $sql = "delete from PaymentMethod where Id = ".$id . "LIMIT 1";
  if ($conn->query($sql)===TRUE) {
    echo "PaymentMethod deleted successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}
}



 ?>
