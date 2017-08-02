<?php
require_once('CafeteriaApp.Backend/session.php');
require_once('CafeteriaApp.Backend/Controllers/Order.php');
require_once('CafeteriaApp.Backend/Controllers/Times.php');
require_once('CafeteriaApp.Backend/Controllers/Dates.php');


function getOrderItemsByClosedOrderId($conn,$id,$backend=false) {
    if( !isset($id))
 {
 echo "Error: Order Id is not set";
  return;
  }
  else
  {
  $sql = "select MenuItem.Name , OrderItem.Quantity , OrderItem.TotalPrice  from OrderItem INNER JOIN MenuItem ON  OrderItem.MenuItemId = MenuItem.Id where OrderItem.OrderId=".$id ;
  $result = $conn->query($sql);
  if ($result) {
      $orderItems = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $orderItems = json_encode($orderItems);
      $conn->close();
      if($backend)
      {
        return $orderItems;
      }
      else
      {
       echo $orderItems;
      }

  } else {
      echo "Error retrieving OrderItems : " . $conn->error;
  }
}}

function getOrderItemsByOpenOrderId($conn,$id,$backend=false) {
    if( !isset($id))
 {
 echo "Error: Order Id is not set";
  return;
  }
  else
  {
  $sql = "select OrderItem.Id , MenuItem.Name , MenuItem.Id as MenuItemId , OrderItem.Quantity from OrderItem INNER JOIN MenuItem ON  OrderItem.MenuItemId = MenuItem.Id";
  $result = $conn->query($sql);
  if ($result) {
      $orderItems = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $orderItems = json_encode($orderItems);
      $conn->close();
      if($backend)
      {
        return $orderItems;
      }
      else
      {
       echo $orderItems;
      }

  } else {
      echo "Error retrieving OrderItems : " . $conn->error;
  }
}}




function getOrderItemById($conn,$id,$backend=false) {
    if( !isset($id))
 {
 echo "Error: OrderItem Id is not set";
  return;
  }
  else
  {
  $sql = "select * from OrderItem where Id=".$id." LIMIT 1";
  $result = $conn->query($sql);
  if ($result) {
      $orderItem = mysqli_fetch_assoc($result);
      $orderItem = json_encode($orderItem);
      $conn->close();
       if($backend)
      {
        return $orderItem;
      }
      else
      {
       echo $orderItem;
      }

  } else {
      echo "Error retrieving OrderItem : " . $conn->error;
  }
}}


 function editOrderItemQuantity($conn,$quantity,$id) {//**************************** update orederitem price, total of the order
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





function addOrderItem($conn,$orderId,$menuItemId,$quantity) {

  if (!isset($menuItemId)) {
 echo "Error: OrderItem menuItemId is not set";
  return;
  }
  elseif (!isset($quantity)) {
 echo "Error: OrderItem quantity is not set";
  return;
  }

elseif ($orderId == null) // create order by default values
{
  $deliveryTimeId = getCurrentTimeId($conn);
  $deliveryDateId = getCurrentDateId($conn);
  $orderId = addOrder($conn,$deliveryDateId,$deliveryTimeId,'Where?',0.0,0.0,1,1, $_SESSION["customerId"]);
  if ($orderId != null) {
    $sql = "insert into OrderItem (OrderId,MenuItemId,Quantity,TotalPrice) values (?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiid",$OrderId,$MenuItemId,$Quantity,$Price);
    $OrderId = $orderId;
    $MenuItemId = $menuItemId;
    $Quantity = $quantity;
    $price =5 ;
    $Price =$quantity * $price ; //$price;//*********************************get price from db.menuItems
    //$conn->query($sql);
    if ($stmt->execute()===TRUE) {
      echo "OrderItem Added successfully";
      return $orderId;
    }
    else {
      echo "Error: ".$conn->error;
    }
  }
  //addOrderItem($conn,$orderId,$menuItemId,$quantity,$customerId);
  //$order = json_decode( getOpenOrderByCustomerId( $conn, $_SESSION["customer_id"]), true );

  // if(isset($order)){
  // $orderId = $order["Id"];
  //   }
  // else{
  //   return false; // untill we can handle delivery_place and payment_method
  // }

  }
  else {
  $sql = "insert into OrderItem (OrderId,MenuItemId,Quantity,TotalPrice) values (?,?,?,?)"; // add TotalPrice to total of the order
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("iiid",$OrderId,$MenuItemId,$Quantity,$Price);
  $OrderId = $orderId;
  $MenuItemId = $menuItemId;
  $Quantity = $quantity;
  $Price = $price;
  //$conn->query($sql);
  if ($stmt->execute()===TRUE) {
    echo "OrderItem Added successfully";
    return $orderId;
  }
  else {
    echo "Error: ".$conn->error;
  }
}}


function deleteOrderItem($conn,$id) {// remove TotalPrice to total of the order
 if (!isset($id))
  {
     echo "Error: Id is not set";
  return;
  }
  else{
  //$conn->query("set foreign_key_checks = 0"); // ????????/
  $sql = "delete from OrderItem where Id = ".$id . " LIMIT 1";
  if ($conn->query($sql)===TRUE) {
    echo "OrderItem deleted successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}
}




 ?>
