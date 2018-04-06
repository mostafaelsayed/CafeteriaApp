<?php    
  require_once(__DIR__ . '/../session.php');
  require_once(__DIR__ . '/../connection.php');
  require(__DIR__ . '/payment-methods.php');

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
    $sql = "select sum(orderitem.Quantity * menuitem.ReadyInMins) from `orderitem` inner join `menuitem` on orderitem.MenuItemId = menuitem.Id where orderitem.OrderId = " . $orderId;
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
    $sql = "insert into `order` (DeliveryTime, Paid, Total, PaymentMethodId, OrderStatusId, UserId) values (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sddiii", $deliveryTime, $paid, $total, $paymentMethodId, $orderStatusId, $userId);

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
    $deliveryTimeId = date("Y-m-d h:m");
    $sql = "update `order` set `DeliveryTime` = (?), `Paid` = (?), `PaymentMethodId` = (?), `OrderStatusId` = 2 where `Id` = (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdii", $deliveryTimeId, $paid, $paymentMethodId, $orderId);

    if ($stmt->execute() === TRUE) {
      //open a new order
      $deliveryTimeId = date("Y-m-d h:m");
      $_SESSION['orderId'] = addOrder($conn, $deliveryTimeId, 1, 1, $_SESSION['userId']);
      return true;
    }
    else {
      echo "Error checkout order: ", $conn->error;
    }
  }

  function updateWithFee($conn, $orderType, $selectedMethodId) {
    $fees = getFees($conn);

    if ( $orderType == 1) { // paypal or credit and delivery
      updateOrderTotalById($conn, $_SESSION['orderId'], $fees[0]['Price'] + $fees[1]['Price'] + $fees[2]['Price']);
    }
    elseif ( ($selectedMethodId == 1 || $selectedMethodId == 5) && $orderType == 0) { // paypal or credit and delivery
      updateOrderTotalById($conn, $_SESSION['orderId'], $fees[1]['Price'] + $fees[2]['Price']);
    }
    elseif ( $selectedMethodId == 4 && $orderType == 0) { // tax
      updateOrderTotalById($conn, $_SESSION['orderId'], $fees[2]['Price']);
    }
  }

  function updateOrderTotalById($conn, $orderId, $plusValue) {
    $sql = "update `order` set `Total` = `Total` + (?) where `Id` = (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("di", $plusValue, $orderId);

    if ($stmt->execute() === TRUE) {
      return "Order Total updated successfully";
    }
    else {
      echo "Error: ", $conn->error;
    }
  }

  function updateOrderPaidById($conn, $orderId, $plusValue) {
    $sql = "update `order` set `Paid` = `Paid` + (?) where Id = (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("di", $plusValue, $orderId);
    
    if ($stmt->execute() === TRUE) {
      return "Order Paid updated successfully";
    }
    else {
      echo "Error: ", $conn->error;
    }
  }

  function deleteOpenOrderById($conn) { // remove order items with cascading
    //$conn->query("set foreign_key_checks = 0"); // ????????/
    $sql = "delete from `order` where `UserId` = ". $_SESSION['userId'] . " and `OrderStatusId` = 1 LIMIT 1";

    if ($conn->query($sql) === TRUE) {
      return "Current Open Order deleted successfully";
    }
    else {
      echo "Error: ", $conn->error;
    }
  }

  function calcAndUpdateOrderTotalById($conn, $orderId) {
    $sql = "update `order` set `Total` = IFNULL( (select sum(TotalPrice) from `orderitem` where `OrderId` = {$orderId}), 0) where `Id` = {$orderId}";
    $result = $conn->query($sql);

    if ($result === TRUE) {
      return "Order Total updated successfully";
    }
    else {
      echo "Error: ", $conn->error;
    }
  }

  function getOrderItems($conn, $orderId) {
    $orderItemsStatment = "select menuitem.Name, menuitem.Price, orderitem.Quantity, orderitem.TotalPrice, order.Total from `orderitem` inner join `menuitem` on menuitem.Id = orderitem.MenuItemId inner join `order` on order.Id = orderitem.OrderId where orderitem.OrderId = " . $orderId;
    $result = $conn->query($orderItemsStatment);

    if ($result) {
      $orderItems = mysqli_fetch_all($result);
      mysqli_free_result($result);
      return $orderItems;
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

  function chargeCustomer($paymentId, $payerId, $orderId, $selectedMethodId, $conn) {
    if ($selectedMethodId == 1) {// paypal
      mypaypal::chargeCustomer($paymentId, $payerId, $orderId, $selectedMethodId, $conn);
    }
  }