<?php
  require(__DIR__ . '/../Controllers/Order.php');
  require(__DIR__ . '/../Controllers/Fee.php');
  require(__DIR__ . '/TestRequestInput.php');
  require(__DIR__ . '/../paypal/pay.php');

  if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if ( isset($_GET['orderId']) && !isset($_GET['flag']) && testInt($_GET['orderId']) ) {
      checkResult( getOrderById($conn, $_GET['orderId']) );
    }
    elseif ( isset($_GET['orderId']) && isset($_GET['flag']) && testInt($_GET['orderId']) && $_GET['flag'] == 1) {
      checkResult( getOrderItems($conn, $_GET['orderId']) );
    }
    elseif ( isset($_GET['flag']) && $_GET['flag'] == 1) {
      checkResult( getOrders($conn) );
    }  
    else {
      checkResult( getOpenOrderByUserId($conn) );
    }
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ( isset($_POST['orderType']) && testInt($_POST['orderType']) && $_SESSION['roleId'] == 2) { // customer paypal
      if ( isset($_POST['selectedMethodId']) && !isset($_POST['paymentId']) && testInt($_POST['selectedMethodId']) && $_POST['selectedMethodId'] != 4) {
        processPayment($conn, $_SESSION['orderId'], $_POST['selectedMethodId'], $paypal, $_POST['orderType']);
      }
      elseif (isset($_POST['selectedMethodId']) && testInt($_POST['selectedMethodId']) && $_POST['selectedMethodId'] == 4) { // charge customer here
        updateWithFee($conn, $_POST['orderType'], $_POST['selectedMethodId']);
        CheckOutOrder($conn, $_SESSION['orderId'], $_POST['selectedMethodId']);
        header("Location: " . "/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Areas/Public/Cafeteria/Views/showing cafeterias.php");
      }
      elseif ( isset($_POST['paymentMethodId'], $_POST['paymentId'], $_POST['payerId']) && normalizeString($conn, $_POST['paymentId'], $_POST['payerId']) && testInt($_POST['paymentMethodId']) ) { // charge customer here {
        chargeCustomer($_POST['paymentId'], $_POST['payerId'], $paypal, $_SESSION['orderId'], $_POST['paymentMethodId'], $conn);
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
    $data = json_decode( file_get_contents('php://input') );

    if ( isset($data->locationId) && testInt($data->locationId) ) {
      checkResult( updateOrderLocation($conn, $data->locationId) );
    }
    elseif ( isset($data->orderId) && testInt($data->orderId) ) {
      updateOrderIdInSession($conn, $data->orderId);
    }
    else if ($_GET['flag'] == 1) {
      $conn->query("update `order` set `Type` = 0 where `Id` = {$_SESSION['orderId']}");
    }
    else if ($_GET['flag'] == 2 && isset($_GET['orderId']) && testInt($_GET['orderId']) ) {
      hideOrder($conn, $_GET['orderId']);
    }
    else if ($_GET['flag'] == 3) {
      $conn->query("update `order` set `Type` = 1 where `Id` = {$_SESSION['orderId']}");
    }
    else {
      echo "error";
    }
  }

  if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    if ($_SESSION['roleId'] == 1) {
      if ( isset($_GET['orderId']) && testInt($_GET['orderId']) ) {
        deleteOpenOrderById($conn, $_GET['orderId']);
      }
    }
  }

  require('../footer.php');
?>