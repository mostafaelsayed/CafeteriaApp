<?php
require __DIR__ . '/../Controllers/Fee.php';
require __DIR__ . '/../connection.php';
require __DIR__ . '/../session.php';
require __DIR__ . '/TestRequestInput.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    //if ($_SESSION['roleId'] == 1) {
    if (isset($_GET['id']) && testInt($_GET['id'])) {
        checkResult(getFeeById($conn, $_GET['id']));
    } else {
        checkResult(getFees($conn));
    }
    //}
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_SESSION['roleId'] == 1) {
        $data = json_decode(file_get_contents('php://input'));

        if (normalizeString($conn, $data->Name) && testPrice($data->Price)) {
            addFee($conn, $data->Name, $data->Price);
        } else {
            echo "error";
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    if ($_SESSION['roleId'] == 1) {
        //decode the json data
        $data = json_decode(file_get_contents('php://input'));

        if (isset($data->Id, $data->Price) && testInt($data->Id) && normalizeString($conn, $data->Name) && testPrice($data->Price)) {
            editFee($conn, $data->Id, $data->Name, $data->Price);
        } else {
            echo "error";
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    if ($_SESSION['roleId'] == 1) {
        if (isset($_GET['feeId']) && testInt($_GET['feeId'])) {
            deleteFee($conn, $_GET['feeId']);
        } else {
            echo "No Id is provided";
        }
    }
}

require '../footer.php';
