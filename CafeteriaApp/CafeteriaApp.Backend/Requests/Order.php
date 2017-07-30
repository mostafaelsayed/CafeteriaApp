<?php
require_once( 'CafeteriaApp.Backend/Controllers/Order.php');



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
