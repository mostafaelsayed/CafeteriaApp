<?php

require ('paypal/start.php');

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\ExecutePayment;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;

// Get payment object by passing paymentId
$paymentId = $_GET['paymentId'];
$payment = Payment::get($paymentId, $paypal);
$payerId = $_GET['PayerID'];

// Execute payment with payer id
$execution = new PaymentExecution();
$execution->setPayerId($payerId);

try {
  // Execute payment
  $result = $payment->execute($execution, $paypal);
  var_dump($result);
} catch (PayPal\Exception\PayPalConnectionException $ex) {
  echo $ex->getCode();
  echo $ex->getData();
  die($ex);
} catch (Exception $ex) {
  die($ex);
}
// if (!isset($_GET['success'],$_GET['paymentId'],$_GET['PayerID']))
// {
// 	die();
// }

// if ((bool)$_GET['success'] === false)
// {
// 	die();
// }

// $paymentId = $_GET['paymentId'];
// $payerId = $_GET['PayerID'];
// $payment = Payment::get($paymentId,$paypal);

// $execute = new PaymentExecution();
// $execute->setPayerId($payerId);

// try {
// 	$result = $payment->execute($execute,$paypal);
// } catch (Exception $e) {
// 	$data = json_decode($e->getData());
// 	echo $data->message;
// 	die();
// }

// echo 'Payment Made.Thank you!';
?>