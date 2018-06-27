<?php
require __DIR__ . '/../connection.php';
require __DIR__ . '/../Controllers/Cashier.php';
require __DIR__ . '/TestRequestInput.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'));

    if (isset($data->UserId) && testInt($data->UserId)) {
        addCashier($conn, $data->UserId);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    if (isset($_GET['userId']) && testInt($_GET['userId'])) {
        deleteCashierByUserId($conn, $_GET['userId']);
    }
}

require '../footer.php';