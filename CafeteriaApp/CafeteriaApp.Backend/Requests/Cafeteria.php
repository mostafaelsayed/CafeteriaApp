<?php
require __DIR__ . '/../Controllers/Cafeteria.php';
require __DIR__ . '/../connection.php';
require __DIR__ . '/../session.php';
require __DIR__ . '/TestRequestInput.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['id']) && testInt($_GET['id']) && $_SESSION['roleId'] == 1) {
        checkResult(getCafeteriaById($conn, $_GET['id']));
    } else {
        checkResult(getCafeterias($conn));
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_SESSION['roleId'] == 1) {
        $data = json_decode(file_get_contents('php://input'));

        if (normalizeString($conn, $data->Name, $data->Image)) {
            addCafeteria($conn, $data->Name, $data->Image);
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    if ($_SESSION['roleId'] == 1) {
        //decode the json data
        $data = json_decode(file_get_contents('php://input'));

        if (isset($data->Id) && testInt($data->Id) && normalizeString($conn, $data->Name, $data->Image)) {
            editCafeteria($conn, $data->Name, $data->Id, $data->Image);
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    if ($_SESSION['roleId'] == 1) {
        if (isset($_GET['cafeteriaId']) && testInt($_GET['cafeteriaId'])) {
            deleteCafeteria($conn, $_GET['cafeteriaId']);
        } else {
            //echo "No Id is provided";
        }
    }
}

require '../footer.php';
