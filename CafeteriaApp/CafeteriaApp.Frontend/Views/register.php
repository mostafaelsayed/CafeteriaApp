<?php require_once("CafeteriaApp.Backend/session.php");// must be first as it uses cookies ?> 
<?php require_once("CafeteriaApp.Backend/functions.php"); ?>
<?php require_once("CafeteriaApp.Backend/validation_functions.php"); ?>
<?php require_once("CafeteriaApp.Backend/Controllers/User.php"); ?>

<?php //confirm_logged_in(); ?>

<?php
if (isset($_POST['submit'])) {
  // Process the form
  
  // validations
  $required_fields = array("userName", "password","firstName","lastName","email","phone","image",);
  validate_presences($required_fields);
  
  $fields_with_max_lengths = array("userName" => 30);
  validate_max_lengths($fields_with_max_lengths);
  
  if (empty($errors)) {
    // Perform Create
    $userName = $_POST["userName"];
    $firstName= $_POST["firstName"];
    $lastName= $_POST["lastName"];  
    $phoneNumber= $_POST["phone"];
     $email= $_POST["email"];
    $image= $_POST["image"];
    $hashed_password = password_encrypt($_POST["password"]);

   $result=registerCustomerUser($conn, $userName,$firstName,$lastName,$image,$email,$phoneNumber,$hashed_password );

    if ($result) {
      // Success
     // $_SESSION["message"] = "Admin created.";
      redirect_to("index.php");
    } else {
      // Failure
      //$_SESSION["message"] = "Admin creation failed.";
    }
  }
} else {
  // This is probably a GET request
  
} // end: if (isset($_POST['submit']))

?>

<?php //$layout_context = "admin"; ?>
<?php // include("../includes/layouts/header.php"); ?>
<div id="main">
  <div id="navigation">
    &nbsp;
  </div>
  <div id="page">
    <?php echo message(); ?>
    <?php echo form_errors($errors); ?>
    
    <h2>Create Admin</h2>
    <form action="register.php" method="post" style="align-content:center;text-align:center;">
      <p>User Name:
        <input type="text" name="userName" value="" />
      </p>
       <p>Password:
        <input type="password" name="password" value="" />
      </p>
      <p>First Name:
        <input type="text" name="firstName" value="" />
      </p>
      <p>Last Name:
        <input type="text" name="lastName" value="" />
      </p>
      <p>E-mail:
        <input type="text" name="email" value="" />
      </p>
      <p>Phone:
        <input type="text" name="phone" value="" />
      </p>
      <p>Image:
        <input type="text" name="image" value="" />
        </p>
     
      <input type="submit" name="submit" value="Next" />
            <input type="submit" name="cancel" value="Cancel" />

      <!-- <a href="manage_admins.php">Cancel</a> -->
    </form>
    <br />
    
  </div>
</div>

<?php //include("../includes/layouts/footer.php"); ?>
