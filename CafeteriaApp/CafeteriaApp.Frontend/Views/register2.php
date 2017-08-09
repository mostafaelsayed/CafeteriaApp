<?php require_once("CafeteriaApp.Backend/session.php");// must be first as it uses cookies ?> 
<?php require_once("CafeteriaApp.Backend/functions.php"); ?>
<?php require_once("CafeteriaApp.Backend/validation_functions.php"); ?>
<?php require_once("CafeteriaApp.Backend/Controllers/User.php"); ?>

 

<?php
//if (isset($_POST['submit'])) 
if ($_SERVER['REQUEST_METHOD']=="POST")
{
  // Process the form
   $data = json_decode(file_get_contents("php://input"));
  // validations
 // $required_fields = array("userName", "password","firstName","lastName","email","phone","image",);
  //validate_presences($required_fields);
  
  //$fields_with_max_lengths = array("userName" => 30);
  //validate_max_lengths($fields_with_max_lengths);
  
  if (empty($errors)) {
    // Perform Create
    $userName = $data->userName  ;//$_POST["userName"];
    $firstName= $data->firstName; //$_POST["firstName"];
    $lastName= $data->lastName ; //$_POST["lastName"];  
    $phoneNumber= $data->phone ;//$_POST["phone"];
     $email=  $data->email;//$_POST["email"];
    $image= $data->image ;//$_POST["image"];
    $dob= $data->dob ;
    $gender= $data->gender ;
    $password= $data->password ;//$_POST["password"];
    $hashed_password = password_encrypt($password);

   $result=registerCustomerUser($conn, $userName,$firstName,$lastName,$image,$email,$phoneNumber,$hashed_password,$dob );

    if ($result) {
      // Success
     // $_SESSION["message"] = "Admin created.";
      redirect_to("index.php");
    } 
  }
    else {
      
      redirect_to("register2.php");
    }
} 

?>