<?php
// Autoload SDK package for composer based installations
require_once __DIR__ . '/../lib/vendor/autoload.php';
//require(__DIR__ . '/../paypal/start.php');
require_once __DIR__ . '/../lib/vendor/braintree/braintree_php/lib/Braintree.php';

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
	const SITEURL = 'http://127.0.0.2';

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

	public static function handlePaypal($conn, $orderId, $orderType, $selectedMethod) {
		$paypal = self::configPaypal();
		$order = getOrderItems($conn, $orderId);
		$orderItems = $order[1];
		$orderDetails = $order[0];
	    $itemList = new ItemList();
		$totalOrder = 0.00;
		
		

	    foreach ($orderItems as $orderItem) {
	      $item = new Item();
	      $item->setCurrency('GBP');
	      $item->setName($orderItem['Name'])
	        ->setQuantity($orderItem['Quantity'])
	        ->setPrice($orderItem['Price']);
	      $itemList->addItem($item);
	    }

		$totalOrder = $orderDetails['Total'];
		
	    $deliveryPrice = 0;

	    // determine shipping and tax later from frontend
	    $deliveryResult = $conn->query("select `Price` from `fees` where `Id` = 1"); // id of shipping fee
	    $delivery = mysqli_fetch_assoc($deliveryResult)['Price'];
	    mysqli_free_result($deliveryResult);

	    $taxResult = $conn->query("select `Price` from `fees` where `Id` = 3"); // id of tax fee
	    $tax = mysqli_fetch_assoc($taxResult)['Price'];
	    mysqli_free_result($taxResult);
	    // other fees go here .. 

	    $details = new Details();
	    $details->setTax($tax);

		if ($orderType == 'Delivery') { // if delivery
			$details->setShipping($delivery);
			$details->setSubtotal($totalOrder - $tax - $delivery);
		}
		else {
			$details->setSubtotal($totalOrder - $tax);
		}

		// echo "orderItems\n";
		// var_dump($orderItems);

		// echo "orderDetails\n";
		// var_dump($orderDetails);

		// echo "totalOrder\n";
		// var_dump($totalOrder);

		// echo "itemList\n";
		// var_dump($itemList);

		// echo "details\n";
		// var_dump($details);

	    // Set redirect urls
	    $redirectUrls = new RedirectUrls();
	    $redirectUrls->setReturnUrl(self::SITEURL . '/pay/Paypal?orderId=' . $orderId)
	      ->setCancelUrl(self::SITEURL . '/checkout/' . $orderId);

	    // Set payment amount
	    $amount = new Amount();
	    $amount->setCurrency('GBP')
	      ->setTotal($totalOrder)
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

	public static function chargeCustomer($paymentId, $payerId, $orderId, $conn) {
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
					$result = CheckOutOrder($conn, $orderId);

					if ($result) {
						$returnUrl = self::SITEURL . "/public/categories";
						$_SESSION['notifications'][] = 'Payment Succeeseded !';
						header("Location: " . $returnUrl);
					}
					else {
						echo "Error :payment succeeded but order still open !";
					}
				}
				else {
					$returnUrl = self::SITEURL . "/checkout/" . $orderId;
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
	public static function handleBrainTree($conn, $nonce, $amount) {
		$braintree = self::brainTreeConfig();

		$result = $braintree->transaction()->sale([
		    'amount' => $amount,
		    'paymentMethodNonce' => $nonce,
		    'options' => ['submitForSettlement' => true]
		]);

		if ($result->success) {
			CheckOutOrder($conn, $_SESSION['orderId']);
			header("Location: /public/categories");
		}
		// else if ($result->transaction) {
		//     print_r("Error processing transaction:");
		//     print_r("\n  code: " . $result->transaction->processorResponseCode);
		//     print_r("\n  text: " . $result->transaction->processorResponseText);
		// }
		// else {
		//     print_r("Validation errors: \n");
		//     print_r($result->errors->deepAll());
		// }
		else {
			die("error");
		}
	}
}


// function handleBrainTree($conn, $orderId, $orderType) {

// }