<?php require_once('CafeteriaApp.Backend/session.php');

function getClosedOrdersByCustomerId($conn,$id,$backend=false)
{
  if( !isset($id))
  {
    echo "Error: Customer Id is not set";
    return;
  }
  else
  {
    $sql = "select * from `order` where CustomerId = ".$id;
    $result = $conn->query($sql);
    if ($result)
    {
      $orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
      mysqli_free_result($result);
      $orders = json_encode($orders);
      if ($backend)
      {
        return $orders;
      }
      else
      {
        echo $orders;
      }
    }
    else
    {
      echo "Error retrieving orders: " . $conn->error;
    }
  }
}

function getOrderById($conn,$id,$backend=false)
{
  if( !isset($id))
  {
    echo "Error: Order Id is not set";
    return;
  }
  else
  {
    $sql = "select * from `order` where Id = ".$id." LIMIT 1";
    $result = $conn->query($sql);
    if ($result)
    {
      $orders = mysqli_fetch_assoc($result);
      mysqli_free_result($result);
      $orders = json_encode($orders);
      if ($backend)
      {
        return $orders;
      }
      else
      {
        echo $orders;
      }
    }
    else
    {
      echo "Error retrieving order: " . $conn->error;
    }
  }
}

function getOpenOrderByCustomerId($conn,$backend=false)
{
  $openStatusId=1;
  $sql = "select * from `Order` where CustomerId = ".$_SESSION["customerId"]." and OrderStatusId = ".$openStatusId;
  $result = $conn->query($sql);
  if ($result)
  {
    $order = mysqli_fetch_array($result, MYSQLI_ASSOC);
    mysqli_free_result($result);
    $order = json_encode($order);
    if ($backend)
    {
      return $order;
    }
    else
    {
      echo $order;
    }
  }
  else
  {
    echo "Error retrieving Open Order : " . $conn->error;  
  }
}

function calcOpenOrderDeliveryTime($conn,$orderId)
{
  if (!isset($orderId))
  {
    echo "Error: Order Id is not set";
    return;
  }
  else
  { 
    $sql = "select sum(OrderItem.Quantity * MenuItem.ReadyInMins) from OrderItem inner join MenuItem on OrderItem.MenuItemId=MenuItem.Id  where OrderItem.OrderId = " . $orderId;
    $result = $conn->query($sql);
    if ($result)
    {
      $order = mysqli_fetch_array($result, MYSQLI_NUM);
      mysqli_free_result($result);
      // $order = json_encode($order);
      return $order[0];
    }
    else
    {
      echo "Error retrieving Open Order : " . $conn->error;  
    }
  }
}

function getOrdersByDeliveryDateId($conn,$id,$backend=false)
{
  if (!isset($id))
  {
    echo "Error: DeliveryDate Id is not set";
    return;
  }
  else
  {
    $sql = "select * from `order` where DeliveryDateId = ".$id;
    $result = $conn->query($sql);
    if ($result)
    {
      $orders = mysqli_fetch_array($result, MYSQLI_ASSOC);
      mysqli_free_result($result);
      $orders = json_encode($orders);
      if ($backend)
      {
        return $orders;
      }
      else
      {
        echo $orders;
      }
    }
    else
    {
      echo "Error retrieving orders: " . $conn->error;
    }
  }
}

function getOrdersByDeliveryTimeId($conn,$id,$backend=false)
{
  if (!isset($id))
  {
    echo "Error: DeliveryTime Id is not set";
    return;
  }
  else
  {
    $sql = "select * from `order` where DeliveryTimeId = ".$id;
    $result = $conn->query($sql);
    if ($result)
    {
      $orders = mysqli_fetch_array($result, MYSQLI_ASSOC);
      mysqli_free_result($result);
      $orders = json_encode($orders);
      if ($backend)
      {
        return $orders;
      }
      else
      {
        echo $orders;
      }
    }
    else
    {
      echo "Error retrieving orders: " . $conn->error;
    }
  }
}

function getOrdersByOrderStatusId($conn,$id,$backend=false)
{
  if (!isset($id))
  {
    echo "Error: OrderStatus Id is not set";
    return;
  }
  else
  {
    $sql = "select * from `order` where OrderStatusId = ".$id;
    $result = $conn->query($sql);
    if ($result)
    {
      $orders = mysqli_fetch_array($result, MYSQLI_ASSOC);
      mysqli_free_result($result);
      $orders = json_encode($orders);
      if ($backend)
      {
        return $orders;
      }
      else
      {
        echo $orders;
      }
    }
    else
    {
      echo "Error retrieving orders: " . $conn->error;
    }
  }
}

function getOrdersByPaymentMethodId($conn,$id,$backend=false)
{
  if (!isset($id))
  {
    echo "Error: PaymentMethod Id is not set";
    return;
  }
  else
  {
    $sql = "select * from `order` where PaymentMethodId = ".$id;
    $result = $conn->query($sql);
    if ($result)
    {
      $orders = mysqli_fetch_array($result, MYSQLI_ASSOC);
      mysqli_free_result($result);
      $orders = json_encode($orders);
      if ($backend)
      {
        return $orders;
      }
      else
      {
        echo $orders;
      }
    }
    else
    {
      echo "Error retrieving orders: " . $conn->error;
    }
  }
}

