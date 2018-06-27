<?php
require __DIR__ . '/../session.php';
require __DIR__ . '/../Controllers/FavoriteItem.php';
require __DIR__ . '/../connection.php';
require __DIR__ . '/TestRequestInput.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_SESSION['userId'])) {
        checkResult(getFavoriteItemsByUserId($conn, $_SESSION['userId']));
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $data = json_decode(file_get_contents('php://input'));

    if (isset($_SESSION['userId']) && isset($data->menuItemId) && testInt($data->menuItemId)) {
        checkResult(deleteFavoriteItemByMenuItemId($conn, $_SESSION['userId'], $data->menuItemId));
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //decode the json data
    $data = json_decode(file_get_contents('php://input'));

    if (isset($_SESSION['userId']) && isset($data->menuItemId) && testInt($data->menuItemId)) {
        addFavoriteItem($conn, $_SESSION['userId'], $data->menuItemId);
    }
}

require '../footer.php';