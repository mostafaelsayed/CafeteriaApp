<?php

require_once('CafeteriaApp.Backend/session.php');
require_once('CafeteriaApp.Backend/connection.php');
require_once("CafeteriaApp.Backend/Controllers/Dates.php");

require_once("CafeteriaApp.Backend/Controllers/Times.php");
require_once('PayPal/start.php');

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Exception\PayPalConnectionException;

function getClosedOrdersByUserId($conn,$id)
{
  if( !isset($id))
  {
    //echo "Error: Customer Id is not set";
    return;
  }
  else
  {
    $sql = "select * from `order` where UserId = ".$id;
    $result = $conn->query($sql);
    if ($result)
    {
      $orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
      mysqli_free_result($result);
      
        return $orders;
    }
    else
    {
      echo "Error retrieving orders: " . $conn->error;
    }
  }
}

function getOrderById($conn,$id)
{
  if( !isset($id))
  {
    //echo "Error: Order Id is not set";
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
        return $orders;
      
    }
    else
    {
      echo "Error retrieving order: " . $conn->error;
    }
  }
}

function getOpenOrderByUserId($conn)
{
  $openStatusId=1;
  $sql = "select * from `Order` where UserId = ".$_SESSION["userId"]." and OrderStatusId = ".$openStatusId;
  $result = $conn->query($sql);
  if ($result)
  {
    $order = mysqli_fetch_array($result, MYSQLI_ASSOC);
    mysqli_free_result($result);
      return $order;
    
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
   // echo "Error: Order Id is not set";
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

function getOrdersByDeliveryDateId($conn,$id)
{
  if (!isset($id))
  {
    //echo "Error: DeliveryDate Id is not set";
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
        return $orders;
      
    }
    else
    {
      echo "Error retrieving orders: " . $conn->error;
    }
  }
}

function getOrdersByDeliveryTimeId($conn,$id)
{
  if (!isset($id))
  {
    //echo "Error: DeliveryTime Id is not set";
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
        return $orders;
     
    }
    else
    {
      echo "Error retrieving orders: " . $conn->error;
    }
  }
}

function getOrders($conn)
{
  $sql = "select * from `order`";
  $result = $conn->query($sql);
  if ($result)
  {
    $orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);
    return $orders;
  }
  else
  {
    echo "Error retrieving orders: " . $conn->error;
  }
}

function getOrdersByOrderStatusId($conn,$id)
{
  if (!isset($id))
  {
    //echo "Error: OrderStatus Id is not set";
    return;
  }
  else
  {
    $sql = "select * from `order` where OrderStatusId = ".$id;
    $result = $conn->query($sql);
    if ($result)
    {
      $orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
      mysqli_free_result($result);
        return $orders;
      
    }
    else
    {
      echo "Error retrieving orders: " . $conn->error;
    }
  }
}

function getOrdersByPaymentMethodId($conn,$id)
{
  if (!isset($id))
  {
    //echo "Error: PaymentMethod Id is not set";
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
        return $orders;
      
    }
    else
    {
      echo "Error retrieving orders: " . $conn->error;
    }
  }
}

function addOrder( $conn,$deliveryDateId, $createdTimeId,$deliveryPlace, $paymentMethodId,$orderStatusId, $userId,$total=0,$paid=0)
{
  if (!isset($deliveryDateId))
  {
    //echo "Error: Order deliveryDateId is not set";
    return;
  }
  elseif (!isset($createdTimeId))
  {
    //echo "Error: Order deliveryTimeId is not set";
    return;
  }
  elseif (!isset($deliveryPlace))
  {
    //echo "Error: Order deliveryPlace is not set";
    return;
  }
  elseif (!isset($paid))
  {
    //echo "Error: Order paid is not set";
    return;
  }
  elseif (!isset($total))
  {
    //echo "Error: Order total is not set";
    return;
  }
  elseif (!isset($paymentMethodId))
  {
    //echo "Error: Order paymentMethodId is not set";
    return;
  }
  elseif (!isset($orderStatusId))
  {
    //echo "Error: Order orderStatusId is not set";
    return;
  }
  elseif (!isset($userId))
  {
   // echo "Error: Order customerId is not set";
    return;
  }
  else
  {
    $sql = "insert into `Order` (DeliveryDateId,DeliveryTimeId,DeliveryPlace,Paid,Total,PaymentMethodId,OrderStatusId,UserId) values (?,?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);

    $stmt->bind_param("iisddiii",$DeliveryDateId, $DeliveryTimeId,$DeliveryPlace, $Paid, $Total, $PaymentMethodId,$OrderStatusId, $UserId );
    $DeliveryDateId=$deliveryDateId;
    $DeliveryTimeId=$createdTimeId;
    $DeliveryPlace=$deliveryPlace;
    $Paid=$paid;
    $Total=$total;
    $PaymentMethodId=$paymentMethodId;
    $OrderStatusId=$orderStatusId;
    $UserId=$userId;
    if ($stmt->execute()===TRUE)
    {
      //echo "Order Added successfully";
      return mysqli_insert_id($conn);
    }
    else
    {
      echo "Error adding order: " . $conn->error;
      //echo $error;
    }
  }
}

