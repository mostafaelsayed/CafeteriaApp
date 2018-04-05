<?php
require __DIR__ . '/TestRequestInput.php';
require __DIR__ . '/../Controllers/OrderLocation.php';
require __DIR__ . '/../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['orderId']) && testInt($_GET['orderId'])) {
        checkResult(getOrderLocation($conn, $_GET['orderId']));
    } else {
        echo "error";
    }
}
