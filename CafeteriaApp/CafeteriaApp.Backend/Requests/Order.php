<?php

require_once( 'CafeteriaApp.Backend/Controllers/Order.php');
require_once( 'CafeteriaApp.Backend/Controllers/Times.php');
require_once("CafeteriaApp.Backend/connection.php");
require_once ('CheckResult.php');
require_once('PayPal/start.php');
require_once('PayPal/pay.php');

if ($_SERVER['REQUEST_METHOD']=="GET")
{
  if (isset($_GET["orderId"]) && !isset($_GET["flag"]))
  {
    $Duration = calcOpenOrderDeliveryTime($conn,$_GET["orderId"]);
    $time = time("h:i:00")+($Duration*60);
    $time =date("h:i:00",$time);
    $Id = getTimeIdByTime($conn,$time);
    //echo json_encode(array("Id"=>(string)$Id , "Duration"=>(string)$Duration));
    checkResult(array("Id"=>(string)$Id , "Duration"=>(string)$Duration));
  }
  elseif (isset($_GET["orderId"]) && isset($_GET["flag"]))
  {
    checkResult(getOrderDetails($conn,$_GET["orderId"]));
  }
  elseif(isset($_GET['flag']))
  {
    checkResult(getOrders($conn));
  }
  else
  {
    checkResult(getOpenOrderByUserId($conn));
  }
}

if ($_SERVER['REQUEST_METHOD']=="POST")
{
  if (isset($_POST["orderId"]) && !isset($_POST["paymentId"]))
  {
    processPayment($conn,$_POST["orderId"],$_POST["selectedMethodId"],$_POST["deliveryPlace"],$_POST["deliveryTimeId"],$_POST["categoryId"],$paypal);
  }
  elseif (isset($_POST["paymentId"]))
  {
    chargeCustomer($_POST["paymentId"],$_POST["payerId"],$paypal,$_POST["categoryId"],$_POST["orderId"],$_POST["deliveryTimeId"],$_POST["deliveryPlace"],$_POST["paymentMethodId"],$conn);
  }
}

// if ($_SERVER['REQUEST_METHOD']=="PUT")
// {
//   //echo "most";
//   $data = json_decode(file_get_contents("php://input"));
//   chargeCustomer($data->paymentId,$data->payerId,$paypal,$data->categoryId,$conn);
//   //$data = json_decode(file_get_contents("php://input"));
  
// }

if ($_SERVER['REQUEST_METHOD']=="DELETE")
{
  if (isset($_GET["orderId"]) && $_GET["orderId"] != null)
  {
    deleteOpenOrderById($conn,$_GET["orderId"]);
  }
}

require_once("CafeteriaApp.Backend/footer.php");

?>