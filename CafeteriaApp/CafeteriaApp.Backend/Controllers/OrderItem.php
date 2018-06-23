<?php
  require(__DIR__ . '/Order.php');
  require(__DIR__ . '/MenuItem.php');

  function getOrderItemsByOrderId($conn, $id) {
    $sql = "select `menuitem`.`Name`, `orderitem`.`Quantity`, `orderitem`.`MenuItemId`, `orderitem`.`Id`, `orderitem`.`OrderId`, `orderitem`.`Quantity` * `menuitem`.`price` as TotalPrice from `orderitem` INNER JOIN `menuitem` ON `orderitem`.`MenuItemId` = `menuitem`.`Id` where `orderitem`.`OrderId` = " . $id;
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
    $sql = "select * from `orderitem` where `Id` = " . $id . " LIMIT 1";
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

  function editOrderItemQuantity($conn, $quantity, $id) {
    $sql = "update `orderitem` set `Quantity` = (?) where `Id` = (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $quantity, $id);

    if ($stmt->execute() === TRUE) {
      return "OrderItem updated successfully";
    }
    else {
      echo "Error: ", $conn->error;
    }
  }

  function addOrderItem($conn, $orderId, $menuItemId, $quantity) {
    if ($orderId == null) {
      $orderId = addOrder($conn, date('Y-m-d h:m'), 4, 1, $_SESSION['userId']);
    }

    $sql = "insert into `orderitem` (OrderId, MenuItemId, Quantity) values (?, ?, ?)"; // add TotalPrice to total of the order
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $orderId, $menuItemId, $quantity);
    
    if ($stmt->execute() === TRUE) {
      //echo "OrderItem Added successfully";
      return $orderId;
    }
    else {
      echo "Error: ", $conn->error;
    }
  }

  function deleteOrderItem($conn, $id) {
    $sql = "delete from `orderitem` where `Id` = " . $id . " LIMIT 1";

    if ($conn->query($sql) === TRUE) {
      echo "Order Item deleted successfully";
    }
    else {
      echo "Error: ", $conn->error;
    }
  }

  function deleteOrderItemsByMenuItemId($conn, $id) {
      $sql = "delete from `orderitem` where `MenuItemId` = " . $id;

      if ($conn->query($sql) === TRUE) {
        return "Order Item deleted successfully";
      }
      else {
        echo "Error: ", $conn->error;
      }
  }
?>