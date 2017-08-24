<?php

//require_once('paypal/start.php');

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\ExecutePayment;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
use PayPal\Exception\PayPalConnectionException;

function chargeCustomer($paymentId,$payerId,$paypal)
{
	// Get payment object by passing paymentId
	//$paymentId = $_GET['paymentId'];
	$payment = Payment::get($paymentId, $paypal);
	//$payerId = $_GET['PayerID'];

	// Execute payment with payer id
	$execution = new PaymentExecution();
	$execution->setPayerId($payerId);

	try
	{
	  // Execute payment (charge customer here)
	  $result = $payment->execute($execution, $paypal);
	  //var_dump($result);
	  //return "Payment Done";
	  echo "1";
	}

	catch (PayPalConnectionException $ex)
	{
	  echo $ex->getCode();
	  echo $ex->getData();
	  die($ex);
	}

}

// echo 'Payment Made.Thank you!';

?>