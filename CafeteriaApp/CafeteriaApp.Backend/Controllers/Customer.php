<?php
include 'CafeteriaApp.Backend\connection.php';

function getCustomers($conn) {
  
  $sql = "select * from Customer";
  if ($conn->query($sql)) {
      $result = $conn->query($sql);
      $customers = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $customers = json_encode($customers);
      $conn->close();
      echo $customers;
  } else {
      echo "Error retrieving customers: " . $conn->error;
  }

}

function addCustomer($conn,$n) {
  $sql = "insert into Customer (Name) values (?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s",$name);
  $name = $n;
  //$conn->query($sql);
  if ($stmt->execute()===TRUE) {
    echo "Customer Added successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}

function editCustomer($conn,$n,$Id) {
  $sql = "update Customer set Name = (?) where Id = (?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("si",$name,$id);
  $name = $n;
  $id = $Id;
  //$conn->query($sql);
  if ($stmt->execute()===TRUE) {
    echo "Customer updated successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}

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
