<?php
require __DIR__ . '/../CafeteriaApp.Backend/functions.php';
require __DIR__ . '/../CafeteriaApp.Backend/validation_functions.php';
require __DIR__ . '/../CafeteriaApp.Backend/Controllers/Notification.php';
require __DIR__ . '/../CafeteriaApp.Backend/Controllers/Order.php';

if ( isset($_GET['redirect_to']) ) {
    $_POST['redirect_to'] = $_GET['redirect_to'];
}

if ( isset($_POST['submit']) ) {
    // check if the button is been pressed
    // Process the form
    // validations
    $required_fields = array('email', 'password');
    validate_presences($required_fields);

    if (empty($errors)) {
        // Attempt Login
        $email      = $_POST['email'];
        $password   = $_POST['password'];
        $found_user = attempt_login($conn, $email, $password);

        if ($found_user) {
            // Success
            // Mark user as logged in
            $_SESSION['userId']    = $found_user['Id'];
            $_SESSION['email']  = $found_user['Email'];
            $_SESSION['roleId']    = $found_user['RoleId'];
            $_SESSION['langId']    = $found_user['LocaleId'];
            $_SESSION['image']     = $found_user['Image'];
            $_SESSION['croppedImage']     = $found_user['CroppedImage'];
            $_SESSION['genderId'] = $found_user['GenderId'];
            $_SESSION['imageSet'] = $found_user['ImageSet'];

            $_SESSION['Confirmed'] = $found_user['Confirmed'];

            if ( (!$_SESSION['orderId'] = getOpenOrderByUserId($conn)['Id']) && $_SESSION['roleId'] == 2 ) {
                // if not found open order>>open a new one
                $_SESSION['orderId'] = addOrder($conn, date('Y-m-d h:m'), 1, 1, $_SESSION['userId']);
            }

            //get notification messages
            $_SESSION['notifications'] = getNotificationByUserId($conn, $_SESSION['userId']); // if not found
            deleteNotificationsByUserId($conn, $_SESSION['userId']);
            //record date

            if ( isset($_POST['remember']) ) {
                // set the cookie to a long date
                setcookie(session_name(), session_id(), time() + 42000000, '/');
            }

            if ( isset($_POST['redirect_to']) ) {
                // make restrictions on pages that request this page ,otherwise redirect to the same page to cancel his header
                if (basename($_POST['redirect_to']) === 'menuitems.php') { // restrictions on redirectionsfile_exists()
                    redirect_to( rawurldecode($_POST['redirect_to']) );
                } else {
                    if ($_SESSION['roleId'] == 2) {
                        // customer
                        redirect_to( rawurldecode('Public/categories.php') );
                    } elseif ($_SESSION['roleId'] == 1) {
                        // admin
                        redirect_to( rawurldecode('Admin/Category/show_and_delete_categories.php') );
                    } else {
                        // cashier
                        redirect_to( rawurldecode('Cashier/show_and_hide_orders.php') );
                    }
                }
            } else {
                if ($_SESSION['roleId'] == 2) {
                    // customer
                    redirect_to( rawurldecode('Public/categories.php') );
                } elseif ($_SESSION['roleId'] == 1) {
                    // admin
                    redirect_to( rawurldecode('Admin/Category/show_and_delete_categories.php') );
                } else {
                    // cashier
                    redirect_to( rawurldecode('Cashier/show_and_hide_orders.php') );
                }
            } //3ala 7asab
        } else {
            // Failure
            //echo "<script type=\"text/javascript\">console.log(2);</script>";
            $_SESSION['message'] = 'Username/password not found.';

        }
    }
}
// if already logged in and called login page
elseif ( isset($_SESSION['userId']) && isset($_SESSION['userName']) && isset($_SESSION['roleId']) ) {
    // This is probably a GET request
    if ($_SESSION['roleId'] == 1) { // admin
        redirect_to( rawurldecode('Admin/Category/show_and_delete_categories.php') ); //
    } else if ($_SESSION['roleId'] == 2) { // customer
        redirect_to( rawurldecode('Public/categories.php') ); //
    } else { // cashier
        redirect_to( rawurldecode('Cashier/show_and_hide_orders.php') ); //
    }
} // end: if ( isset( $_POST['submit'] ) )
?>

<!DOCTYPE html>

<html>

  <head>

    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1.0" />

    <link href="css/errors.css" rel="stylesheet" type="text/css">

    <link rel="icon" type="text/css" href="../../favicon.ico">

    <link rel="stylesheet" href="css/materialize.css">

    <link rel="stylesheet" type="text/css" href="css/login.css">

    <script src="js/jquery-3.1.1.min.js"></script>

    <script src="js/materialize.min.js"></script>

  </head>

  <body id="loginbody">

    <div id="main">

      <div id="navigation">

        &nbsp;

      </div>

      <div id="page" style="align-content: center;text-align: center">

        <?php echo message(); ?>

        <?php echo form_errors($errors); ?>

        <h1 style="font-style: italic;color: white">Login</h1>

        <form action="login.php" method="post" class="login-box" style="width: 30%;margin: auto;text-align: center">

          <div class="input-field col s12">

            <label for="email" style="font-size: 25px;color: white">E-mail</label>

            <input type="email" id="email" name="email" value="<?php echo isset($_SESSION['userName']) ? htmlentities($_SESSION['userName']) : ''; ?>" />

          </div>

          <div class="input-field col s12">

            <label for="password" style="font-size: 25px;color: white">Password</label>

            <input type="password" name="password" style="color: white" />

          </div>

          <div class="input-field col s12" style="margin-left: 55px">

            <input type="checkbox" id="rememberme" name="remember">

            <label for="rememberme" style="color: white">Remeber me</label>

          </div>

          <br><br>

          <input type="submit" class="btn" name="submit" value="Next" />

        </form>

        <br>

        <a href="index.php">

          <button class="btn waves-effect waves-light btn" type="submit" name="action">Facebook Login

            <img src="icons/facebook.png" width="30px" height="30px" style="margin-top: 2px">

          </button>

        </a>

        <div><br></div>

        <div>

          <div>

            <a href="register.php" name="submit" />New User ! </a>

          </div>

          <a href="resetPassword.php" name="submit" />Forgot Password ! </a>

          <div><br></div>

        </div>

      </div>

    </div>

  </body>

</html>

<div style="align-content: center;text-align: center;font-style: italic;color: white">&copy; 2010-<?php echo date("Y"); ?></div>