<?php
require_once( 'CafeteriaApp.Backend/Controllers/Order.php');
require_once( 'CafeteriaApp.Backend/Controllers/Times.php');
require_once("CafeteriaApp.Backend/connection.php");

if ($_SERVER['REQUEST_METHOD']=="GET") {
  if (isset($_GET["orderId"])) {
    $Duration = calcOpenOrderDeliveryTime($conn,$_GET["orderId"]);
    $time = time("h:i:00")+($Duration*60);
    $time =date("h:i:00",$time);
    $Id = getTimeIdByTime($conn,$time);
      echo json_encode(array("Id"=>(string)$Id , "Duration"=>(string)$Duration));
  }
  else
   {
    getOpenOrderByCustomerId($conn);
  }
}

if ($_SERVER['REQUEST_METHOD']=="POST"){
    //decode the json data
    $data = json_decode(file_get_contents("php://input"));
    if ($data->CustomerId != null){ // we will see other parameters later
        addOrder($conn,$data->DeliveryDateId,$data->DeliveryTimeId,$data->DeliveryPlace,$data->PaymentMethodId,$data->OrderStatusId,$data->CustomerId,$data->Total,$data->Paid);
      }
      else{
        echo "error occured while creating Order";
      }
}


if ($_SERVER['REQUEST_METHOD']=="PUT"){
     $data = json_decode(file_get_contents("php://input"));
   if(isset($data->orderId)) { 
    CheckOutOrder($conn,$data->orderId,$data->deliveryTimeId ,$data->deliveryPlace,$data->paymentMethodId , $data->paid );
  }
}


if($_SERVER['REQUEST_METHOD']=="DELETE"){
  if(isset($_GET["orderId"])){
    deleteOpenOrderById($conn,$_GET["orderId"]);
  }
}

require_once("CafeteriaApp.Backend/footer.php");

?>
