<?php
  require('Order.php');
  require('MenuItem.php');

  function getOrderItemsByOrderId($conn, $id) {
    $sql = "select MenuItem.Name, OrderItem.Quantity, OrderItem.TotalPrice, OrderItem.MenuItemId, OrderItem.Id, OrderItem.OrderId from OrderItem INNER JOIN MenuItem ON OrderItem.MenuItemId = MenuItem.Id where OrderItem.OrderId = " . $id;
    $result = $conn->query($sql);

    if ($result) {
      $orderItems = mysqli_fetch_all($result, MYSQLI_ASSOC);
      mysqli_free_result($result);
      return $orderItems;
    }
    else {
      echo "Error retrieving OrderItems : ", $conn->error;
    }
  }

  function getOrderItemById($conn, $id) {
    $sql = "select * from `OrderItem` where `Id` = " . $id . " LIMIT 1";
    $result = $conn->query($sql);
    if ($result) {
      $orderItem = mysqli_fetch_assoc($result);
      mysqli_free_result($result);
      return $orderItem;
    }
    else {
      echo "Error retrieving OrderItem : ", $conn->error;
    }
  }

  function getOrderItemTotalPriceById($conn, $id) {
    $sql = "select `TotalPrice` from `OrderItem` where `Id` = " . $id . " LIMIT 1";

    if ( $result = $conn->query($sql) ) {
      $OrderItem = mysqli_fetch_assoc($result);
      mysqli_free_result($result);
      return $OrderItem['TotalPrice'];
    }
    else {
      echo "Error retrieving Order Item: ", $conn->error;
    }
  }

  function editOrderItemQuantity($conn, $quantity, $id, $increaseDecrease) {
    $MenuItemId = getOrderItemById($conn, $id)['MenuItemId'];
    $unitPrice = getMenuItemPriceById($conn, $MenuItemId);
    $sql = "update `OrderItem` set `Quantity` = (?), `TotalPrice` = `TotalPrice` + (?) where `Id` = (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("idi", $quantity, $unitPrice, $id);

    if ($increaseDecrease === false) {
      $unitPrice = -$unitPrice;
    }

    if ($stmt->execute() === TRUE) {
      return "OrderItem updated successfully";
    }
    else {
      echo "Error: ", $conn->error;
    }
  }

  function addOrderItem($conn, $orderId, $menuItemId, $quantity) {
    $unitPrice = getMenuItemPriceById($conn, $menuItemId);
    $totalPrice  =  $quantity * $unitPrice;

    if ($orderId == null) {
      $deliveryTimeId = getCurrentTimeId($conn);
      $deliveryDateId = getCurrentDateId($conn);
      // create order by default values
      $orderId = addOrder($conn, $deliveryDateId, $deliveryTimeId, 4, 1, $_SESSION['userId']);
    }

    $sql = "insert into `OrderItem` (OrderId, MenuItemId, Quantity, TotalPrice) values (?, ?, ?, ?)"; // add TotalPrice to total of the order
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiid", $orderId, $menuItemId, $quantity, $totalPrice);
    
    if ($stmt->execute() === TRUE) {
      //echo "OrderItem Added successfully";
      return $orderId;
    }
    else {
      echo "Error: ", $conn->error;
    }
  }

  function deleteOrderItem($conn, $id) { // remove TotalPrice to total of the order
    $totalPrice = getOrderItemTotalPriceById($conn, $id);
    updateOrderTotalById($conn, $_SESSION['orderId'], -$totalPrice);
    $sql = "delete from `OrderItem` where `Id` = " . $id . " LIMIT 1";

    if ($conn->query($sql) === TRUE) {
      echo "Order Item deleted successfully";
    }
    else {
      echo "Error: ", $conn->error;
    }
  }

  function deleteOrderItemsByMenuItemId($conn, $id) { // remove TotalPrice to total of the order
      $sql = "delete from `OrderItem` where `MenuItemId` = " . $id;

      if ($conn->query($sql) === TRUE) {
        return "Order Item deleted successfully";
      }
      else {
        echo "Error: ", $conn->error;
      }
  }

  function editOrderItemTotalPrice($conn, $totalPrice, $id) {
    $sql = "update `OrderItem` set `TotalPrice` = (?) where `Id` = (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("di", $totalPrice, $id);

    if ($stmt->execute() === TRUE) {
      return "OrderItem updated successfully";
    }
    else {
      echo "Error: ", $conn->error;
    }
  }
?>