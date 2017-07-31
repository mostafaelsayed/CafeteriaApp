<?php
include 'CafeteriaApp.Backend\connection.php';


function getClosedOrdersByCustomerId($conn,$id,$backend=false) {
  if( !isset($id)) 
 {
 echo "Error: Customer Id is not set";
  return;
  }
  else{
  $sql = "select * from order where CustomerId = ".$id;
  $result = $conn->query($sql);
  if ($result) {
      $orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $orders = json_encode($orders);
      $conn->close();
       if($backend)
      { 
        return $orders;   
      }
      else
      {
       echo $orders;
      }
      
  } else {
      echo "Error retrieving orders: " . $conn->error;
  }
}}

function getOrderById($conn,$id,$backend=false) {
  if( !isset($id)) 
 {
 echo "Error: Order Id is not set";
  return;
  }
  else{
  $sql = "select * from order where Id = ".$id." LIMIT 1";
  $result = $conn->query($sql);
  if ($result) {
      $orders = mysqli_fetch_assoc($result);
      $orders = json_encode($orders);
      $conn->close();
      if($backend)
      { 
        return $orders;   
      }
      else
      {
       echo $orders;
      }
    
  } else {
      echo "Error retrieving order: " . $conn->error;
  }
}}



function getOpenOrderIdByCustomerId($conn,$id,$backend=false) {
   $openStatusId=1;

    if( !isset($id)) 
 {
 echo "Error: Customer Id is not set";
  return;
  }
  else
  {
  $sql = "select Id from Order where CustomerId =".$id ."and OrderStatusId = ".$openStatusId ;
  $result = $conn->query($sql);
  if ($result) {
      $order = mysqli_fetch_array($result, MYSQLI_ASSOC);
      $order = json_encode($order);
      $conn->close();
      if($backend)
      { 
        return $order;   
      }
      else
      {
       echo $order;
      }
     
  } else {
      echo "Error retrieving Open Order : " . $conn->error;
  }
}}



function getOrdersByDeliveryDateId($conn,$id,$backend=false) {
    if( !isset($id)) 
 {
 echo "Error: DeliveryDate Id is not set";
  return;
  }
  else{
  $sql = "select * from order where DeliveryDateId = ".$id;
  $result = $conn->query($sql);
  if ($result) {
      $orders = mysqli_fetch_array($result, MYSQLI_ASSOC);
      $orders = json_encode($orders);
      $conn->close();
      if($backend)
      { 
        return $orders;   
      }
      else
      {
       echo $orders;
      }
  } else {
      echo "Error retrieving orders: " . $conn->error;
  }
}}


function getOrdersByDeliveryTimeId($conn,$id,$backend=false) {
  if( !isset($id)) 
 {
 echo "Error: DeliveryTime Id is not set";
  return;
  }
  else{
  $sql = "select * from order where DeliveryTimeId = ".$id;
  $result = $conn->query($sql);
  if ($result) {
      $orders = mysqli_fetch_array($result, MYSQLI_ASSOC);
      $orders = json_encode($orders);
      $conn->close();
      if($backend)
      { 
        return $orders;   
      }
      else
      {
       echo $orders;
      }
  } else {
      echo "Error retrieving orders: " . $conn->error;
  }
}}


function getOrdersByOrderStatusId($conn,$id,$backend=false) {
  if( !isset($id)) 
 {
 echo "Error: OrderStatus Id is not set";
  return;
  }
  else{
  $sql = "select * from order where OrderStatusId = ".$id;
  $result = $conn->query($sql);
  if ($result) {
      $orders = mysqli_fetch_array($result, MYSQLI_ASSOC);
      $orders = json_encode($orders);
      $conn->close();
      if($backend)
      { 
        return $orders;   
      }
      else
      {
       echo $orders;
      }
  } else {
      echo "Error retrieving orders: " . $conn->error;
  }
}}


function getOrdersByPaymentMethodId($conn,$id,$backend=false) {
  if( !isset($id)) 
 {
 echo "Error: PaymentMethod Id is not set";
  return;
  }
  else{
  $sql = "select * from order where PaymentMethodId = ".$id;
  $result = $conn->query($sql);
  if ($result) {
      $orders = mysqli_fetch_array($result, MYSQLI_ASSOC);
      $orders = json_encode($orders);
      $conn->close();
      if($backend)
      { 
        return $orders;   
      }
      else
      {
       echo $orders;
      }
  } else {
      echo "Error retrieving orders: " . $conn->error;
  }
}}




function addOrder( $conn,$deliveryDateId, $deliveryTimeId,  $deliveryPlace, $paid, $total, $paymentMethodId,$orderStatusId, $customerId) {

   if( !isset($deliveryDateId)) 
 {
 echo "Error: Order deliveryDateId is not set";
 return;
  }
elseif (!isset($deliveryTimeId)) {
 echo "Error: Order deliveryTimeId is not set";
  return;
  }
  elseif (!isset($deliveryPlace)) {
 echo "Error: Order deliveryPlace is not set";
  return;
  }
  elseif (!isset($paid)) {
 echo "Error: Order paid is not set";
  return;
  }
  elseif (!isset($total)) {
 echo "Error: Order total is not set";
  return;
  }
  elseif (!isset($paymentMethodId)) {
 echo "Error: Order paymentMethodId is not set";
  return;
  }
  elseif (!isset($orderStatusId)) {
 echo "Error: Order orderStatusId is not set";
  return;
  }
  elseif (!isset($customerId)) {
 echo "Error: Order customerId is not set";
  return;
  }
  else
  {
  $sql = "insert into Order (DeliveryDateId,DeliveryTimeId,DeliveryPlace,Paid,Total, PaymentMethodId,OrderStatusId,CustomerId) values (?,?,?,?,?,?,?,?)"; 
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("iisffiii",$DeliveryDateId, $DeliveryTimeId,  $DeliveryPlace, $Paid, $Total, $PaymentMethodId,$OrderStatusId, 
    $CustomerId );
  $DeliveryDateId=$deliveryDateId;
  $DeliveryTimeId=$deliveryTimeId;
  $DeliveryPlace=$deliveryPlace;
  $Paid=$paid;
  $Total=$total;
  $PaymentMethodId=$paymentMethodId;
  $OrderStatusId=$orderStatusId;
  $CustomerId=$customerId;

  if ($stmt->execute()===TRUE) {
    echo "Order Added successfully";

    return mysqli_insert_id($conn);
  }
  else {
    echo "Error: ".$conn->error;
  }
  $conn->close();
}
}



function deleteOrder($conn,$id) {
 if (!isset($id))
  {
     echo "Error: Id is not set";
  return;
  }
  else{
  //$conn->query("set foreign_key_checks = 0"); // ????????/
  $sql = "delete from Order where Id = ".$id . " LIMIT 1";
  if ($conn->query($sql)===TRUE) {
    echo "Order deleted successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}
}


?>
