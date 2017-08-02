<?php
require_once( 'CafeteriaApp.Backend/Controllers/OrderItem.php');
require_once("CafeteriaApp.Backend/connection.php");




if ($_SERVER['REQUEST_METHOD']=="GET") {
  // if (isset($_GET["action"]) && $_GET["action"]=="getOrderItems"){
  //   getOrderItems($conn);
  // }
  getOrderItemsByOpenOrderId($conn,$_GET["orderId"]);
  //else {
    //echo "Error occured while returning OrderItems";
  //}
}

if ($_SERVER['REQUEST_METHOD']=="POST"){
    //decode the json data
    $data = json_decode(file_get_contents("php://input"));
    //if (isset($data->action) && $data->action == "addOrderItem"){
      //if ($data->Order != null){
      //echo $data;
      $orderId = addOrderItem($conn,$data->OrderId,$data->MenuItemId,$data->Quantity);
      if($orderId != null)
      {
        echo $orderId;
      }
      else {
        echo "Error: ".$conn->error;
      }
      //}
      //else{
        //echo "name is required";
      //}
  //}
}

if ($_SERVER['REQUEST_METHOD']=="PUT"){
    //decode the json data
    $data = json_decode(file_get_contents("php://input"));
    //echo $data;
      //if ($data->Name != null && $data->Id != null) {
        //if ($data->action == "addcafeteria"){
        editOrderItemQuantity($conn,$data->Quantity,$data->Id);
      //}
      //else{
        //echo "name is required";
      //}
  //}
}

if($_SERVER['REQUEST_METHOD']=="DELETE"){
  if(isset($_GET["id"])){
    deleteOrderItem($conn,$_GET["id"]);
  }
}


 ?>