function CheckOutOrder( $conn,$orderId, $deliveryTimeId,$deliveryPlace, $paymentMethodId,$paid=0)
{   
  $closedStatusId=2;
  if (!isset($orderId))
  {
    //echo "Error: Order deliveryDateId is not set";
    return;
  }
  elseif (!isset($deliveryTimeId))
  {
   // echo "Error: Order deliveryTimeId is not set";
    return;
  }
  elseif (!isset($deliveryPlace))
  {
    //echo "Error: Order deliveryPlace is not set";
    return;
  }
  elseif (!isset($paymentMethodId))
  {
    //echo "Error: Order paymentMethodId is not set";
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
      //open a new order
      $deliveryTimeId = getCurrentTimeId($conn);
      $deliveryDateId = getCurrentDateId($conn);
      $_SESSION["orderId"] = addOrder($conn,$deliveryDateId,$deliveryTimeId,'',1,1, $_SESSION["userId"],0,0);
      return true;

      //return mysqli_insert_id($conn);
    }
    else
    {
      echo "Error checkout order: " . $conn->error;
      //echo $error;
    }
  }
}

function updateOrderTotalById($conn ,$orderId ,$plusValue)
{
  if (!isset($plusValue))
  {
    //echo "Error: Order plusValue is not set";
    return;
  }
  elseif (!isset($orderId))
  {
    //echo "Error: order Id  is not set";
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
    //echo "Error: Order plusValue is not set";
    return;
  }
  elseif (!isset($orderId))
  {
    //echo "Error: order Id  is not set";
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
  $sql = "delete from `Order` where UserId = ". $_SESSION["userId"] ." and `OrderStatusId`= {$openStatusId}  LIMIT 1";
  if ($conn->query($sql)===TRUE)
  {
    return "Current Open Order deleted successfully";
  }
  else
  {
    echo "Error: ".$conn->error;
  }
}



function calcAndUpdateOrderTotalById($conn ,$orderId)
{
  if (!isset($orderId))
  {
    //echo "Error: order Id  is not set";
    return;
  }
  else
  {
    $sql = "update `Order` set `Total`= IFNULL((select sum(TotalPrice) from `OrderItem` where OrderId ={$orderId}), 0) where Id={$orderId}";
    $result = $conn->query($sql);
    if ($result===TRUE)
    {
      return "Order Total updated successfully";
    }
    else
    {
      echo "Error: ".$conn->error;
    }
  }
}

function getOrderDetails($conn,$orderId)
{
  $orderDetailsStatment = "select MenuItem.Name , MenuItem.Price , OrderItem.Quantity , OrderItem.TotalPrice , Order.Total from `OrderItem` inner join MenuItem on MenuItem.Id = OrderItem.MenuItemId inner join `Order` on Order.Id = OrderItem.OrderId where OrderItem.OrderId = " . $orderId;
  $result = $conn->query($orderDetailsStatment);
  $orderDetails = mysqli_fetch_all($result);
  mysqli_free_result($result);
  return $orderDetails;
}

function processPayment($conn,$orderId,$selectedMethodId,$deliveryPlace,$deliveryTimeId,$apiContext)
{
  $orderDetails = getOrderDetails($conn,$orderId);

  //print_r($orderDetails);
  if ($selectedMethodId == 2) // paypal payment
  {
    $itemList = new ItemList();

    foreach ($orderDetails as $orderItem)
    {
      $item = new Item();
      $item->setName($orderItem[0])->setCurrency('GBP')->setQuantity($orderItem[2])->setPrice($orderItem[1]);
      $itemList->addItem($item);
    }

    // determine shipping and tax later from frontend
    $shippingResult = $conn->query("select Price from fees where Id = " . 2); // id of shipping fee
    $shipping = mysqli_fetch_assoc($shippingResult)['Price'];
    mysqli_free_result($shippingResult);

    $taxResult = $conn->query("select Price from fees where Id = " . 3); // id of tax fee
    $tax = mysqli_fetch_assoc($taxResult)['Price'];
    mysqli_free_result($taxResult);

    // other fees goes here .. 

    $details = new Details();
    $details->setShipping($shipping)
    ->setTax($tax)
    ->setSubtotal($orderDetails[0][4]);

    // Set redirect urls
    $redirectUrls = new RedirectUrls();
    $redirectUrls->setReturnUrl(SITE_URL . '/CafeteriaApp.Frontend/Areas/Customer/review_order_and_charge_customer.php?orderId=' . $orderId . '&deliveryPlace=' . $deliveryPlace . '&paymentMethodId=' . $selectedMethodId . '&deliveryTimeId=' . $deliveryTimeId)
    ->setCancelUrl(SITE_URL . '/CafeteriaApp.Frontend/Areas/Customer/checkout.php?orderId=' . $orderId . '&deliveryPlace=' . $deliveryPlace . '&paymentMethodId=' . $selectedMethodId . '&deliveryTimeId=' . $deliveryTimeId);

    // Set payment amount
    $amount = new Amount();
    $amount->setCurrency('GBP')->setTotal($orderDetails[0][4]
      + $shipping + $tax)->setDetails($details);

    // Set transaction object
    $transaction = new Transaction();
    $transaction->setAmount($amount)
    ->setDescription('Payment done')
    ->setItemList($itemList);

    // Set payer
    $payer = new Payer();
    $payer->setPaymentMethod('paypal'); // maybe determine this from frontend too

    // Create the full payment object
    $payment = new Payment();
    $payment->setIntent('sale')->setPayer($payer)->setRedirectUrls($redirectUrls)->setTransactions([$transaction]);

    try
    {
      $payment->create($apiContext);
      // CheckOutOrder($conn,$data->orderId,$data->deliveryTimeId ,$data->deliveryPlace,$data->paymentMethodId , $data->paid );
    }

    catch (PayPalConnectionException $ex)
    {
      echo $ex->getData();
      die($ex);
    }

    $approvalUrl = $payment->getApprovalLink();

    header("Location: " . $approvalUrl);

  }

}

//processPayment($conn,10,2,"ay7atta",5,1,$paypal);

?>