<?php
require_once('CafeteriaApp.Backend/session.php');
include 'CafeteriaApp.Backend\connection.php';
require_once('CafeteriaApp.Backend/Controllers/Order.php');


function getOrderItemsByOrderId($conn,$id) {
    if( !isset($id)) 
 {
 echo "Error: Order Id is not set";
  return;
  }
  else
  {
  $sql = "select * from OrderItem where OrderId=".$id;
  $result = $conn->query($sql);
  if ($result) {
      $orderItems = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $orderItems = json_encode($orderItems);
      $conn->close();
      return $orderItems;
  } else {
      echo "Error retrieving OrderItems : " . $conn->error;
  }
}}

function getOrderItemById($conn,$id) {
    if( !isset($id)) 
 {
 echo "Error: OrderItem Id is not set";
  return;
  }
  else
  {
  $sql = "select * from OrderItem where Id=".$id;
  $result = $conn->query($sql);
  if ($result) {
      $orderItems = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $orderItems = json_encode($orderItems);
      $conn->close();
      return $orderItems;
  } else {
      echo "Error retrieving OrderItem : " . $conn->error;
  }
}}


 function editOrderItemQuantity($conn,$quantity,$id) {
  if( !isset($quantity)) 
 {
 echo "Error: OrderItem quantity is not set";
  return;
  }
  elseif(!isset($id))
  {
    echo "Error: OrderItem id is not set";
  return;
  }
  else{
  $sql = "update OrderItem set Quantity = (?) where Id = (?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ii",$Quantity,$Id);
  $Quantity = $quantity;
  $Id = $id;
  //$conn->query($sql);
  if ($stmt->execute()===TRUE) {
    echo "OrderItem updated successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}}





function addOrderItem($conn,$orderId,$menuItemId,$quantity,$totalPrice) {

  if (!isset($menuItemId)) {
 echo "Error: OrderItem menuItemId is not set";
  return;
  }
  elseif (!isset($quantity)) {
 echo "Error: OrderItem quantity is not set";
  return;
  }
  elseif (!isset($totalPrice)) { // **********************************************************
   echo "Error: OrderItem totalPrice is not set";
  return;
}

elseif (!isset($orderId)) { // **********************************************************

  $order = json_decode( getOpenOrderByCustomerId( $conn, $_SESSION["CustomerId"]), true );
  
  if(isset($order)){
  $orderId = $order["Id"];}
  else{

    return false; // **********************************************************
 }

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




 ?>
