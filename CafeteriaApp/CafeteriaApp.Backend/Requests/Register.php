<?php 
 //require_once("CafeteriaApp.Backend/session.php");// must be first as it uses cookies 
require_once("CafeteriaApp.Backend/validation_functions.php"); 
require_once( 'CafeteriaApp.Backend/Controllers/Role.php');
require_once( 'CafeteriaApp.Backend/Controllers/User.php');
require_once( 'CafeteriaApp.Backend/Controllers/Customer.php');
require_once("CafeteriaApp.Backend/connection.php");



if ($_SERVER['REQUEST_METHOD']=="POST"){
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





if ($_SERVER['REQUEST_METHOD']=="PUT"){
    //decode the json data


 $data = json_decode(file_get_contents("php://input"));

$required_fields = array( $data->userName , $data->firstName, $data->lastName,  $data->phone, $data->email, $data->gender, $data->dob,$data->password );
  
//$fields_with_max_lengths = array("userName" => 30);
//validate_max_lengths($fields_with_max_lengths);

if (!empty(test_inputs($conn,$required_fields))) 
{
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


if ($image != null)
    {
      chdir("../uploads"); // go to uploads directory
      $newImageName = $userName.".jpg"; // get extension from data
      $ifp = fopen($newImageName,"x+");//w+
      fwrite($ifp,base64_decode($image));
      fclose($ifp);
      $Image = "/CafeteriaApp.Backend/uploads/".$newImageName;
    }
  
  else{
  
    //put a default photo

  }
      //get customer role id from db 
          $roleId = getRoleIdByName($conn,'Customer');
  $localiId=1;
  $user_id = addUser($conn,$userName,$firstName,$lastName,$Image,$email,$phoneNumber,$hashed_password ,$roleId, $localiId);
  $result = addCustomer($conn,0.0,$dob,$user_id,$gender);
    if($result){
         echo "/CafeteriaApp.Frontend/Views/indexs.php";// confirm  mail by sending a message and check link
             //echo "Customer User Added successfully !";
              }
      else{

        echo "/CafeteriaApp.Frontend/Views/registerfailed.php";
       // echo "Error: failed to create a Customer user !";
      }
  }
  }



require_once("CafeteriaApp.Backend/footer.php");

?>