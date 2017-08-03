<?php
require_once('CafeteriaApp.Backend/session.php');
require_once('CafeteriaApp.Backend/Controllers/Order.php');
require_once('CafeteriaApp.Backend/Controllers/Times.php');
require_once('CafeteriaApp.Backend/Controllers/Dates.php');
require_once('CafeteriaApp.Backend/Controllers/MenuItem.php');


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
  $sql = "select OrderItem.Id , MenuItem.Name , MenuItem.Id as MenuItemId , OrderItem.TotalPrice ,OrderItem.Quantity from OrderItem INNER JOIN MenuItem ON  OrderItem.MenuItemId = MenuItem.Id";
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
      //$conn->close();
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


function getOrderItemTotalPriceById($conn , $id) {
   if( !isset($id))
 {
 echo "Error:MenuItem Id is not set";
  return;
  }
  else
  {
  $sql = "select TotalPrice from OrderItem where Id = ".$id." LIMIT 1";
  //$result = $conn->query($sql);
  if ($result = $conn->query($sql)) {
      $MenuItem = mysqli_fetch_assoc($result);
     // $conn->close();
        return $MenuItem["TotalPrice"];
  }
  else {
      echo "Error retrieving Order Item: " . $conn->error;
  }
}}



 function editOrderItemQuantity($conn,$quantity,$id,$increaseDecrease) {//**************************** update oreder Total
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
  else
  {
  $MenuItemId = json_decode(getOrderItemById($conn,$id,true), true)["MenuItemId"];
  $unitPrice =getMenuItemPriceById($conn,$MenuItemId);

  $orderId =json_decode(getOpenOrderByCustomerId($conn,true), true)["Id"];

  updateOrderTotalById($conn,$orderId,$increaseDecrease ?+$unitPrice : -$unitPrice);

  $totalPrice = $quantity * $unitPrice;
  $sql = "update OrderItem set Quantity = (?) , TotalPrice=(?)  where Id = (?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("idi",$Quantity,$TotalPrice,$Id);
  $Quantity = $quantity;
  $TotalPrice = $totalPrice ;
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

$unitPrice =getMenuItemPriceById($conn,$menuItemId);
$totalPrice  =  $quantity * $unitPrice ;

if ($orderId == null) // create order by default values
{
  $deliveryTimeId = getCurrentTimeId($conn);
  $deliveryDateId = getCurrentDateId($conn);

  $orderId = addOrder($conn,$deliveryDateId,$deliveryTimeId,'Where?',1,1, $_SESSION["customerId"], $totalPrice);//paid default to zero

  if ($orderId != null) {
    $sql = "insert into OrderItem (OrderId,MenuItemId,Quantity,TotalPrice) values (?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiid",$OrderId,$MenuItemId,$Quantity,$Price);
    $OrderId = $orderId;
    $MenuItemId = $menuItemId;
    $Quantity = $quantity;
    $Price =$totalPrice ;
    //$conn->query($sql);
    if ($stmt->execute()===TRUE) {
      //echo "OrderItem Added successfully";
      return $orderId;
    }
    else {
      echo "Error: ".$conn->error;
    }
  }
}
else
   {

  updateOrderTotalById($conn,$orderId,$totalPrice);
  $sql = "insert into OrderItem (OrderId,MenuItemId,Quantity,TotalPrice) values (?,?,?,?)"; // add TotalPrice to total of the order
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("iiid",$OrderId,$MenuItemId,$Quantity,$Price);
  $OrderId = $orderId;
  $MenuItemId = $menuItemId;
  $Quantity = $quantity;
  $Price =$totalPrice ;
  //$conn->query($sql);
  if ($stmt->execute()===TRUE) {
    //echo "OrderItem Added successfully";
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

  $orderId =json_decode(getOpenOrderByCustomerId($conn,true), true)["Id"];
  $totalPrice=getOrderItemTotalPriceById($conn,$id);
  updateOrderTotalById($conn,$orderId,-$totalPrice);
  $sql = "delete from OrderItem where Id = ".$id . " LIMIT 1";
  if ($conn->query($sql)===TRUE ) {
    echo "Order Item deleted successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}
}


 ?>
