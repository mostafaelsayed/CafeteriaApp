<?php 
// require_once("CafeteriaApp.Backend/session.php");// must be first as it uses cookies 
//  require_once("CafeteriaApp.Backend/functions.php"); 
//  require_once("CafeteriaApp.Backend/validation_functions.php"); 
 //require_once("CafeteriaApp.Backend/Controllers/User.php"); 

 


// //if (isset($_POST['submit'])) 
// if ($_SERVER['REQUEST_METHOD']=="POST")
// {
//   // Process the form
//    $data = json_decode(file_get_contents("php://input"));
//   // validations
//  // $required_fields = array("userName", "password","firstName","lastName","email","phone","image",);
//   //validate_presences($required_fields);
  
//   //$fields_with_max_lengths = array("userName" => 30);
//   //validate_max_lengths($fields_with_max_lengths);
  
//   if (empty($errors)) {
//     // Perform Create
//     $userName = $data->userName  ;//$_POST["userName"];
//     $firstName= $data->firstName; //$_POST["firstName"];
//     $lastName= $data->lastName ; //$_POST["lastName"];  
//     $phoneNumber= $data->phone ;//$_POST["phone"];
//      $email=  $data->email;//$_POST["email"];
//     $image= $data->image ;//$_POST["image"];
//     $dob= $data->dob ;
//     $gender= $data->gender ;
//     $password= $data->password ;//$_POST["password"];
//     $hashed_password = password_encrypt($password);

//    $result=registerCustomerUser($conn, $userName,$firstName,$lastName,$image,$email,$phoneNumber,$hashed_password,$dob,  $gender );

//     if ($result) {
//       // Success
//      // $_SESSION["message"] = "Admin created.";
//       echo "/CafeteriaApp.Frontend/Views/indexs.php";
//       //redirect_to("");
//     } 
//   }
//     else {
//             echo "/CafeteriaApp.Frontend/Views/registerfailed.php";

//      // redirect_to("register2.php");
//     }
// } 


require_once( 'CafeteriaApp.Backend/Controllers/User.php');
require_once("CafeteriaApp.Backend/connection.php");
require_once ('checkResult.php');






// if ($_SERVER['REQUEST_METHOD']=="GET") {
//   if (isset($_GET["action"]) && $_GET["action"]=="getRoles"){
//     getRoles($conn);
//   }
//   else {
//     echo "Error occured while returning Roles";
//   }
// }

if ($_SERVER['REQUEST_METHOD']=="POST")
{
    //decode the json data
    $data = json_decode(file_get_contents("php://input"));
    if (isset($data->userName) && isset($data->email))
    {
        $email = checkExistingEmail($conn,$data->email);
        $userName = checkExistingUserName($conn,$data->userName,true);

        if ($email && $userName)
        {
            echo "User Name and Email already exist !";
        }
        else if ($userName)
        {
            echo "User Name already exists !";
        }
        else if ($email)
        {
            echo "User Email already exists !";
        }
    }
}

// if ($_SERVER['REQUEST_METHOD']=="PUT"){
//     //decode the json data
//     $data = json_decode(file_get_contents("php://input"));
//     //echo $data;
//       if ($data->Name != null && $data->Id != null) {
//         //if ($data->action == "addcafeteria"){
//         editRole($conn,$data->Name,$data->Id);
//       }
//       else{
//         echo "name is required";
//       }
//   //}
// }


require_once("CafeteriaApp.Backend/footer.php");

?>