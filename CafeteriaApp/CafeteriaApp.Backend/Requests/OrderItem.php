<?php
  require(__DIR__ . '/../Controllers/OrderItem.php');
  require(__DIR__ . '/TestRequestInput.php');

  if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if ( isset($_GET['orderId']) && testInt($_GET['orderId']) ) // cashier only
      checkResult( getOrderItemsByOrderId($conn, $_GET['orderId']) );
  }

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //decode the json data
    $data = json_decode( file_get_contents('php://input') );

    if ( isset($data->OrderId, $data->MenuItemId, $data->Quantity) && testInt($data->OrderId, $data->MenuItemId, $data->Quantity) ) {
      $orderId = addOrderItem($conn, $data->OrderId, $data->MenuItemId, $data->Quantity);

      if ( !empty($orderId) )
        echo $orderId;
    }
    else {
      echo 'error';
    }
  }

  if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    //decode the json data
    $data = json_decode( file_get_contents('php://input') );
    
    if ( isset($data->Id, $data->Quantity) && testInt($data->Id, $data->Quantity) )
      editOrderItemQuantity($conn, $data->Quantity, $data->Id, $data->Flag);
  }

  if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    if ( isset($_GET['id']) && testInt($_GET['id']) ) {
      deleteOrderItem($conn, $_GET['id']);
    }
  }

  require('../footer.php');
?>