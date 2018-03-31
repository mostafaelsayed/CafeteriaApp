<?php
	require(__DIR__.'/TestRequestInput.php');
	require(__DIR__.'/../Controllers/OrderLocation.php');
	require(__DIR__.'/../connection.php');

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