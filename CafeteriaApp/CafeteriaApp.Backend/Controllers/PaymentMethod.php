<?php
include 'CafeteriaApp.Backend\connection.php';

function getPaymentMethods($conn) {
  
  $sql = "select * from PaymentMethod";
  if ($conn->query($sql)) {
      $result = $conn->query($sql);
      $paymentMethods = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $paymentMethods = json_encode($paymentMethods);
      $conn->close();
      echo $paymentMethods;
  } else {
      echo "Error retrieving PaymentMethods : " . $conn->error;
  }

}

function addPaymentMethod($conn,$n) {
  $sql = "insert into PaymentMethod (Name) values (?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s",$name);
  $name = $n;
  //$conn->query($sql);
  if ($stmt->execute()===TRUE) {
    echo "PaymentMethod Added successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}

function editPaymentMethod($conn,$n,$Id) {
  $sql = "update PaymentMethod set Name = (?) where Id = (?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("si",$name,$id);
  $name = $n;
  $id = $Id;
  //$conn->query($sql);
  if ($stmt->execute()===TRUE) {
    echo "PaymentMethod updated successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}

if ($_SERVER['REQUEST_METHOD']=="GET") {
  if (isset($_GET["action"]) && $_GET["action"]=="getPaymentMethods"){
    getPaymentMethods($conn);
  }
  else {
    echo "Error occured while returning PaymentMethods";
  }
}

if ($_SERVER['REQUEST_METHOD']=="POST"){
    //decode the json data
    $data = json_decode(file_get_contents("php://input"));
    if (isset($data->action) && $data->action == "addPaymentMethod"){
      if ($data->Name != null){
        addPaymentMethod($conn,$data->Name);
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
        editPaymentMethod($conn,$data->Name,$data->Id);
      }
      else{
        echo "name is required";
      }
  //}
}

 ?>
