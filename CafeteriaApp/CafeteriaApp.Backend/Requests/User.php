<?php
require __DIR__ . '/../Controllers/User.php';
require __DIR__ . '/../Controllers/Admin.php';
require __DIR__ . '/../Controllers/Cashier.php';
require __DIR__ . '/../Controllers/Customer.php';
require __DIR__ . '/../Controllers/Order.php';
require __DIR__ . '/TestRequestInput.php';
require __DIR__ . '/../functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if ($_SESSION['roleId'] == 1) {
        // admin only can call these methods
        if ( isset($_GET['userId']) && testMutipleInts($_GET['userId']) ) {
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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && checkCSRFToken()) {
    if (isset($_GET['flag']) && $_GET['flag'] == 2) {
        $data = json_decode( file_get_contents('php://input') );
        $email = $data->Email;
        echo checkExistingEmail($conn, $email);
    }
    elseif (isset($_SESSION['roleId']) && $_SESSION['roleId'] == 1) {
        $result = isset($_POST['firstName'], $_POST['lastName'], $_POST['roleId'], $_POST['phone'], $_POST['email'], $_POST['DOB'], $_POST['password']) && normalizeString($conn, $_POST['firstName'], $_POST['lastName']) && testPhone($_POST['phone']) && testEmail($_POST['email']) && testDateOfBirth($_POST['DOB']) && testPassword($_POST['password']) && testMutipleInts($_POST['roleId']) && ($_POST['confirmPassword'] == $_POST['password']) && ($_POST['genderId'] == 1 || $_POST['genderId'] == 2);

        if ( $result && isset($_POST['x1'], $_POST['y1'], $_POST['w'], $_POST['h']) && ( ($_POST['x1'] == '' && $_POST['y1'] == '' && $_POST['w'] == '' && $_POST['h'] == '') || ( testMutipleInts($_POST['x1'], $_POST['y1'], $_POST['w'], $_POST['h']) ) ) ) {
            $x1 = $y1 = $w = $h = null;

            if ( ($_POST['x1'] != '' && $_POST['y1'] != '' && $_POST['w'] != '' && $_POST['h'] != '') ) {
                $x1 = $_POST['x1'];
                $y1 = $_POST['y1'];
                $w  = $_POST['w'];
                $h  = $_POST['h'];
            }

            normalizeString($conn, $_FILES['image']['name']);
            $userId = addUser($conn, $_POST['firstName'], $_POST['lastName'], $_FILES['image'], $_POST['email'], $_POST['phone'], $_POST['password'], $_POST['genderId'], $_POST['roleId'], $_POST['DOB'], 1, $x1, $y1, $w, $h);

            if ($_POST['roleId'] == 1) {
                addAdmin($conn, $userId);
            }
            elseif ($_POST['roleId'] == 2) {
                addCustomer($conn, $_POST['credit'], $userId);
            }
            elseif ($_POST['roleId'] == 3) {
                addCashier($conn, $userId);
            }

            header("Location: /admin/user/show");
        }
        else {
            header("Location: /admin/user/add");
        }
    }
    else {
        if (isset($_GET['update']) && $_GET['update'] == 1) {
            $data = json_decode( file_get_contents('php://input') );

            if ( isset($data->x1, $data->y1, $data->w, $data->h) && ( ($data->x1 == '' && $data->y1 == '' && $data->w == '' && $data->h == '') || testMutipleInts($data->x1, $data->y1, $data->w, $data->h) ) ) {
                $x1 = $y1 = $w = $h = null;

                if ( ($data->x1 != '' && $data->y1 != '' && $data->w != '' && $data->h != '') ) {
                    $x1 = $data->x1;
                    $y1 = $data->y1;
                    $w  = $data->w;
                    $h  = $data->h;
                }

                handlePictureUpdate($conn, $data->Image, $x1, $y1, $w, $h);
            }
        }
        else {
            $result = isset($_POST['firstName'], $_POST['lastName'], $_POST['phone'], $_POST['email'], $_POST['DOB'], $_POST['genderId'], $_POST['password']) && normalizeString($conn, $_POST['firstName'], $_POST['lastName']) && testPhone($_POST['phone']) && testEmail($_POST['email']) && testDateOfBirth($_POST['DOB']) && testMutipleInts($_POST['genderId']) && testPassword($_POST['password']) && ($_POST['confirmPassword'] == $_POST['password']);

            if ($result && isset($_POST['x1'], $_POST['y1'], $_POST['w'], $_POST['h']) && ( ($_POST['x1'] == '' && $_POST['y1'] == '' && $_POST['w'] == '' && $_POST['h'] == '') || ( testMutipleInts($_POST['x1'], $_POST['y1'], $_POST['w'], $_POST['h']) ) ) ) {
                $x1 = $y1 = $w = $h = null;

                if ( ($_POST['x1'] != '' && $_POST['y1'] != '' && $_POST['w'] != '' && $_POST['h'] != '') ) {
                    $x1 = $_POST['x1'];
                    $y1 = $_POST['y1'];
                    $w  = $_POST['w'];
                    $h  = $_POST['h'];
                }

                normalizeString($conn, $_FILES['image']['name']);
                $userId = addUser($conn, $_POST['firstName'], $_POST['lastName'], $_FILES['image'], $_POST['email'], $_POST['phone'], $_POST['password'], $_POST['genderId'], 2, $_POST['DOB'], 1, $x1, $y1, $w, $h);
                $_SESSION['userId'] = $userId;
                $_SESSION['roleId'] = 2; // customer
                $_SESSION['orderId'] = addOrder($conn, date('Y-m-d h:m'), 'Cash', 'Open', $userId);
                $_SESSION['notifications'] = [];
                $_SESSION['langId'] = 1;
                $x = mysqli_fetch_assoc( $conn->query('select Image, CroppedImage from user where Id = ' . $userId) );
                $_SESSION['genderId'] = $_POST['genderId'];
                $_SESSION['image'] = $x['Image'];
                $_SESSION['email']  = $_POST['email'];
                $_SESSION['croppedImage'] = $x['CroppedImage'];
                header("Location: /public/categories");
            }
            else {
                header("Location: /register");
            }
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    if ($_SESSION['roleId'] == 1) {
        //decode the json data
        $data = json_decode( file_get_contents('php://input') );

        $result = normalizeString($conn, $data->FirstName, $data->LastName) && testPhone($data->PhoneNumber) && testEmail($data->Email) && testMutipleInts($data->GenderId, $data->RoleId) && testDateOfBirth($data->DateOfBirth);

        if ( $result && isset($data->x1, $data->y1, $data->w, $data->h) && ( ($_POST['x1'] == '' && $_POST['y1'] == '' && $_POST['w'] == '' && $_POST['h'] == '') || testMutipleInts($data->x1, $data->y1, $data->w, $data->h) ) ) {
            $x1 = $y1 = $w = $h = null;

            if ( ($_POST['x1'] != '' && $_POST['y1'] != '' && $_POST['w'] != '' && $_POST['h'] != '') ) {
                $x1 = $data->x1;
                $y1 = $data->y1;
                $w  = $data->w;
                $h  = $data->h;
            }

            $x = normalizeString($conn, $data->Image);

            if ($x) {
                editUser($conn, $data->FirstName, $data->LastName, $data->Email, $data->Image, $data->PhoneNumber, $data->RoleId, $data->Id, $data->GenderId, $data->DateOfBirth, $x1, $y1, $w, $h);
            }
            else {
                editUser($conn, $data->FirstName, $data->LastName, $data->Email, null, $data->PhoneNumber, $data->RoleId, $data->Id, $data->GenderId, $data->DateOfBirth);
            }
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    if ($_SESSION['roleId'] == 1) {
        //decode the json data
        if ( isset($_GET['userId']) && testMutipleInts($_GET['userId']) ) {
            deleteUser($conn, $_GET['userId']);
        }
    }
    elseif (isset($_GET['f']) && $_GET['f'] == 1) {
        $_SESSION['imageSet'] = 0;
        $conn->query("update `user` set `ImageSet` = 0 where `Id` = '{$_SESSION['userId']}'");
        $type = pathinfo($_SESSION['image'], PATHINFO_EXTENSION);
        $imageFileName = __DIR__ . '\..\uploads\\' . $_SESSION['email'];
        $croppedImageFileName = $imageFileName;

        if ($type == 'jpeg') {
            $imageFileName .= '.jpeg';
            $croppedImageFileName .= '_crop.jpeg';

        }
        else {
            $imageFileName .= '.png';
            $croppedImageFileName .= '_crop.png';
        }

        unlink($croppedImageFileName);
        unlink($imageFileName);

        $_SESSION['image'] = '/uploads/';

        if ($_SESSION['genderId'] == 1) { // male
            $_SESSION['image'] .= 'maleimage.jpeg';
        }
        else {
            $_SESSION['image'] .= 'femaleimage.jpeg';
        }

        $_SESSION['croppedImage'] = $_SESSION['image'];

        $conn->query("update `user` set `Image` = '{$_SESSION['image']}', `CroppedImage` = '{$_SESSION['croppedImage']}' where `Id` = '{$_SESSION['userId']}'");
    }
}

require __DIR__ . '/../footer.php';