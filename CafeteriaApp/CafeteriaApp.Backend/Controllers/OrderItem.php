<?php
include 'CafeteriaApp.Backend\connection.php';

function getOrderItems($conn) {
  
  $sql = "select * from OrderItem";
  if ($conn->query($sql)) {
      $result = $conn->query($sql);
      $orderItems = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $orderItems = json_encode($orderItems);
      $conn->close();
      echo $orderItems;
  } else {
      echo "Error retrieving OrderItems : " . $conn->error;
  }
}


function addOrderItem($conn,$n) {
  $sql = "insert into OrderItem (Name) values (?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s",$name);
  $name = $n;
  //$conn->query($sql);
  if ($stmt->execute()===TRUE) {
    echo "OrderItem Added successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}


function editOrderItem($conn,$n,$Id) {
  $sql = "update OrderItem set Name = (?) where Id = (?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("si",$name,$id);
  $name = $n;
  $id = $Id;
  //$conn->query($sql);
  if ($stmt->execute()===TRUE) {
    echo "OrderItem updated successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}

if ($_SERVER['REQUEST_METHOD']=="GET") {
  if (isset($_GET["action"]) && $_GET["action"]=="getOrderItems"){
    getOrderItems($conn);
  }
  else {
    echo "Error occured while returning OrderItems";
  }
}

if ($_SERVER['REQUEST_METHOD']=="POST"){
    //decode the json data
    $data = json_decode(file_get_contents("php://input"));
    if (isset($data->action) && $data->action == "addOrderItem"){
      if ($data->Name != null){
        addOrderItem($conn,$data->Name);
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
        editOrderItem($conn,$data->Name,$data->Id);
      }
      else{
        echo "name is required";
      }
  //}
}

 ?>
