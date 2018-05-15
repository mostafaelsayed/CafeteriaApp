<?php
require __DIR__ . '/../Controllers/User.php';
require __DIR__ . '/../Controllers/Admin.php';
require __DIR__ . '/../Controllers/Cashier.php';
require __DIR__ . '/../Controllers/Customer.php';
require __DIR__ . '/../Controllers/Order.php';
require __DIR__ . '/TestRequestInput.php';

// var_dump($_SERVER);
// if ($_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'DELETE') {
//     if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token']) {
//         echo '<div>ERROR</div>';
//         return;
//     }
// }

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if ($_SESSION['roleId'] == 1) {
        // admin only can call these methods
        if ( isset($_GET['userId']) && testInt($_GET['userId']) ) {
            checkResult( getUserById($conn, $_GET['userId']) );
        }
        else {
            checkResult( getUsers($conn) );
        }
    }
    else if (isset($_GET['flag']) && $_GET['flag'] == 1) {
        echo $_SESSION['roleId'];
    }
}

if ( $_SERVER['REQUEST_METHOD'] == 'POST' && checkCSRFToken($_POST['csrf_token']) ) {
    if (isset($_GET['flag']) && $_GET['flag'] == 2) {
        $data = json_decode( file_get_contents('php://input') );
        $email = $data->Email;
        echo checkExistingEmail($conn, $email);
    }
    elseif (isset($_SESSION['roleId']) && $_SESSION['roleId'] == 1) {
        $result = isset($_POST['firstName'], $_POST['lastName'], $_POST['roleId'], $_POST['phone'], $_POST['email'], $_POST['DOB'], $_POST['password']) && normalizeString($conn, $_POST['firstName'], $_POST['lastName']) && testPhone($_POST['phone']) && testEmail($_POST['email']) && testDateOfBirth($_POST['DOB']) && testPassword($_POST['password']) && testInt($_POST['roleId']) && ($_POST['confirmPassword'] == $_POST['password']);

        if ($result) {
            $x1 = $_POST['x1'];
            $y1 = $_POST['y1'];
            $w  = $_POST['w'];
            $h  = $_POST['h'];
            normalizeString($conn, $_FILES['image']['name']);
            $userId = addUser($conn, $_POST['firstName'], $_POST['lastName'], $_FILES['image'], $_POST['email'], $_POST['phone'], $_POST['password'], $_POST['gender'], $_POST['roleId'], $_POST['DOB'], 1, $x1, $y1, $w, $h);

            if ($_POST['roleId'] == 1) {
                addAdmin($conn, $userId);
            }
            elseif ($_POST['roleId'] == 2) {
                addCustomer($conn, $_POST['credit'], $userId);
            }
            elseif ($_POST['roleId'] == 3) {
                addCashier($conn, $userId);
            }

            header("Location: " . "/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Admin/User/show_and_delete_users.php");
        }
    }
    else {
        $result = isset($_POST['firstName'], $_POST['lastName'], $_POST['phone'], $_POST['email'], $_POST['DOB'], $_POST['gender'], $_POST['password']) && normalizeString($conn, $_POST['firstName'], $_POST['lastName']) && testPhone($_POST['phone']) && testEmail($_POST['email']) && testDateOfBirth($_POST['DOB']) && testInt($_POST['gender']) && testPassword($_POST['password']) && ($_POST['confirmPassword'] == $_POST['password']);

        if ($result) {
            $x1 = $_POST['x1'];
            $y1 = $_POST['y1'];
            $w  = $_POST['w'];
            $h  = $_POST['h'];
            normalizeString($conn, $_FILES['image']['name']);
            $userId = addUser($conn, $_POST['firstName'], $_POST['lastName'], $_FILES['image'], $_POST['email'], $_POST['phone'], $_POST['password'], $_POST['gender'], 2, $_POST['DOB'], 1, $x1, $y1, $w, $h);
            $_SESSION['userId'] = $userId;
            $_SESSION['orderId'] = addOrder($conn, date('Y-m-d h:m'), 1, 1, $userId);
            $_SESSION['notifications'] = [];
            $_SESSION['langId'] = 1;
            $_SESSION['image'] = mysqli_fetch_assoc($conn->query('select Image from user where Id = ' . $userId))['Image'];
            header("Location: " . "/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Public/categories.php");
        }
        else {
            header("Location: " . "/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Register.php");
        }
    }
}

if ( $_SERVER['REQUEST_METHOD'] == 'PUT' && checkCSRFToken($_POST['csrf_token']) ) {
    if ($_SESSION['roleId'] == 1) {
        //decode the json data
        $data = json_decode( file_get_contents('php://input') );

        $result = normalizeString($conn, $data->FirstName, $data->LastName) && testPhone($data->PhoneNumber) && testEmail($data->Email) && testInt($data->Gender, $data->RoleId) && testDateOfBirth($data->DateOfBirth);

        if ( isset($data->x1) || isset($data->y1) || isset($data->w) || isset($data->h) ) {
            $x1 = $data->x1;
            $y1 = $data->y1;
            $w  = $data->w;
            $h  = $data->h;
        }
        else {
            $x1 = null;
            $y1 = null;
            $w  = null;
            $h  = null;
        }

        if ($result) {
            $x = normalizeString($conn, $data->Image);

            if ($x) {
                editUser($conn, $data->FirstName, $data->LastName, $data->Email, $data->Image, $data->PhoneNumber, $data->RoleId, $data->Id, $data->Gender, $data->DateOfBirth, $x1, $y1, $w, $h);
            }
            else {
                editUser($conn, $data->FirstName, $data->LastName, $data->Email, null, $data->PhoneNumber, $data->RoleId, $data->Id, $data->Gender, $data->DateOfBirth);
            }
        }
    }
}

if ( $_SERVER['REQUEST_METHOD'] == 'DELETE' && checkCSRFToken($_POST['csrf_token']) ) {
    if ($_SESSION['roleId'] == 1) {
        //decode the json data
        if ( isset($_GET['userId']) && testInt($_GET['userId']) ) {
            deleteUser($conn, $_GET['userId']);
        }
    }
}

require __DIR__ . '/../footer.php';
