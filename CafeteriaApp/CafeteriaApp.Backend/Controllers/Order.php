<?php
include 'CafeteriaApp.Backend\connection.php';


function getOrdersByCustomerId($conn,$id) {
  if( !isset($id)) 
 {
 echo "Error: Customer Id is not set";
  return;
  }
  else{
  $sql = "select * from orders where CustomerId = ".$id;
  if ($conn->query($sql)) {
      $result = $conn->query($sql);
      $orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $orders = json_encode($orders);
      $conn->close();
      return $orders;
  } else {
      echo "Error retrieving orders: " . $conn->error;
  }
}}


function getOrdersByDeliveryDateId($conn,$id) {
    if( !isset($id)) 
 {
 echo "Error: DeliveryDate Id is not set";
  return;
  }
  else{
  $sql = "select * from orders where DeliveryDateId = ".$id;
  if ($conn->query($sql)) {
      $result = $conn->query($sql);
      $orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $orders = json_encode($orders);
      $conn->close();
      return $orders;
  } else {
      echo "Error retrieving orders: " . $conn->error;
  }
}}


function getOrdersByDeliveryTimeId($conn,$id) {
  if( !isset($id)) 
 {
 echo "Error: DeliveryTime Id is not set";
  return;
  }
  else{
  $sql = "select * from orders where DeliveryTimeId = ".$id;
  if ($conn->query($sql)) {
      $result = $conn->query($sql);
      $orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $orders = json_encode($orders);
      $conn->close();
      return $orders;
  } else {
      echo "Error retrieving orders: " . $conn->error;
  }
}}


function getOrdersByOrderStatusId($conn,$id) {
  if( !isset($id)) 
 {
 echo "Error: OrderStatus Id is not set";
  return;
  }
  else{
  $sql = "select * from orders where OrderStatusId = ".$id;
  if ($conn->query($sql)) {
      $result = $conn->query($sql);
      $orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $orders = json_encode($orders);
      $conn->close();
      return $orders;
  } else {
      echo "Error retrieving orders: " . $conn->error;
  }
}}


function getOrdersByPaymentMethodId($conn,$id) {
  if( !isset($id)) 
 {
 echo "Error: PaymentMethod Id is not set";
  return;
  }
  else{
  $sql = "select * from orders where PaymentMethodId = ".$id;
  if ($conn->query($sql)) {
      $result = $conn->query($sql);
      $orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $orders = json_encode($orders);
      $conn->close();
      return $orders;
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
  $sql = "delete from Order where Id = ".$id . "LIMIT 1";
  if ($conn->query($sql)===TRUE) {
    echo "Order deleted successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}
}



if ($_SERVER['REQUEST_METHOD']=="GET") {
  if ($_GET["Id"] != null) {
    getOrdersByCustomerId($conn,$_GET["Id"]);
  }
  else {
    echo "Error occured while returning Orders";
  }
}

if ($_SERVER['REQUEST_METHOD']=="POST"){
    //decode the json data
    $data = json_decode(file_get_contents("php://input"));
    if (isset($data->action) && $data->action == "addOrder" && $data->CustomerId != null && $data->Name != null){
        addOrder($conn,$data->Name,$data->CustomerId);
      }
      else{
        echo "error occured while creating Order";
      }
}
?>
