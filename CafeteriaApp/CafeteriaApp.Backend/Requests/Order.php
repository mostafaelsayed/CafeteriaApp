<?php
require('CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Controllers/Order.php');
require('CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Controllers/Fee.php');
require('TestRequestInput.php');
require('CafeteriaApp/CafeteriaApp/PayPal/pay.php');

//var_dump($_SERVER);

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  if ( isset( $_GET['orderId'] ) && !isset( $_GET['flag'] ) && test_int( $_GET['orderId'], $_GET['flag'] ) ) {
    //$Duration = calcOpenOrderDeliveryTime($conn, $_GET['orderId']);
    //$Id = getCurrentTimeId($conn);
    checkResult( getOrderById( $conn, $_GET['orderId'] ) );
  }
  elseif ( isset( $_GET['orderId'] ) && isset( $_GET['flag'] ) && test_int( $_GET['orderId'], $_GET['flag'] ) && $_GET['flag'] == 1) {
    checkResult( getOrderItems( $conn, $_GET['orderId'] ) );
  }
  elseif ( isset( $_GET['flag'] ) && test_int( $_GET['flag'] ) && $_GET['flag'] == 1) {
    checkResult( getOrders($conn) );
  }  
  else {
    checkResult( getOpenOrderByUserId($conn) );
  }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  //var_dump($_POST);
  if ( isset( $_POST['orderType'] ) && test_int( $_POST['orderType'] ) && $_SESSION['roleId'] == 2) { // customer paypal
    if ( isset( $_POST['selectedMethodId'] ) && !isset( $_POST['paymentId'] ) && test_int( $_POST['selectedMethodId'] ) && $_POST['selectedMethodId'] != 4) {
      processPayment($conn, $_SESSION['orderId'], $_POST['selectedMethodId'], $paypal, $_POST['orderType']);
    }
    elseif (isset( $_POST['selectedMethodId'] ) && test_int($_POST['selectedMethodId']) && $_POST['selectedMethodId'] == 4) { // charge customer here
      updateWithFee($conn, $_POST['orderType'], $_POST['selectedMethodId']);
      CheckOutOrder($conn, $_SESSION['orderId'], $_POST['selectedMethodId'], $_POST['orderType']);
      header("Location: " . "/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Areas/Public/Cafeteria/Views/showing cafeterias.php");
      //echo "<script type='text/javascript'>localStorage.setItem('submit', 1);</script>";
    }
    elseif ( isset( $_POST['paymentMethodId'], $_POST['paymentId'], $_POST['payerId'] ) && normalize_string( $conn, $_POST['paymentId'], $_POST['payerId'] ) && test_int( $_POST['paymentMethodId'] ) ) { // charge customer here {
      chargeCustomer($_POST['paymentId'], $_POST['payerId'], $paypal, $_SESSION['orderId'], $_POST['paymentMethodId'], $_POST['orderType'], $conn);
    }    
    else {
      echo "error";
    }
  }
  else {
    if ($_SESSION['roleId'] == 3) {
      $deliveryTimeId = getCurrentTimeId($conn);
      $deliveryDateId = getCurrentDateId($conn);
      $_SESSION['orderId'] = addOrder($conn, $deliveryDateId, $deliveryTimeId, 4, 1, $_SESSION['userId']); // consider it cash but when user will use paypal (either using paypal or credit), customer should use the app himself to login to paypal
      header("Location: " . "/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Areas/Public/Cafeteria/Views/showing cafeterias.php");
    }
  }
}

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
  $data = json_decode( file_get_contents("php://input") );

  if ( isset($data->locationId) && test_int($data->locationId) ) {
    checkResult( updateOrderLocation($conn, $data->locationId) );
  }
  elseif ( isset($data->orderId) && test_int($data->orderId) ) {
    updateOrderIdInSession($conn, $data->orderId);
  }
  else if (isset($_GET['flag']) && test_int($_GET['flag']) && $_GET['flag'] == 2) {
    hideOrder($conn);
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