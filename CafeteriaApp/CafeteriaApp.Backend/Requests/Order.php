<?php
  require(__DIR__ . '/../Controllers/Order.php');
  require(__DIR__ . '/../Controllers/Fee.php');
  require(__DIR__ . '/TestRequestInput.php');

  // var_dump($_POST);

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
      if ( isset($_POST['selectedMethodId']) && !isset($_POST['paymentId']) && testInt($_POST['selectedMethodId']) && $_POST['selectedMethodId'] != 4) {
        processPayment($conn, $_SESSION['orderId'], $_POST['selectedMethodId'], $_POST['orderType']);
      }
    }
    elseif ( isset($_POST['paymentId'], $_POST['payerId']) && normalizeString($conn, $_POST['paymentId'], $_POST['payerId']) && checkCSRFToken() ) { // charge customer here
      chargeCustomer($_POST['paymentId'], $_POST['payerId'], $_SESSION['orderId'], $conn);
    }
    else {
      if ($_SESSION['roleId'] == 3) {
        $_SESSION['orderId'] = addOrder($conn, date('Y-m-d h:m'), 4, 1, $_SESSION['userId']); // consider it cash but when user will use paypal (either using paypal or credit), customer should use the app himself to login to paypal
        header("Location: " . "/public/categories");
      }
    }
  }

  if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    //var_dump($_POST);
    //exit();
    $data = json_decode( file_get_contents('php://input') );

    if ( isset($data->locationId) && testInt($data->locationId) ) {
      checkResult( updateOrderLocation($conn, $data->locationId) );
    }
    elseif ( isset($data->orderId) && testInt($data->orderId) ) {
      updateOrderIdInSession($conn, $data->orderId);
    }
    elseif ( isset($_GET['type']) && testInt($_GET['type']) && checkCSRFToken() ) {
      echo updateOrderTypeAndTotal($conn, $_GET['type']);
      //$conn->query("update `order` set `Type` = {$_GET['type']} where `Id` = {$_SESSION['orderId']}");
    }
    elseif ( isset($data->paymentMethodId) && testInt($data->paymentMethodId) ) {
      //die($data->paymentMethodId);
      $id = $data->paymentMethodId;
      $conn->query("update `order` set `PaymentMethodId` = {$id} where `Id` = {$_SESSION['orderId']}");
      $_SESSION['paymentMethodId'] = $id;
    }
    elseif (isset($_GET['cashflag']) && $_GET['cashflag'] == 1) {
      CheckOutOrder($conn, $_SESSION['orderId']);
    }
    elseif (isset($_GET['flag']) && $_GET['flag'] == 2 && isset($_GET['orderId']) && testInt($_GET['orderId']) ) {
      hideOrder($conn, $_GET['orderId']);
    }
    // else if ($_GET['flag'] == 3) {
    //   $conn->query("update `order` set `Type` = 1 where `Id` = {$_SESSION['orderId']}");
    // }
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