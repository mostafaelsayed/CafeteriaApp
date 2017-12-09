<?php
require('CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Controllers/Order.php');
require('TestRequestInput.php');
require_once('CafeteriaApp/CafeteriaApp/PayPal/pay.php');

//var_dump($_SERVER);

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  if ( isset( $_GET['orderId'] ) && !isset( $_GET['flag'] ) && test_int( $_GET['orderId'] ) ) {
    //$Duration = calcOpenOrderDeliveryTime($conn, $_GET['orderId']);
    //$Id = getCurrentTimeId($conn);
    checkResult( getOrderById( $conn, $_GET['orderId'] ) );
  }
  elseif ( isset( $_GET['orderId'] ) && isset( $_GET['flag'] ) && test_int( $_GET['orderId'], $_GET['flag'] ) ) {
    checkResult( getOrderItems( $conn, $_GET['orderId'] ) );
  }
  elseif ( isset( $_GET['flag'] ) && test_int( $_GET['flag'] ) ) {
    checkResult( getOrders($conn) );
  }
  else {
    checkResult( getOpenOrderByUserId($conn) );
  }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if ( isset( $_POST['orderId'], $_POST['deliveryTimeId'], $_POST['orderType'] ) && test_int( $_POST['orderId'], $_POST['deliveryTimeId'], $_POST['orderType'] ) ) {
    if ( isset( $_POST['selectedMethodId'] ) && !isset( $_POST['paymentId'] ) && test_int( $_POST['selectedMethodId'] ) ) {
        processPayment($conn, $_POST['orderId'], $_POST['selectedMethodId'], $_POST['deliveryTimeId'], $paypal, $_POST['orderType']);
    }
    elseif ( isset( $_POST['paymentMethodId'] ) && normalize_string( $conn, $_POST['paymentId'], $_POST['payerId'] ) && test_int( $_POST['paymentMethodId'] ) ) {
      chargeCustomer($_POST['paymentId'], $_POST['payerId'], $paypal, $_POST['orderId'], $_POST['deliveryTimeId'], $_POST['paymentMethodId'], $_POST['orderType'], $conn);
    }
    else {
      echo "error";
    }
  }
}

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
  $data = json_decode( file_get_contents("php://input") );

  if ( isset($data->locationId) ) {
    checkResult( updateOrderLocation($conn, $data->locationId) );
  }
  else {
    echo "error";
  }
}

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
  if ($_SESSION['roleId'] == 1) {
    if (isset( $_GET['orderId'] ) && test_int( $_GET['orderId'] ) ) {
      deleteOpenOrderById( $conn, $_GET['orderId'] );
    }
  }
}

require('CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/footer.php');
?>