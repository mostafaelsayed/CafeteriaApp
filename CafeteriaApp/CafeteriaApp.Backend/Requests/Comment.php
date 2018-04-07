<?php
require __DIR__ . '/../session.php';
require __DIR__ . '/../Controllers/Comment.php';
require __DIR__ . '/../connection.php';
require __DIR__ . '/TestRequestInput.php';


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['MenuItemId']) && testInt($_GET['MenuItemId'])) {
        $comments = getCommentsByMenuItemId($conn, $_GET['MenuItemId']);
        
        if(isset($_SESSION['userId'])){
        $commentsIdsForCustomer = getCommentsIdsByUserIdAndMenuItemId($conn, $_SESSION['userId'], $_GET['MenuItemId']);
        } else {
        $commentsIdsForCustomer =[];
    }
        checkResult(array($comments, $commentsIdsForCustomer));
    } 
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //decode the json data
    $data = json_decode(file_get_contents('php://input'));

    if (isset($data->Details) && normalizeString($conn, $data->Details) && isset($_SESSION['userId']) && isset($data->MenuItemId) && testInt($data->MenuItemId)) {
        checkResult(addComment($conn, $data->Details, $_SESSION['userId'], $data->MenuItemId));
    } 
}

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    //decode the json data
    $data = json_decode(file_get_contents('php://input'));

    if (isset($data->Details) && normalizeString($conn, $data->Details) && isset($_SESSION['userId']) && isset($data->Id) && testInt($data->Id)) {
        if (checkOwnershipOfComment($conn, $data->Id, $_SESSION['userId'])) {
            editComment($conn, $data->Details, $data->Id);
        } 
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    if (isset($_GET['id']) && testInt($_GET['id']) && isset($_SESSION['userId'])) {
        if (checkOwnershipOfComment($conn, $_GET['id'], $_SESSION['userId'])) {
            deleteComment($conn, $_GET['id']);
        }
    } 
}

require '../footer.php';
