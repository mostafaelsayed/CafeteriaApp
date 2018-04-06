<?php
// Autoload SDK package for composer based installations
require_once(__DIR__ . '/../lib/vendor/autoload.php');
//require(__DIR__ . '/../paypal/start.php');
require_once(__DIR__ . '/../lib/vendor/braintree/braintree_php/lib/Braintree.php');

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Api\PaymentExecution;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Api\ExecutePayment;

class mypaypal {
	const SITEURL = 'http://127.0.0.1';

	public static function configPaypal() {
		$paypal = new ApiContext(
			new OAuthTokenCredential(
			  //'AX0jX0W_VH9Nef7XwrCEENhtf43mOE8FoNU_QUy5lpKkowSbGNWwrNklAPgTxb9Sy_1m5Kdu3cHNopLk',
			  //'EDzF2C7HP0W3CS63fB10QLIP96smQ8VYb1UQMgTeCeUMUJRRzf_mCjx9IMyEMkkZrI7tQOFOqwTB7hFH'
			  'AZGPDIWL1MdLuKBv5ZVzGDR88znU4MuHKYn2aFsWvkf9qgqAcEUn9naOEY3j5ZRmPKasJ51xQm09dgLh',
			  'EMmWv7NS4w3Z9hq-Piffsb5H1NWE_d4GA2TnmfYnG2UdKouUlpHRDidQImgNhcU8VOaeCTRZhHlnTjxf'
			  //'AaqK9FmuMGv1QG5LkOV3feVs9rrJHh-Aq61u9U50pAxmRvJ6p0zEUKgcLHJaE_BwWPJqemP6CNeGbdmm',
			  //'ENiYI0eZcHx2bXoYTj0392coGpSXNUAB6_NeLfjYqX57dT5BCfz1rjHMvyr-UdgYY5zAxUbpSetQnTW7s'

			)
		);

		$paypal->setConfig([
			'mode' => 'sandbox',
			'http.ConnectionTimeOut' => 30,
			'log.LogEnabled' => false,
			'log.FileName' => '',
			'log.LogLevel' => 'FINE',
			'validation.level' => 'log'
		]);

		return $paypal;
	}

	public static function handlePaypal($conn, $orderId, $orderType, $selectedMethodId) {
		$paypal = self::configPaypal();

		$orderItems = getOrderItems($conn, $orderId);
	    $itemList = new ItemList();
	    $totalOrder = 0.00;

	    foreach ($orderItems as $orderItem) {
	      $item = new Item();
	      $item->setCurrency('GBP');
	      $item->setName($orderItem[0])
	        ->setQuantity($orderItem[2])
	        ->setPrice($orderItem[1]);
	      $itemList->addItem($item);
	      $totalOrder += $orderItem[1] * $orderItem[2];
	    }

	    // determine shipping and tax later from frontend
	    $shippingResult = $conn->query("select `Price` from `fees` where `Id` = 2"); // id of shipping fee
	    $shipping = mysqli_fetch_assoc($shippingResult)['Price'];
	    mysqli_free_result($shippingResult);

	    $taxResult = $conn->query("select `Price` from `fees` where `Id` = 3"); // id of tax fee
	    $tax = mysqli_fetch_assoc($taxResult)['Price'];
	    mysqli_free_result($taxResult);

	    // other fees go here .. 

	    $details = new Details();
	    $details->setShipping($shipping)
	      ->setTax($tax)
	      ->setSubtotal($totalOrder);

	    // Set redirect urls
	    $redirectUrls = new RedirectUrls();
	    $redirectUrls->setReturnUrl(self::SITEURL . '/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Customer/review_order_and_charge_customer.php?orderId=' . $orderId . '&paymentMethodId=' . $selectedMethodId . '&orderType=' . $orderType)
	      ->setCancelUrl(self::SITEURL . '/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Customer/checkout.php?orderId=' . $orderId . '&paymentMethodId=' . $selectedMethodId);

	    // Set payment amount
	    $amount = new Amount();
	    $amount->setCurrency('GBP')
	      ->setTotal($totalOrder + $shipping + $tax)
	      ->setDetails($details);

	    // Set transaction object
	    $transaction = new Transaction();
	    $transaction->setAmount($amount)
	      ->setDescription('Payment done')
	      ->setItemList($itemList);

	    // Set payer
	    $payer = new Payer();
	    $payer->setPaymentMethod('paypal'); // or credit. we should have options

	    // Create the full payment object
	    $payment = new Payment();
	    $payment->setIntent('sale')
	      ->setPayer($payer)
	      ->setRedirectUrls($redirectUrls)
	      ->setTransactions([$transaction]);

	    try {
	      $payment->create($paypal);
	    }
	    catch (PayPalConnectionException $ex) {
	      echo $ex->getData();
	      die($ex);
	    }

	    $approvalUrl = $payment->getApprovalLink();
	    header("Location: " . $approvalUrl);
	}

