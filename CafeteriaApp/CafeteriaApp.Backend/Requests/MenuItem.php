<?php
require __DIR__ . '/../Controllers/MenuItem.php';
require __DIR__ . '/../connection.php';
require __DIR__ . '/../session.php';
require __DIR__ . '/TestRequestInput.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if ( isset($_GET['categoryId']) && testInt($_GET['categoryId']) ) {
        checkResult( getMenuItemByCategoryId($conn, $_GET['categoryId'], false, true) );
    } elseif (isset($_GET['id']) && testInt($_GET['id']) && $_SESSION['roleId'] == 1) {
        checkResult( getMenuItemById($conn, $_GET['id']) );
    } else {
        echo "Error while returning MenuItem";
    }
}

if ( $_SERVER['REQUEST_METHOD'] == 'POST' && checkCSRFToken() ) {
    if ($_SESSION['roleId'] == 1) {
        //decode the json data
        $data = json_decode( file_get_contents('php://input') ); // ????????????

        if ( isset($data->CategoryId, $data->Price, $data->Name, $data->Description) && testInt($data->CategoryId) && normalizeString($conn, $data->Name, $data->Description) && testPrice($data->Price) ) {
            if (isset($data->Image) && $data->Image != null) {
                addMenuItem($conn, $data->Name, $data->Price, $data->Description, $data->CategoryId, $data->Image);
            }
            else {
                addMenuItem($conn, $data->Name, $data->Price, $data->Description, $data->CategoryId);
            }
        } else {
            echo "error while adding menuitem";
        }
    }
}

if ( $_SERVER['REQUEST_METHOD'] == 'PUT' && checkCSRFToken() ) {
    if ($_SESSION['roleId'] == 1) {
        //decode the json data
        $data = json_decode( file_get_contents('php://input') );

        if ( isset($data->Id, $data->Price, $data->Visible, $data->Name, $data->Description) && testMutipleInts($data->Id) && normalizeString($conn, $data->Name, $data->Description, $data->Visible) && testPrice($data->Price) ) {
            $x = normalizeString($conn, $data->Image);

            if ($x == true) {
                editMenuItem($conn, $data->Name, $data->Price, $data->Description, $data->Id, $data->Image, $data->Visible);
            }
            else {
                editMenuItem($conn, $data->Name, $data->Price, $data->Description, $data->Id, null, $data->Visible);
            }
        } else {
            echo "error while editiing menuitem";
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    if ($_SESSION['roleId'] == 1) {
        if ( isset($_GET['menuItemId']) && testInt($_GET['menuItemId']) ) {
            deleteMenuItem($conn, $_GET['menuItemId']);
        } else {
            echo "Id error";
        }
    }
}

require __DIR__ . '/../footer.php';
