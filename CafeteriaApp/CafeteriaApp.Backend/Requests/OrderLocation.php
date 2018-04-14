<?php
require __DIR__ . '/TestRequestInput.php';
require __DIR__ . '/../Controllers/OrderLocation.php';
require_once __DIR__ . '/../connection.php';
require_once __DIR__ . '/../session.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['orderId']) && testInt($_GET['orderId'])) {
        checkResult(getOrderLocation($conn, $_GET['orderId']));
    } else {
        echo "error";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$data = json_decode( file_get_contents('php://input') );

    if ( isset($data->lat, $data->lng) && is_numeric($data->lat) && is_numeric($data->lng) ) {
    	addOrderLocation($conn, $_SESSION['orderId'], $_SESSION['userId'], $data->lat, $data->lng);
    } else {
        echo "error";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
	$data = json_decode( file_get_contents('php://input') );

    if ( isset($data->lat, $data->lng) && is_numeric($data->lat) && is_numeric($data->lng) ) {
    	updateOrderLocation($conn, $_SESSION['orderId'], $data->lat, $data->lng);
    } else {
        echo "error";
    }
}