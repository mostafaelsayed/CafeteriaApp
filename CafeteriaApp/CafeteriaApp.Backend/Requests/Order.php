<?php
  require __DIR__ . '/../Controllers/Order.php';
  require __DIR__ . '/../Controllers/Fee.php';
  require __DIR__ . '/TestRequestInput.php';

  if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if ( isset($_GET['orderId']) && !isset($_GET['flag']) && testInt($_GET['orderId']) ) {
      checkResult( getOrderById($conn, $_GET['orderId']) );
    }
    elseif ( isset($_GET['orderId']) && isset($_GET['flag']) && $_GET['flag'] == 1) {
      checkResult( getOrderItems($conn, $_GET['orderId']) );
    }
    elseif ( isset($_GET['flag']) && $_GET['flag'] == 1) {
      checkResult( getOrders($conn) );
    }
    elseif ( isset($_GET['flag']) && $_GET['flag'] == 2) {
      generateBrainTreeToken();
    }
    elseif ($_SESSION['roleId'] == 3) {
      checkResult( getCurrentOrder($conn) );
    }
    else {
      checkResult( getOpenOrderByUserId($conn) );
    }
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['nonce']) && checkCSRFToken() ) {
      $q = $conn->query("select `Total` from `order` where `Id` = {$_SESSION['orderId']}");
      $total = mysqli_fetch_assoc($q)['Total'];
      mybraintree::handleBrainTree($conn, $_POST['nonce'], $total);
    }
    elseif ( isset($_POST['orderType']) && testInt($_POST['orderType']) && ($_SESSION['roleId'] == 2 || $_SESSION['roleId'] == 3) && checkCSRFToken() ) { // customer paypal
      if ( isset($_POST['selectedMethod']) && !isset($_POST['paymentId']) && normalizeString($_POST['selectedMethod']) && $_POST['selectedMethod'] != 4) {
        processPayment($conn, $_SESSION['orderId'], $_POST['selectedMethod'], $_POST['orderType']);
      }
    }
    elseif ( isset($_POST['paymentId'], $_POST['payerId']) && normalizeString($conn, $_POST['paymentId'], $_POST['payerId']) && checkCSRFToken() ) { // charge customer here
      chargeCustomer($_POST['paymentId'], $_POST['payerId'], $_SESSION['orderId'], $conn);
    }
    else {
      if ($_SESSION['roleId'] == 3) {
        $_SESSION['orderId'] = addOrder($conn, date('Y-m-d h:m'), 'Cash', 'Open', $_SESSION['userId']); // consider it cash but when user will use paypal (either using paypal or credit), customer should use the app himself to login to paypal
        header("Location: /public/categories");
      }
    }
  }

  if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $data = json_decode( file_get_contents('php://input') );

    if ( isset($data->locationId) && testInt($data->locationId) ) {
      checkResult( updateOrderLocation($conn, $data->locationId) );
    }
    elseif ( isset($data->orderId) && testInt($data->orderId) ) {
      updateOrderIdInSession($conn, $data->orderId);
    }
    elseif ( isset($_GET['type']) && normalizeString($_GET['type']) ) {
      echo updateOrderTypeAndTotal($conn, $_GET['type']);
    }
    elseif ( isset($data->paymentMethod) && normalizeString($data->paymentMethod) ) {
      $paymentMethod = $data->paymentMethod;
      $conn->query("update `order` set `PaymentMethod` = '{$paymentMethod}' where `Id` = {$_SESSION['orderId']}");
      $_SESSION['paymentMethod'] = $paymentMethod;
    }
    elseif (isset($_GET['cashflag']) && $_GET['cashflag'] == 1) {
      CheckOutOrder($conn, $_SESSION['orderId']);
    }
    elseif (isset($_GET['flag']) && $_GET['flag'] == 2 && isset($_GET['orderId']) && testInt($_GET['orderId']) ) {
      hideOrder($conn, $_GET['orderId']);
    }
    else {
      echo "error";
    }
  }

  if ( $_SERVER['REQUEST_METHOD'] == 'DELETE' ) {
    if ($_SESSION['roleId'] == 1) {
      if ( isset($_GET['orderId']) && testInt($_GET['orderId']) ) {
        deleteOpenOrderById($conn, $_GET['orderId']);
      }
    }
  }

  require('../footer.php');
?>