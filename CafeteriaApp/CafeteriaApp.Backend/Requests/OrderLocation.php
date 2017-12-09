<?php
require('TestRequestInput.php');
require('CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Controllers/OrderLocation.php');
require('CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/connection.php');

//var_dump($_SERVER);

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  if ( isset( $_GET['orderId'] ) && test_int( $_GET['orderId'] ) ) {
    checkResult( getOrderLocation( $conn, $_GET['orderId'] ) );
  }
  else {
    echo "error";
  }
}
?>