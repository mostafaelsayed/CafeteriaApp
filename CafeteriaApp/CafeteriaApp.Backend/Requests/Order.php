<?php

require_once( 'CafeteriaApp.Backend/Controllers/Order.php');
require_once( 'CafeteriaApp.Backend/Controllers/Times.php');
require_once("CafeteriaApp.Backend/connection.php");
require ('paypal/start.php');
require_once ('CheckResult.php');

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
//header("Access-Control-Allow-Origin: *");

if ($_SERVER['REQUEST_METHOD']=="GET")
{
  if (isset($_GET["orderId"]))
  {
    $Duration = calcOpenOrderDeliveryTime($conn,$_GET["orderId"]);
    $time = time("h:i:00")+($Duration*60);
    $time =date("h:i:00",$time);
    $Id = getTimeIdByTime($conn,$time);
    //echo json_encode(array("Id"=>(string)$Id , "Duration"=>(string)$Duration));
    checkResult(array("Id"=>(string)$Id , "Duration"=>(string)$Duration));
  }
  else
  {
    checkResult(getOpenOrderByUserId($conn));
  }
}

if ($_SERVER['REQUEST_METHOD']=="POST")
{
//decode the json data
//$data = json_decode(file_get_contents("php://input"));
//if (isset($data->CustomerId) && $data->CustomerId != null){ // we will see other parameters later
  //  addOrder($conn,$data->DeliveryDateId,$data->DeliveryTimeId,$data->DeliveryPlace,$data->PaymentMethodId,$data->OrderStatusId,$data->CustomerId,$data->Total,$data->Paid);
  //}
  //else
  //{
  if (isset($_POST["orderId"]))
  {
    $price = 1;
    //$price = $_POST["total"];
    $shipping = 0.00;
    $total = $price + $shipping;
    // Create new payer and method
    $payer = new Payer();
    $payer->setPaymentMethod('paypal');

    $item = new Item();
    $item->setName("products")->setCurrency('GBP')->setQuantity(1)->setPrice($price);

    $itemList = new ItemList();
    $itemList->setItems([$item]);

    $details = new Details();
    $details->setShipping($shipping)->setSubtotal($price);

    // Set redirect urls
    $redirectUrls = new RedirectUrls();
    $redirectUrls->setReturnUrl(SITE_URL . '/pay.php?success=true')
      ->setCancelUrl(SITE_URL . '/pay.php?success=false');

    // Set payment amount
    $amount = new Amount();
    $amount->setCurrency('GBP')
      ->setTotal($total)->setDetails($details);
    // Set transaction object
    $transaction = new Transaction();
    $transaction->setAmount($amount)
      ->setItemList($itemList)->setDescription('Payment done');

    // Create the full payment object
    $payment = new Payment();
    $payment->setIntent('sale')
      ->setPayer($payer)
      ->setRedirectUrls($redirectUrls)
      ->setTransactions([$transaction]);
    try
    {
      //header("Access-Control-Allow-Origin: *");
      $payment->create($paypal);
      //CheckOutOrder($conn,$data->orderId,$data->deliveryTimeId ,$data->deliveryPlace,$data->paymentMethodId , $data->paid );
    }
    catch (PayPal\Exception\PayPalConnectionException $ex)
    {
      echo $ex->getData();
      die($ex);
    }
    //Access-Control-Allow-Origin: *;
    $approvalUrl = $payment->getApprovalLink();
    //header();
    header("Location: " . $approvalUrl);
  }
  else
  {
    echo "error occured while creating Order";
  }
}

if ($_SERVER['REQUEST_METHOD']=="PUT")
{
  //echo "most";
  //$data = json_decode(file_get_contents("php://input"));
  
}

if ($_SERVER['REQUEST_METHOD']=="DELETE")
{
  if (isset($_GET["orderId"]) && $_GET["orderId"] != null)
  {
    deleteOpenOrderById($conn,$_GET["orderId"]);
  }
}

require_once("CafeteriaApp.Backend/footer.php");

?>