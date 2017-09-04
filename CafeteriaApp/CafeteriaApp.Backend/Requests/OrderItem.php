<?php
require_once( 'CafeteriaApp.Backend/Controllers/OrderItem.php');
require_once("CafeteriaApp.Backend/connection.php");
require_once ('CheckResult.php');

if ($_SERVER['REQUEST_METHOD']=="GET")
{
  if(isset($_GET["orderId"]) && is_int($_GET["orderId"]))
  checkResult(getOrderItemsByOpenOrderId($conn,$_GET["orderId"]));
}


if ($_SERVER['REQUEST_METHOD']=="POST")
{
  //decode the json data
  $data = json_decode(file_get_contents("php://input"));

  if(isset($data->OrderId)&&isset($data->MenuItemId)&&isset($data->Quantity)&&is_int($data->OrderId)&&is_int($data->MenuItemId)&&is_int($data->Quantity))
  {
    $orderId = addOrderItem($conn,$data->OrderId,$data->MenuItemId,$data->Quantity);
      if (!empty($orderId))
        echo $orderId;
    }

}

if ($_SERVER['REQUEST_METHOD']=="PUT")
{
  //decode the json data
  $data = json_decode(file_get_contents("php://input"));
  if(isset($data->Id)&&isset($data->Quantity)&&is_int($data->Id)&&is_int($data->Quantity))
  editOrderItemQuantity($conn,$data->Quantity,$data->Id,$data->Flag);
}

if ($_SERVER['REQUEST_METHOD']=="DELETE")
{
  if (isset($_GET["id"]) && is_int($_GET["id"]))
    deleteOrderItem($conn,$_GET["id"]);
}

require_once("CafeteriaApp.Backend/footer.php");

?>