function addOrder( $conn,$deliveryDateId, $createdTimeId,$deliveryPlace, $paymentMethodId,$orderStatusId, $customerId,$total=0,$paid=0)
{
  if (!isset($deliveryDateId))
  {
    echo "Error: Order deliveryDateId is not set";
    return;
  }
  elseif (!isset($createdTimeId))
  {
    echo "Error: Order deliveryTimeId is not set";
    return;
  }
  elseif (!isset($deliveryPlace))
  {
    echo "Error: Order deliveryPlace is not set";
    return;
  }
  elseif (!isset($paid))
  {
    echo "Error: Order paid is not set";
    return;
  }
  elseif (!isset($total))
  {
    echo "Error: Order total is not set";
    return;
  }
  elseif (!isset($paymentMethodId))
  {
    echo "Error: Order paymentMethodId is not set";
    return;
  }
  elseif (!isset($orderStatusId))
  {
    echo "Error: Order orderStatusId is not set";
    return;
  }
  elseif (!isset($customerId))
  {
    echo "Error: Order customerId is not set";
    return;
  }
  else
  {
    $sql = "insert into `Order` (DeliveryDateId,DeliveryTimeId,DeliveryPlace,Paid,Total,PaymentMethodId,OrderStatusId,CustomerId) values (?,?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param("iisddiii",$DeliveryDateId, $DeliveryTimeId,$DeliveryPlace, $Paid, $Total, $PaymentMethodId,$OrderStatusId, $CustomerId );
    $DeliveryDateId=$deliveryDateId;
    $DeliveryTimeId=$createdTimeId;
    $DeliveryPlace=$deliveryPlace;
    $Paid=$paid;
    $Total=$total;
    $PaymentMethodId=$paymentMethodId;
    $OrderStatusId=$orderStatusId;
    $CustomerId=$customerId;
    if ($stmt->execute()===TRUE)
    {
      //echo "Order Added successfully";
      return mysqli_insert_id($conn);
    }
    else
    {
      //$error = $conn->errno . ' ' . $conn->error;
      //echo $error;
    }
  }
}

function CheckOutOrder( $conn,$orderId, $deliveryTimeId,$deliveryPlace, $paymentMethodId,$paid=0)
{   
  $closedStatusId=2;
  if (!isset($orderId))
  {
    echo "Error: Order deliveryDateId is not set";
    return;
  }
  elseif (!isset($deliveryTimeId))
  {
    echo "Error: Order deliveryTimeId is not set";
    return;
  }
  elseif (!isset($deliveryPlace))
  {
    echo "Error: Order deliveryPlace is not set";
    return;
  }
  elseif (!isset($paymentMethodId))
  {
    echo "Error: Order paymentMethodId is not set";
    return;
  }
  else
  {
    $sql = "update `Order` set `DeliveryTimeId`=(?) , `DeliveryPlace`=(?) , `Paid`=(?) , `PaymentMethodId`=(?) , `OrderStatusId`=(?) where `Id` =(?) ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isdiii", $DeliveryTimeId,$DeliveryPlace, $Paid, $PaymentMethodId,$OrderStatusId,$OrderId);
    $OrderId=$orderId;
    $DeliveryTimeId=$deliveryTimeId;
    $DeliveryPlace=$deliveryPlace;
    $Paid=$paid;
    $PaymentMethodId=$paymentMethodId;
    $OrderStatusId=$closedStatusId;
    if ($stmt->execute()===TRUE)
    {
      echo "Order Checked Out successfully";
      //return mysqli_insert_id($conn);
    }
    else
    {
      //$error = $conn->errno . ' ' . $conn->error;
      //echo $error;
    }
  }
}

function updateOrderTotalById($conn ,$orderId ,$plusValue)
{
  if (!isset($plusValue))
  {
    echo "Error: Order plusValue is not set";
    return;
  }
  elseif (!isset($orderId))
  {
    echo "Error: order Id  is not set";
    return;
  }
  else
  {
    $sql = "update `Order` set `Total` = `Total`+(?)  where Id = (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("di",$PlusValue,$OrderId);
    $PlusValue = $plusValue ;
    $OrderId = $orderId;
    if ($stmt->execute()===TRUE)
    {
      return "Order Total updated successfully";
    }
    else
    {
      echo "Error: ".$conn->error;
    }
  }
}

function updateOrderPaidById($conn ,$orderId ,$plusValue)
{
  if (!isset($plusValue))
  {
    echo "Error: Order plusValue is not set";
    return;
  }
  elseif (!isset($orderId))
  {
    echo "Error: order Id  is not set";
    return;
  }
  else
  {
    $sql = "update `Order` set `Paid` = `Paid`+(?)  where Id = (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("di",$PlusValue,$OrderId);
    $PlusValue = $plusValue ;
    $OrderId = $orderId;
    if ($stmt->execute()===TRUE)
    {
      return "Order Paid updated successfully";
    }
    else
    {
      echo "Error: ".$conn->error;
    }
  }
}

function deleteOpenOrderById($conn) // remove  order items with cascading
{
  $openStatusId=1;
  //$conn->query("set foreign_key_checks = 0"); // ????????/
  $sql = "delete from `Order` where CustomerId = ". $_SESSION["customerId"] ." and `OrderStatusId`= {$openStatusId}  LIMIT 1";
  if ($conn->query($sql)===TRUE)
  {
    echo "Current Open Order deleted successfully";
  }
  else
  {
    echo "Error: ".$conn->error;
  }
}

?>