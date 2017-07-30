<?php
include 'CafeteriaApp.Backend\connection.php';

function getOrderStatus($conn) {
  
  $sql = "select * from OrderStatus";
  if ($conn->query($sql)) {
      $result = $conn->query($sql);
      $OrderStatus = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $OrderStatus = json_encode($OrderStatus);
      $conn->close();
      return $OrderStatus;
  } else {
      echo "Error retrieving OrderStatus: " . $conn->error;
  }
}


function addOrderStatus($conn,$name) {
   if( !isset($name)) 
 {
 echo "Error:OrderStatus name is not set";
  return;
  }
  else
  {
  $sql = "insert into OrderStatus (Name) values (?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s",$Name);
  $Name = $name;
  //$conn->query($sql);
  if ($stmt->execute()===TRUE) {
    echo "OrderStatus Added successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}}


function editOrderStatus($conn,$name,$id) {
  if( !isset($name)) 
 {echo "Error:OrderStatus name is not set";
  return;
  }
  elseif(!isset($id))
  {echo "Error:OrderStatus Id is not set";
  return;}

else
{  $sql = "update OrderStatus set Name = (?) where Id = (?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("si",$Name,$Id);
  $Name = $name;
  $Id = $id;
  //$conn->query($sql);
  if ($stmt->execute()===TRUE) {
    echo "OrderStatus updated successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}
}


function deleteOrderStatus($conn,$id) {
 if (!isset($id))
  {
     echo "Error: Id is not set";
  return;
  }
  else{
  //$conn->query("set foreign_key_checks = 0"); // ????????/
  $sql = "delete from OrderStatus where Id = ".$id . "LIMIT 1";
  if ($conn->query($sql)===TRUE) {
    echo "OrderStatus deleted successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}
}


if ($_SERVER['REQUEST_METHOD']=="GET") {
  if (isset($_GET["action"]) && $_GET["action"]=="getOrderStatus"){
    getOrderStatus($conn);
  }
  else {
    echo "Error occured while returning OrderStatus";
  }
}

if ($_SERVER['REQUEST_METHOD']=="POST"){
    //decode the json data
    $data = json_decode(file_get_contents("php://input"));
    if (isset($data->action) && $data->action == "addOrderStatus"){
      if ($data->Name != null){
        addOrderStatus($conn,$data->Name);
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
        editOrderStatus($conn,$data->Name,$data->Id);
      }
      else{
        echo "name is required";
      }
  //}
}

 ?>
