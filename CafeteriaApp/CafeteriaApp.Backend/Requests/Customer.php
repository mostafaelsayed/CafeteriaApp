<?php
require __DIR__ . '/../Controllers/Customer.php';
require __DIR__ . '/../connection.php';
require __DIR__ . '/TestRequestInput.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if ( isset($_GET['userId']) && testInt($_GET['userId']) && $_SESSION['roleId'] == 1) {
        checkResult( getCustomerByUserId($conn, $_GET['userId']) );
    }
    elseif ( isset($_SESSION['userId']) ) {
        checkResult( getCurrentCustomerinfoByUserId($conn) );
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_SESSION['roleId'] == 1) {
        //decode the json data
        $data = json_decode( file_get_contents('php://input') );

        if ( isset($data->Credit, $data->UserId) && testInt($data->UserId) && testPrice($data->Credit) ) {
            addCustomer($conn, $data->Credit, $data->UserId);
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    //decode the json data
    $data = json_decode( file_get_contents('php://input') );
    if ( isset($data->UserId) && testInt($data->UserId) && testPrice($data->Credit) && ($_SESSION['roleId'] == 1 || $data->UserId == $_SESSION['userId']) ) {
        echo editCustomer($conn, $data->Credit, $data->UserId);
    }
    else {
        echo "error";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    if ($_SESSION['roleId'] == 1) {
        if ( isset($_GET['userId']) && testInt($_GET['userId']) ) {
            deleteCustomerByUserId($conn, $_GET['userId']);
        }
        elseif ( isset($_GET['customerId']) && testInt($_GET['customerId']) ) {
            deleteCustomer($conn, $_GET['customerId']);
        }
    }
}

require __DIR__ . '/../footer.php';