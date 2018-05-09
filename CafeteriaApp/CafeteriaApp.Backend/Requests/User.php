<?php
require __DIR__ . '/../Controllers/User.php';
require __DIR__ . '/../Controllers/Order.php';
require __DIR__ . '/TestRequestInput.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if ($_SESSION['roleId'] == 1) {
        // admin only can call these methods
        if ( isset($_GET['userId']) && testInt($_GET['userId']) ) {
            checkResult( getUserById($conn, $_GET['userId']) );
        } else {
            checkResult( getUsers($conn) );
        }
    }
    else if (isset($_GET['flag']) && $_GET['flag'] == 1) {
        echo $_SESSION['roleId'];
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['roleId']) && $_SESSION['roleId'] == 1) {
        //decode the json data
        $data = json_decode( file_get_contents('php://input') );
        $result = normalizeString($conn, $data->UserName, $data->FirstName, $data->LastName, $data->Password) && testPhone($data->PhoneNumber) && testEmail($data->Email);

        if ( $result && isset($data->RoleId) && testInt($data->RoleId) ) {
            normalizeString($conn, $data->Image);
            echo addUser($conn, $data->UserName, $data->FirstName, $data->LastName, $data->Image, $data->Email, $data->PhoneNumber, $data->Password, $data->RoleId, 1);
        }
    }
    else {
        if (isset($_GET['flag']) && $_GET['flag'] == 2) {
            $data = json_decode( file_get_contents('php://input') );
            $email = $data->Email;
            echo checkExistingEmail($conn, $email);
        }
        else {
            $result = isset($_POST['firstName'], $_POST['lastName'], $_POST['phone'], $_POST['email'], $_POST['DOB'], $_POST['gender'], $_POST['password']) && normalizeString($conn, $_POST['firstName'], $_POST['lastName']) && testPhone($_POST['phone']) && testEmail($_POST['email']) && testDateOfBirth($_POST['DOB']) && testInt($_POST['gender']) && testPassword($_POST['password']);

            if ($result) {
                $x1 = $_POST['x1'];
                $y1 = $_POST['y1'];
                $x2 = $_POST['x2'];
                $y2 = $_POST['y2'];
                $w  = $_POST['w'];
                $h  = $_POST['h'];
                normalizeString($conn, $_FILES['image']['name']);
                $userId = addUser($conn, $_POST['firstName'], $_POST['lastName'], $_FILES['image'], $_POST['email'], $_POST['phone'], $_POST['password'], $_POST['DOB'], $_POST['gender'], 2, 1, $x1, $y1, $x2, $y2, $w, $h);
                $_SESSION['userId'] = $userId;
                //$_SESSION['orderId'] = addOrder($conn, date('Y-m-d h:m'), 1, 1, $userId);
                $_SESSION['notifications'] = [];
                $_SESSION['langId'] = 1;
                //header("Location: " . "../../CafeteriaApp.Frontend/Public/categories.php");
            } else {
                header("Location: " . "../../CafeteriaApp.Frontend/Register.php");
            }
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    if ($_SESSION['roleId'] == 1) {
        //decode the json data
        $data = json_decode( file_get_contents('php://input') );
        $result = normalizeString($conn, $data->UserName, $data->FirstName, $data->LastName) && testPhone($data->PhoneNumber) && testEmail($data->Email);

        if ( $result && isset($data->RoleId, $data->Id) && testMutipleInts($data->RoleId, $data->Id) ) {
            $x = normalizeString($conn, $data->Image);
            if ($x == true) {
                editUser($conn, $data->UserName, $data->FirstName, $data->LastName, $data->Email, $data->Image, $data->PhoneNumber, $data->RoleId, $data->Id);
            }
            else {
                editUser($conn, $data->UserName, $data->FirstName, $data->LastName, $data->Email, null, $data->PhoneNumber, $data->RoleId, $data->Id);
            }
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    if ($_SESSION['roleId'] == 1) {
        //decode the json data
        if ( isset($_GET['userId']) && testInt($_GET['userId']) ) {
            deleteUser($conn, $_GET['userId']);
        }
    }
}

require __DIR__ . '/../footer.php';