	public static function chargeCustomer($paymentId, $payerId, $orderId, $selectedMethodId, $conn) {
		$paypal = self::configPaypal();
		// Get payment object by passing paymentId
		$payment = Payment::get($paymentId, $paypal);

		// Execute payment with payer id
		$execution = new PaymentExecution();
		$execution->setPayerId($payerId);

		try {
			$sql = "insert into `transaction` (UserId, PaymentId, PayerId) values (?,?,?)";
			$transactionStatment = $conn->prepare($sql);
			$transactionStatment->bind_param("iss", $UserId, $PaymentId, $PayerId);
			$UserId = $_SESSION["userId"];
			$PaymentId = $paymentId;
			$PayerId = $payerId;
			
			if ($transactionStatment->execute() === true) {
				$result = $payment->execute($execution, $paypal); // Execute payment (charge customer here)
				
				if ($result) {
					updateWithFee($conn, $orderType, $selectedMethodId);
					$result = CheckOutOrder($conn, $orderId, $selectedMethodId);

					if ($result) {
						$returnUrl = self::SITEURL . "/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Public/showing cafeterias.php";
						$_SESSION['notifications'][] = 'Payment Succeeseded !';
						header("Location: " . $returnUrl);
					}
					else {
						echo "Error :payment succeeded but order still open !";
					}
				}
				else {
					$returnUrl = self::SITEURL . "/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Customer/checkout.php";
					header("Location: " . $returnUrl);
				}	
			}
			else {	
				echo "error creating transaction : ", $conn->error;
			}
		}
		catch (PayPalConnectionException $ex) {
		  echo $ex->getCode();
		  echo $ex->getData();
		  die($ex);
		}
	}
}

class mybraintree {
	public static function brainTreeConfig() {
		$braintree = new Braintree_Gateway([
	    	'environment' => 'sandbox',
	    	'merchantId' => 'zg48rfkf4rjxjc3c',
	    	'publicKey' => '2cpnsysv2jp243kj',
	    	'privateKey' => 'd473d110dd1de2ef75752304c7678905'
		]);

		return $braintree;
	}
	public static function handleBrainTree($nonce) {
		$braintree = self::brainTreeConfig();

		$result = $braintree->transaction()->sale([
		    'amount' => '100',
		    'paymentMethodNonce' => $nonce,
		    'options' => ['submitForSettlement' => true]
		]);

		if ($result->success) {
			echo "../Public/showing cafeterias.php";
		} else if ($result->transaction) {
		    print_r("Error processing transaction:");
		    print_r("\n  code: " . $result->transaction->processorResponseCode);
		    print_r("\n  text: " . $result->transaction->processorResponseText);
		} else {
		    print_r("Validation errors: \n");
		    print_r($result->errors->deepAll());
		}
	}
}


// function handleBrainTree($conn, $orderId, $orderType) {

// }