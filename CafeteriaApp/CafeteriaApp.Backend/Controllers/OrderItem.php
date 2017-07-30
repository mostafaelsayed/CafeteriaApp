<?php
include 'CafeteriaApp.Backend\connection.php';

function getOrderItemsByOrderId($conn,$id) {
    if( !isset($id)) 
 {
 echo "Error: Order Id is not set";
  return;
  }
  else
  {
  $sql = "select * from OrderItem where OrderId=".$id;
  if ($conn->query($sql)) {
      $result = $conn->query($sql);
      $orderItems = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $orderItems = json_encode($orderItems);
      $conn->close();
      return $orderItems;
  } else {
      echo "Error retrieving OrderItems : " . $conn->error;
  }
}}



function addOrderItem($conn,$orderId,$menuItemId,$quantity,$totalPrice) {

   if( !isset($orderId)) 
 {
 echo "Error: OrderItem orderId is not set";
  return;
  }
elseif (!isset($menuItemId)) {
 echo "Error: OrderItem menuItemId is not set";
  return;
  }
  elseif (!isset($quantity)) {
 echo "Error: OrderItem quantity is not set";
  return;
  }
  elseif (!isset($totalPrice)) {
 echo "Error: OrderItem totalPrice is not set";
  return;
  }
  else {
  $sql = "insert into OrderItem (OrderId,MenuItemId,Quantity,TotalPrice) values (?,?,?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("iiif",$OrderId,$MenuItemId,$Quantity,$TotalPrice);
  $OrderId = $orderId;
  $MenuItemId = $menuItemId;
  $Quantity = $quantity;
  $TotalPrice = $totalPrice;
  //$conn->query($sql);
  if ($stmt->execute()===TRUE) {
    echo "OrderItem Added successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}}


function deleteOrderItem($conn,$id) {
 if (!isset($id))
  {
     echo "Error: Id is not set";
  return;
  }
  else{
  //$conn->query("set foreign_key_checks = 0"); // ????????/
  $sql = "delete from OrderItem where Id = ".$id . "LIMIT 1";
  if ($conn->query($sql)===TRUE) {
    echo "OrderItem deleted successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
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
