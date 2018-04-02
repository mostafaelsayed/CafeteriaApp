<?php    
  require_once(__DIR__ . '/../session.php');
  require_once(__DIR__ . '/../connection.php');
  //require_once('/storage/ssd4/737/5099737/public_html/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/session.php');
  //require_once('/storage/ssd4/737/5099737/public_html/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/connection.php');
  
  require(__DIR__ . '/Dates.php');
  require(__DIR__ . '/Times.php');
  require(__DIR__ . '/../paypal/start.php');

  use PayPal\Api\Amount;
  use PayPal\Api\Details;
  use PayPal\Api\Item;
  use PayPal\Api\ItemList;
  use PayPal\Api\Payer;
  use PayPal\Api\Payment;
  use PayPal\Api\RedirectUrls;
  use PayPal\Api\Transaction;
  use PayPal\Exception\PayPalConnectionException;

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

  function addOrder($conn, $deliveryDateId, $createdTimeId, $paymentMethodId, $orderStatusId, $userId, $total = 0, $paid = 0) {
    $sql = "insert into `order` (DeliveryDateId, DeliveryTimeId, Paid, Total, PaymentMethodId, OrderStatusId, UserId) values (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiddiii", $deliveryDateId, $createdTimeId, $paid, $total, $paymentMethodId, $orderStatusId, $userId);

    if ($stmt->execute() === TRUE) {
      //echo "Order Added successfully";
      return mysqli_insert_id($conn);
    }
    else {
      echo "Error adding order: ", $conn->error;
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
    $deliveryTimeId = getCurrentTimeId($conn);
    $sql = "update `order` set `DeliveryTimeId` = (?), `Paid` = (?), `PaymentMethodId` = (?), `OrderStatusId` = 2 where `Id` = (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("idii", $deliveryTimeId, $paid, $paymentMethodId, $orderId);

    if ($stmt->execute() === TRUE) {
      //open a new order
      $deliveryDateId = getCurrentDateId($conn);
      $_SESSION['orderId'] = addOrder($conn, $deliveryDateId, $deliveryTimeId, 1, 1, $_SESSION['userId']);
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

  function processPayment($conn, $orderId, $selectedMethodId, $apiContext, $orderType) {
    $orderItems = getOrderItems($conn, $orderId);
    $itemList = new ItemList();
    $item = new Item();
    $item->setCurrency('GBP'); // or USD or any other currency

    foreach ($orderItems as $orderItem) {
      //var_dump($orderItem);
      $item->setName($orderItem[0])
        ->setQuantity($orderItem[2])
        ->setPrice($orderItem[1]);
      $itemList->addItem($item);
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
      ->setSubtotal($orderItems[0][4]);

      //var_dump($orderItems[0][4]);
      //var_dump($shipping);
      var_dump($details);

    // Set redirect urls
    $redirectUrls = new RedirectUrls();
    $redirectUrls->setReturnUrl(SITE_URL . '/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Customer/review_order_and_charge_customer.php?orderId=' . $orderId . '&paymentMethodId=' . $selectedMethodId . '&orderType=' . $orderType)
      ->setCancelUrl(SITE_URL . '/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Customer/checkout.php?orderId=' . $orderId . '&paymentMethodId=' . $selectedMethodId);

    // Set payment amount
    $amount = new Amount();
    $amount->setCurrency('GBP')
      ->setTotal($orderItems[0][4] + $shipping + $tax)
      ->setDetails($details);

      //var_dump($amount);
      //var_dump($itemList);

    // Set transaction object
    $transaction = new Transaction();
    $transaction->setAmount($amount)
      ->setDescription('Payment done')
      ->setItemList($itemList);

    // Set payer
    $payer = new Payer();

    if ($selectedMethodId == 1) { // paypal payment
      $payer->setPaymentMethod('paypal'); // maybe determine this from frontend too
    }
    else {
      $payer->setPaymentMethod('credit_card');
    }

    // Create the full payment object
    $payment = new Payment();
    $payment->setIntent('sale')
      ->setPayer($payer)
      ->setRedirectUrls($redirectUrls)
      ->setTransactions([$transaction]);

    //var_dump($payment);

    try {
      $payment->create($apiContext);
    }
    catch (PayPalConnectionException $ex) {
      echo $ex->getData();
      die($ex);
    }

    $approvalUrl = $payment->getApprovalLink();
    header("Location: " . $approvalUrl);
  }
?>