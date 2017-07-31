<?php require_once("CafeteriaApp.Backend/session.php");// must be first as it uses cookies ?> 
<?php require_once("CafeteriaApp.Backend/functions.php"); ?>
<?php require_once("CafeteriaApp.Backend/validation_functions.php"); ?>

<?php
$username = "";

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
			$_SESSION["user_id"] = $found_user["Id"];
			$_SESSION["user_name"] = $found_user["UserName"];

      //get customer id by user id from db 
     $customer_id_json = getCustomerByUserId($conn ,$_SESSION["user_id"] );
      $_SESSION["customer_id"] = json_decode($customer_id_json, true)["Id"];
     

      redirect_to("index.php"); //                              3ala 7asab 
    } else {
      // Failure
      $_SESSION["message"] = "Username/password not found.";
    }
  }
} else {
  // This is probably a GET request
  
} // end: if (isset($_POST['submit']))

?>


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
        <input type="text" name="email" value="<?php echo htmlentities($username); ?>"  />
      </p>
      <p>Password:
        <input type="password" name="password" value="" />
      </p>


      <input type="submit" name="submit" value="Next" />


    </form>
  </div>
</div>


<div style="align-content:center;text-align:center;">&copy; 2010-<?php echo date("Y") ;?></div>
<?php  //include("../includes/layouts/footer.php"); ?>


