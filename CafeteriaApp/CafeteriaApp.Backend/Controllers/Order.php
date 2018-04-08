<?php    
  require_once(__DIR__ . '/../session.php');
  require_once(__DIR__ . '/../connection.php');
  require(__DIR__ . '/payment-methods.php');
  //var_dump($_SERVER);

  function generateBrainTreeToken() {
    echo mybraintree::brainTreeConfig()->clientToken()->generate();
  }

  function getOrderById($conn, $id) {
    $sql = "select `Id`, `UserId`, `Total`, `Type` from `order` where `Id` = " . $id . " LIMIT 1";
    $result = $conn->query($sql);
    
    if ($result) {
      $order = mysqli_fetch_assoc($result);
      mysqli_free_result($result);
      return $order;
    }
    else {
      echo "Error retrieving order: ", $conn->error;
    }
  }

  function getOpenOrderByUserId($conn) {
    $sql = "select * from `order` where `UserId` = " . $_SESSION['userId'] . " and `OrderStatusId` = 1";
    $result = $conn->query($sql);

    if ($result) {
      $order = mysqli_fetch_array($result, MYSQLI_ASSOC);
      mysqli_free_result($result);
      return $order;
    }
    else {
      echo "Error retrieving Open Order : ", $conn->error;  
    }
  }

  function calcOpenOrderDeliveryTime($conn, $orderId) {
    $sql = "select sum(`orderitem`.`Quantity` * `menuitem`.`ReadyInMins`) from `orderitem` inner join `menuitem` on `orderitem`.`MenuItemId` = `menuitem`.`Id` where `orderitem`.`OrderId` = " . $orderId;
    $result = $conn->query($sql);

    if ($result) {
      $order = mysqli_fetch_array($result, MYSQLI_NUM);
      mysqli_free_result($result);
      return $order[0];
    }
    else {
      echo "Error retrieving Open Order : ", $conn->error;  
    }
  }

  function getOrders($conn) {
    $sql = "select * from `order`";
    $result = $conn->query($sql);

    if ($result) {
      $orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
      mysqli_free_result($result);
      return $orders;
    }
    else {
      echo "Error retrieving orders: ", $conn->error;
    }
  }

  function updateOrderIdInSession($conn, $orderId) {
    $_SESSION['orderId'] = $orderId;
  }

  function updateOrderTypeAndTotal($conn, $orderType) {
    $r = $conn->query("select `Price` from `fees` where `Name` = 'Delivery'");

    if (!$r) {
      die($conn->error);
    }

    $deliveryFee = mysqli_fetch_assoc($r)['Price'];
    $f = 0;

    if ($orderType == 0) { // take away
      $f = -$deliveryFee;
      $deliveryFee = 0;

      //$total -= $deliveryFee;
      //$deliveryFee = 0;
    }
    elseif ($orderType == 1) { // delivery
      $f = $deliveryFee;
      //$total += $deliveryFee;
    }

    $res = $conn->query("update `order` set `Total` = `Total` + {$f}, `Type` = '{$orderType}', `DeliveryFee` = '{$deliveryFee}' where `Id` = {$_SESSION['orderId']}");

    if (!$res) {
      die($conn->error);
    }

    if ($orderType == 1) {
      return $deliveryFee;
    }
  }

  function updateOrderLocation($conn, $locationId) {
    $sql = "select `OrderId` from `orderlocation` where `OrderId` = {$_SESSION['orderId']}";
    $res = $conn->query($sql);

    if ($res === false) {
      echo "error: ", $conn->error;
    }
    else if (mysqli_num_rows($res) !== 0) {
      $stmt = "update `orderlocation` set `LocationId` = (?) where `OrderId` = {$_SESSION['orderId']}";
      $stmt = $conn->prepare($stmt);
      $stmt->bind_param("i", $locationId);

      if ($stmt->execute() === true) {
        echo "Location updated";
      }
      else {
        echo "error: ", $conn->error;
      }
    }
    else {
      $stmt = "insert into `orderlocation` (OrderId, LocationId) values (?, ?)";
      $stmt = $conn->prepare($stmt);
      $stmt->bind_param("ii", $_SESSION['orderId'], $locationId);

      if ($stmt->execute() === true) {
        echo "Location updated";
      }
      else {
        echo "error: ", $conn->error;
      }
    }
  }

  function addOrder($conn, $deliveryTime, $paymentMethodId, $orderStatusId, $userId, $total = 0, $paid = 0) {
    $sql = "insert into `order` (`DeliveryTime`, `Paid`, `Total`, `PaymentMethodId`, `OrderStatusId`, `UserId`, `TaxFee`) values (?, ?, ?, ?, ?, ?, ?)";
    $taxFee = mysqli_fetch_assoc($conn->query("select `Price` from `fees` where `Name` = 'Tax'"))['Price'];
    $total += $taxFee;
    // $deliveryFee = mysqli_fetch_assoc($conn->query("select `Price` from `fees` where `Name` = 'Delivery'"))['Delivery'];
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sddiiid", $deliveryTime, $paid, $total, $paymentMethodId, $orderStatusId, $userId, $taxFee);

    if ($stmt->execute() === TRUE) {
      //echo "Order Added successfully";
      return mysqli_insert_id($conn);
    }
    else {
      die($conn->error);
    }
  }

  function hideOrder($conn, $orderId) {
    $sql = "update `order` set `Visible` = 0, `OrderStatusId` = 2 where `Id` = " . $orderId;
    $sql = $conn->query($sql);

    if ($sql) {
      echo "order hided";
    }
    else {
      echo "error: ", $conn->error;
    }
  }

  function CheckOutOrder($conn, $orderId, $paymentMethodId, $paid = 0) {
    $deliveryTime = date("Y-m-d h:m");
    $sql = "update `order` set `DeliveryTime` = (?), `Paid` = (?), `PaymentMethodId` = (?), `OrderStatusId` = 2 where `Id` = (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdii", $deliveryTime, $paid, $paymentMethodId, $orderId);

    if ($stmt->execute() === TRUE) {
      //open a new order
      $deliveryTime = date("Y-m-d h:m");
      $_SESSION['orderId'] = addOrder($conn, $deliveryTime, 1, 1, $_SESSION['userId']);
      return true;
    }
    else {
      echo "Error checkout order: ", $conn->error;
    }
  }

  // function updateOrderTypeAndTotal($conn, $orderType) {
  //   $fee = 0;

  //   if ($orderType == 1) {
  //     $fees = getFees($conn);
  //   }
  // }

  // function updateWithFee($conn, $orderType, $selectedMethodId) {
  //   $fees = getFees($conn);

  //   if ( $orderType == 1) { // paypal or credit and delivery
  //     updateOrderTotalById($conn, $_SESSION['orderId'], $fees[0]['Price'] + $fees[1]['Price'] + $fees[2]['Price']);
  //   }
  //   elseif ( ($selectedMethodId == 1 || $selectedMethodId == 5) && $orderType == 0) { // paypal or credit and delivery
  //     updateOrderTotalById($conn, $_SESSION['orderId'], $fees[1]['Price'] + $fees[2]['Price']);
  //   }
  //   elseif ( $selectedMethodId == 4 && $orderType == 0) { // tax
  //     updateOrderTotalById($conn, $_SESSION['orderId'], $fees[2]['Price']);
  //   }
  // }

  function deleteOpenOrderById($conn) { // remove order items with cascading
    //$conn->query("set foreign_key_checks = 0"); // ????????/
    $sql = "delete from `order` where `UserId` = " . $_SESSION['userId'] . " and `OrderStatusId` = 1 LIMIT 1";

    if ($conn->query($sql) === TRUE) {
      return "Current Open Order deleted successfully";
    }
    else {
      echo "Error: ", $conn->error;
    }
  }

  function getOrderItems($conn, $orderId) {
    $orderItemsStatment = "select `menuitem`.`Name`, `menuitem`.`Price`, `orderitem`.`Quantity`, `orderitem`.`Quantity` * `menuitem`.`Price` as TotalPrice from `orderitem` inner join `menuitem` on `menuitem`.`Id` = `orderitem`.`MenuItemId` inner join `order` on `order`.`Id` = `orderitem`.`OrderId` where `orderitem`.`OrderId` = " . $orderId;
    $orderFeesAndTotalStmt = "select `order`.`Total`, `order`.`DeliveryFee`, `order`.`TaxFee` from `order` where `id` = {$_SESSION['orderId']}";
    $result = $conn->query($orderItemsStatment);
    $orderResult = $conn->query($orderFeesAndTotalStmt);
    $orderDetails = mysqli_fetch_assoc($orderResult);
    //die(var_dump($orderDetails));
    $orderItems = [];

    if ($result) {
      while($row = mysqli_fetch_assoc($result)) {
        array_push($orderItems, $row);
      }
      //$orderItems = $items[0];

      mysqli_free_result($result);

      return [$orderDetails, $orderItems];
    }
    else {
      echo "error : ", $conn->error;
    }
    
  }

  function processPayment($conn, $orderId, $selectedMethodId, $orderType) {
    if ($selectedMethodId == 1) { // paypal payment
      //$paypal = new mypaypal();
      mypaypal::handlePaypal($conn, $orderId, $orderType, $selectedMethodId);
      //$payer->setPaymentMethod('paypal'); // maybe determine this from frontend too
    }
    elseif ($selectedMethodId == 2) { // braintree
      mybraintree::handleBrainTree($conn, $orderId, $orderType, $selectedMethodId);
    }
    else {
      //$payer->setPaymentMethod('credit_card');
    }
  }

  function chargeCustomer($paymentId, $payerId, $orderId, $orderType, $selectedMethodId, $conn) {
    if ($selectedMethodId == 1) { // paypal
      mypaypal::chargeCustomer($paymentId, $payerId, $orderId, $orderType, $selectedMethodId, $conn);
    }
  }