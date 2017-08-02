<?php
require_once( 'CafeteriaApp.Backend/Controllers/Order.php');



if ($_SERVER['REQUEST_METHOD']=="GET") {
  if ($_GET["customerId"] != null) {
    getOpenOrderByCustomerId($conn,$_GET["customerId"]);
  }
  else {
    echo "Error occured while returning Orders";
  }
}

if ($_SERVER['REQUEST_METHOD']=="POST"){
    //decode the json data
    $data = json_decode(file_get_contents("php://input"));
    if ($data->CustomerId != null){ // we will see other parameters later
        addOrder($conn,$data->DeliveryDateId,$data->DeliveryTimeId,$data->DeliveryPlace,$data->Paid,$data->Total,$data->PaymentMethodId,$data->OrderStatusId,$data->CustomerId);
      }
      else{
        echo "error occured while creating Order";
      }
}
?>
