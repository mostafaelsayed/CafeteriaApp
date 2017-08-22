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
  if (isset($_POST["orderId"]))
  {
    // Create new payer and method
    $payer = new Payer();
    $payer->setPaymentMethod('paypal');

    //$item = new Item();
    //$item->setName("products")->setCurrency('GBP')->setQuantity(1)->setPrice($price);

    //$itemList = new ItemList();
    //$itemList->setItems([$item]);

    $details = new Details();
    $details->setShipping('2.00')->setTax('0.00')->setSubtotal('20.00');

    // Set redirect urls
    $redirectUrls = new RedirectUrls();
    $redirectUrls->setReturnUrl(SITE_URL . '/pay.php?success=true')->setCancelUrl(SITE_URL . '/pay.php?success=false');

    // Set payment amount
    $amount = new Amount();
    $amount->setCurrency('GBP')->setTotal('22.00')->setDetails($details);
    // Set transaction object
    $transaction = new Transaction();
    $transaction->setAmount($amount)->setDescription('Payment done');

    // Create the full payment object
    $payment = new Payment();
    $payment->setIntent('sale')->setPayer($payer)->setRedirectUrls($redirectUrls)->setTransactions([$transaction]);

    try
    {
      $payment->create($paypal);
      //CheckOutOrder($conn,$data->orderId,$data->deliveryTimeId ,$data->deliveryPlace,$data->paymentMethodId , $data->paid );
    }
    catch (PayPal\Exception\PayPalConnectionException $ex)
    {
      echo $ex->getData();
      die($ex);
    }
    //Access-Control-Allow-Origin: *;
    foreach ($payment->getLinks() as $link) {
      if ($link->getRel() == 'approval_url') {
        $redirectUrl = $link->getHref();
      }
    }
    header("Location: " . $redirectUrl);
    //$approvalUrl = $payment->getApprovalLink();
    //header("Location: " . $approvalUrl);
    // Create new payer and method


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