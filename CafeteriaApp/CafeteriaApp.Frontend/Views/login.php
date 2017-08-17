<?php 
require_once("CafeteriaApp.Backend/session.php");// must be first as it uses cookies 
require_once("CafeteriaApp.Backend/connection.php");
require_once("CafeteriaApp.Backend/functions.php");
require_once("CafeteriaApp.Backend/validation_functions.php"); 
require_once("CafeteriaApp.Backend/Controllers/Dates.php"); 
require_once("CafeteriaApp.Backend/Controllers/Customer.php"); 
require_once 'fbConfig.php';


if (isset($_POST['submit'])) { // check if the button 's been pressed
  // Process the form
  
  // validations
  $required_fields = array("email", "password");
  validate_presences($required_fields);
  
  if (empty($errors)) {
    // Attempt Login

		$email = $_POST["email"];
		$password = $_POST["password"];
		
		$found_user = attempt_login($conn,$email, $password);

    if ($found_user) {
      // Success
			// Mark user as logged in
      
			$_SESSION["UserId"] = $found_user["Id"];
			$_SESSION["userName"] = $found_user["UserName"];
      $_SESSION["roleId"] = $found_user["RoleId"];
      $_SESSION["langId"]=1;// if not found
      //get customer id by user id from db 
      $customer_id_json = getCustomerIdByUserId($conn ,$_SESSION["UserId"] ,true);
      $_SESSION["customerId"] = $customer_id_json["Id"];
     
    
      if(!getCurrentDateId($conn)) // make the server add it automatically
      {
        addTodayDate($conn,true);
      }
      
      if( isset($_POST['remember'] ))//set the cookie to a long date
      {
        setcookie(session_name(), session_id(),time()+42000000,'/');
      }

      if(isset($_SERVER['HTTP_REFERER']))//make restrictions on pages that request this page ,otherwise redirect to the same page to cancel his header
      {
        redirect_to(rawurldecode($_SERVER['HTTP_REFERER']));
      }
      else
      {
      //redirect_to(rawurldecode("/CafeteriaApp.Frontend/Areas/Public/Cafeteria/Views/showing cafeterias.php"));
      } //3ala 7asab                               
    }

   
     else {
      // Failure
      $_SESSION["message"] = "Username/password not found.";
    }
  }
}
//if already logged in and called login page
 elseif (isset($_SESSION["UserId"] ) && isset($_SESSION["userName"]) && isset($_SESSION["roleId"]) || isset($_SESSION["userData"]) )// This is probably a GET request
  {
    //  redirect_to(rawurldecode("/CafeteriaApp.Frontend/Areas/Public/Cafeteria/Views/showing cafeterias.php")); //
  
  
} // end: if (isset($_POST['submit']))

?>

  <link href="/CafeteriaApp.Frontend/css/errors.css" rel="stylesheet" type="text/css">

<?php //include("../includes/layouts/header.php"); ?>
<div id="main">
  <div id="navigation">
    &nbsp;
  </div>
  

  <div id="page" style="align-content:center;text-align:center;">
    <?php echo message(); ?>
    <?php echo form_errors($errors); ?>
    
    <h2  style="font-style: italic; color: green;" >Login</h2>
    <form action="login.php" method="post" class="login-box" >

      <p>E-mail:
        <input type="email" name="email" value="<?php echo isset($_SESSION["userName"]) ?  htmlentities($_SESSION["userName"]) :'' ; ?>"  />
      </p>
      <p>Password:
        <input type="password" name="password" value="" />
      </p>


    <input type="checkbox" id="rememberme" name="remember" >
    <label for="rememberme">Remeber me</label>

      <input type="submit" name="submit" value="Next" />

    </form>
<br>

<div>
 <a href="register.php" name="submit" />New User ! </a>
 </div>
 <a href="resetPassword.php" name="submit" />Forgot Password ! </a>
<div>

<?php  $loginURL = $helper->getLoginUrl($redirectURL, $fbPermissions);      ?>
<a href="<?php echo htmlspecialchars($loginURL)  ?>">
     <button  class="btn waves-effect waves-light btn" type="submit" name="action">Facebook Login
                <img src="icons/facebook.png" width="50px" height="50px" >
                 </button></a>
</div>

  </div>
</div>


<div style="align-content:center;text-align:center;">&copy; 2010-<?php echo date("Y") ;?></div>



