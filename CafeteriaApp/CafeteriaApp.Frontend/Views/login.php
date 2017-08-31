<?php

require_once("CafeteriaApp.Backend/session.php"); // must be first as it uses cookies

require_once("CafeteriaApp.Backend/connection.php");

require_once("CafeteriaApp.Backend/functions.php");

require_once("CafeteriaApp.Backend/validation_functions.php");

require_once("CafeteriaApp.Backend/Controllers/Dates.php");

require_once("CafeteriaApp.Backend/Controllers/Times.php");

require_once("CafeteriaApp.Backend/Controllers/Notification.php");

require_once('CafeteriaApp.Backend/Controllers/Order.php');

if(isset($_GET['redirect_to']))
{
  $_POST['redirect_to'] = $_GET['redirect_to'];
}

if (isset($_POST['submit']))
{ // check if the button 's been pressed
  // Process the form
  
  // validations
  $required_fields = array("email","password");
  validate_presences($required_fields);
  
  if (empty($errors))
  {
    // Attempt Login

		$email = $_POST["email"];
		$password = $_POST["password"];
		
		$found_user = attempt_login($conn,$email, $password);

    if ($found_user)
    {
      // Success
			// Mark user as logged in
      
			$_SESSION["userId"] = $found_user["Id"];
			$_SESSION["userName"] = $found_user["UserName"];
      $_SESSION["roleId"] = $found_user["RoleId"];
      $_SESSION["langId"] = 1;// if not found

      //get customer id by user id from db 
      if(! $_SESSION["orderId"] = getOpenOrderByUserId($conn)["Id"])//if not found open order>>open a new one
      {
        $deliveryTimeId = getCurrentTimeId($conn);
        $deliveryDateId = getCurrentDateId($conn);
        $_SESSION["orderId"] = addOrder($conn,$deliveryDateId,$deliveryTimeId,'',1,1, $_SESSION["userId"], 0);
      }
     
      //get notification messages
      $_SESSION["notifications"] = getNotificationByUserId($conn , $_SESSION["userId"] );// if not found
    
      deleteNotificationsByUserId($conn,$_SESSION["userId"]) ;

      //record date
      if (!getCurrentDateId($conn)) // make the server add it automatically
      {
        addTodayDate($conn,true);
      }
      
      if (isset($_POST['remember'])) // set the cookie to a long date
      {
        setcookie(session_name(), session_id(),time()+42000000,'/');
      }

      if (isset($_POST['redirect_to'])) // make restrictions on pages that request this page ,otherwise redirect to the same page to cancel his header
      {
        if (basename($_POST['redirect_to']) === "showing menuitems of a category and customer order.php")//restrictions on redirectionsfile_exists()
        {
          redirect_to(rawurldecode($_POST['redirect_to']));
        }
        else
        {
          if ($_SESSION["roleId"] == 2)
          {
            redirect_to(rawurldecode("/CafeteriaApp.Frontend/Areas/Public/Cafeteria/Views/showing cafeterias.php"));
          }
          elseif ($_SESSION["roleId"] == 1)
          {
            redirect_to(rawurldecode("/CafeteriaApp.Frontend/Areas/Admin/Cafeteria/Views/show_and_delete_cafeterias.php"));
          }
        }
      }
      else
      {
        if ($_SESSION["roleId"] == 2)
        {
          redirect_to(rawurldecode("/CafeteriaApp.Frontend/Areas/Public/Cafeteria/Views/showing cafeterias.php"));
        }
        elseif ($_SESSION["roleId"] == 1) 
        {
          redirect_to(rawurldecode("/CafeteriaApp.Frontend/Areas/Admin/Cafeteria/Views/show_and_delete_cafeterias.php"));
        }
      } //3ala 7asab                               
    }

   
    else
    {
      // Failure
      $_SESSION["message"] = "Username/password not found.";
    }
  }
}

// if already logged in and called login page
elseif (isset($_SESSION["userId"] ) && isset($_SESSION["userName"]) && isset($_SESSION["roleId"]) )// This is probably a GET request
{
  redirect_to(rawurldecode("/CafeteriaApp.Frontend/Areas/Public/Cafeteria/Views/showing cafeterias.php")); //
} // end: if (isset($_POST['submit']))

?>

<!DOCTYPE html>

<html>

  <head>
  
    <link href="/CafeteriaApp.Frontend/css/errors.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="css/materialize.css">

    <script src="js/jquery-3.1.1.min.js"></script>

    <script src="js/materialize.min.js"></script>

  </head>

  <body style="background-image:url('/CafeteriaApp.Frontend/images/login.jpg')">

    <div id="main">

      <div id="navigation">

        &nbsp;

      </div>  

      <div id="page" style="align-content:center;text-align:center">

        <?php echo message(); ?>

        <?php echo form_errors($errors); ?>
        
        <h1 style="font-style: italic;color: white">Login</h1>

        <form action="login.php" method="post" class="login-box" style="width:30%;margin:auto;text-align:center">

          <div class="input-field col s12">

            <label for="email" style="font-size: 25px;color: white">E-mail</label>

            <input type="email" id="email" name="email" value="<?php echo isset($_SESSION["userName"]) ?  htmlentities($_SESSION["userName"]) :'' ; ?>" />

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

        <a href="<?php echo "http://localhost/CafeteriaApp.Frontend/Views/index.php";?>">

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

<div style="align-content:center;text-align:center;font-style:italic;color:white">&copy; 2010-<?php echo date("Y");?></div>