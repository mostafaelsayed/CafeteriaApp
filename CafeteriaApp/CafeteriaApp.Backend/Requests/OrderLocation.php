<?php
	require('TestRequestInput.php');
	require('../Controllers/OrderLocation.php');
	require('../connection.php');

	//var_dump($_SERVER);

	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	  if ( isset($_GET['orderId']) && test_int($_GET['orderId']) ) {
	    checkResult( getOrderLocation($conn, $_GET['orderId']) );
	  }
	  else {
	    echo "error";
	  }
	}
?>