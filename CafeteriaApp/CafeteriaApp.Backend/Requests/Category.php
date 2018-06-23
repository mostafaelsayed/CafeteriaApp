<?php
require __DIR__ . '/../Controllers/Category.php';
require __DIR__ . '/../connection.php';
require __DIR__ . '/TestRequestInput.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {        
    if ( isset($_GET['id']) && testInt($_GET['id']) ) {
        checkResult( getCategoryById($conn, $_GET['id']) );
    }
    elseif (isset($_GET['name'])) {
        checkResult( getCategoryIdByName($conn, $_GET['name']) );
    }
    else {
        checkResult( getCategories($conn) );
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode( file_get_contents('php://input') );

    if (isset($data->Name) && normalizeString($conn, $data->Name) ) {
        if ( !isset($data->Image) ) {
            addCategory($conn, $data->Name);
        }
        elseif ( isset($data->Image) && normalizeString($conn, $data->Image) ) {
            addCategory($conn, $data->Name, $data->Image);
        }
    }
    else {
        if ( !isset($data->Name) ) {
            echo "Error: Name is Required";
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    //decode the json data
    $data = json_decode( file_get_contents('php://input') );

    if ( isset($data->Id, $data->Name) && normalizeString($conn, $data->Name) && testInt($data->Id) ) {
        $x = normalizeString($conn, $data->Image);
        
        if ($x == false) {
            editCategory($conn, $data->Name, $data->Id);
        }
        else {
            editCategory($conn, $data->Name, $data->Id, $data->Image);
        }
    }
    else {
        echo "name is required";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    if ( isset($_GET['categoryId']) && testInt($_GET['categoryId']) ) {
        deleteCategory($conn, $_GET['categoryId']);
    }
    else {
        echo "No Id is provided";
    }
}

require __DIR__ . '/../footer.php';