<?php

function getPaymentMethods($conn,$backend=false) {
  
  $sql = "select * from PaymentMethod";
  $result = $conn->query($sql);
  if ($result) {
      $paymentMethods = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $paymentMethods = json_encode($paymentMethods);
      $conn->close();
      if($backend)
      { 
        return $paymentMethods;   
      }
      else
      {
       echo $paymentMethods;
      }
     
  } else {
      echo "Error retrieving PaymentMethods : " . $conn->error;
  }

}

function getPaymentMethodById($conn,$id,$backend=false) {
    if( !isset($id)) 
 {
 echo "Error: PaymentMethod Id is not set";
  return;
  }
  else{
  $sql = "select * from PaymentMethod where Id=".$id." LIMIT 1";
  $result = $conn->query($sql);
  if ($result) {
      $paymentMethods = mysqli_fetch_assoc($result);
      $paymentMethods = json_encode($paymentMethods);
      $conn->close();
      if($backend)
      { 
        return $paymentMethods;   
      }
      else
      {
       echo $paymentMethods;
      }
     
  } else {
      echo "Error retrieving PaymentMethod : " . $conn->error;
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
  $sql = "delete from PaymentMethod where Id = ".$id . " LIMIT 1";
  if ($conn->query($sql)===TRUE) {
    echo "PaymentMethod deleted successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}
}



 ?>
