<?php
require __DIR__ . '/../Controllers/Category.php';
require __DIR__ . '/../connection.php';
require __DIR__ . '/TestRequestInput.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['cafeteriaId']) && !isset($_GET['id']) && testInt($_GET['cafeteriaId'])) {
        checkResult(getByCafeteriaId($conn, $_GET['cafeteriaId']));
    } elseif (isset($_GET['id']) && !isset($_GET['cafeteriaId']) && testInt($_GET['id'])) {
        checkResult(getCategoryById($conn, $_GET['id']));
    } else {
        echo "Error occured while returning categories";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'));

    if (isset($data->Name, $data->CafeteriaId) && normalizeString($conn, $data->Name) && testInt($data->CafeteriaId)) {
        if (!isset($data->Image)) {
            addCategory($conn, $data->Name, $data->CafeteriaId);
        } elseif (isset($data->Image) && normalizeString($conn, $data->Image)) {
            addCategory($conn, $data->Name, $data->CafeteriaId, $data->Image);
        }
    } else {
        if (!isset($data->Name)) {
            echo "Error: Name is Required";
        } elseif (!isset($data->CafeteriaId)) {
            echo "Error: No Cafeteria Id is Provided";
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    //decode the json data
    $data = json_decode(file_get_contents('php://input'));

    if (isset($data->Id, $data->Name) && normalizeString($conn, $data->Name) && testInt($data->Id)) {
        if (!isset($data->Image)) {
            editCategory($conn, $data->Name, $data->Id);
        } else {
            if (normalizeString($conn, $data->Image)) {
                editCategory($conn, $data->Name, $data->Id, $data->Image);
            }

        }
    } else {
        echo "name is required";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    if (isset($_GET['categoryId']) && testInt($_GET['categoryId'])) {
        deleteCategory($conn, $_GET['categoryId']);
    } else {
        echo "No Id is provided";
    }
}

require '../footer.php';
