<?php
require_once( 'CafeteriaApp.Backend/Controllers/OrderItem.php');
require_once("CafeteriaApp.Backend/connection.php");
require_once ('CheckResult.php');

if ($_SERVER['REQUEST_METHOD']=="GET")
{
  // if (isset($_GET["action"]) && $_GET["action"]=="getOrderItems"){
  //   getOrderItems($conn);
  // }
  checkResult(getOrderItemsByOpenOrderId($conn,$_GET["orderId"]));
  //else {
    //echo "Error occured while returning OrderItems";
  //}
}

if ($_SERVER['REQUEST_METHOD']=="POST")
{
  //decode the json data
  $data = json_decode(file_get_contents("php://input"));

  $orderId = addOrderItem($conn,$data->OrderId,$data->MenuItemId,$data->Quantity);

  if ($orderId != null)
  {
    echo $orderId;
  }

}

if ($_SERVER['REQUEST_METHOD']=="PUT")
{
  //decode the json data
  $data = json_decode(file_get_contents("php://input"));
  editOrderItemQuantity($conn,$data->Quantity,$data->Id,$data->Flag);
}

if ($_SERVER['REQUEST_METHOD']=="DELETE")
{
  if (isset($_GET["id"]))
  {
    deleteOrderItem($conn,$_GET["id"]);
  }
}

require_once("CafeteriaApp.Backend/footer.php");

?>