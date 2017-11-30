<?php 
 //require_once("CafeteriaApp.Backend/session.php");// must be first as it uses cookies 
//require_once("CafeteriaApp.Backend/validation_functions.php"); 
require_once('CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Controllers/Role.php');
require_once('CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Controllers/User.php');
require_once('CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Controllers/Customer.php');
require_once('CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/connection.php');
require('CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Views/PHPMailer/PHPMailerAutoload.php');
require_once('TestRequestInput.php');




if ($_SERVER['REQUEST_METHOD']=="POST"){
    //decode the json data
    $data = json_decode(file_get_contents("php://input"));
    if (isset($data->userName) && isset($data->email) &&normalize_string($conn,$data->userName) &&normalize_string($conn,$data->email))
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



if ($_SERVER['REQUEST_METHOD']=="PUT"){//isset >> normalizing >> length 
    //decode the json data
 $data = json_decode(file_get_contents("php://input"));

$required_fields = array( $data->userName , $data->firstName, $data->lastName,  $data->phone, $data->email, $data->gender, $data->dob,$data->password );
  

$fields_with_max_lengths = array($data->userName  => 100 , $data->firstName=>50 ,$data->lastName=>50,$data->phone=>13, $data->email=>100,$data->password=>100 );


if (!empty(test_user_input($conn,$required_fields)) && validate_max_lengths($fields_with_max_lengths) &&test_date_of_birth($data->dob)) 
{
    $userName = $data->userName  ;//$_POST["userName"];
    $firstName= $data->firstName; //$_POST["firstName"];
    $lastName= $data->lastName ; //$_POST["lastName"];  
    $phoneNumber= $data->phone ;//$_POST["phone"];
    $email=  $data->email;//$_POST["email"];
    $image= $data->image ;//$_POST["image"];
    $dob= $data->dob ;
    $genderId= $data->gender ;
    $password= $data->password ;//$_POST["password"];


if ($image != null)
    {
      chdir("../uploads"); // go to uploads directory
      $newImageName = $userName.".jpg"; // get extension from data
      $ifp = fopen($newImageName,"x+");//w+
      fwrite($ifp,base64_decode($image));
      fclose($ifp);
      $Image = "/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/uploads/".$newImageName;
    }
  
  else{
  
    //put a default photo

  }
      //get customer role id from db 
  $roleId = getRoleIdByName($conn,'Customer');

  $localeId=1;

  $user_id = addUser($conn,$userName,$firstName,$lastName,$Image,$email,$phoneNumber,$password ,$roleId, $localeId);

  $customer_id = addCustomer($conn,0.0,$dob,$user_id,$genderId);

    if($customer_id){

      $acc=hash ("sha256",$user_id,false);
      $hashKey=hash ("sha256",$customer_id.$dob.$user_id.$genderId,false);
       //send confirm mail
      $mail =new PHPMailer();
      $mail->isSMTP();                                      // Set mailer to use SMTP
      $mail->Host = "smtp.gmail.com";  // Specify main and backup SMTP servers
      $mail->SMTPAuth = true;                               // Enable SMTP authentication
      $mail->Username = 'mmhnabawy@gmail.com';                 // SMTP username
      $mail->Password = 'mmhnabawy';                           // SMTP password
      $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
      $mail->Port = 587;                                    // TCP port to connect to
      $mail->setFrom ('mm_h434@yahoo.com', 'Cafetria App');
      $mail->addAddress($email,"");
      $mail->Subject = "Cafetria App Info Confirm";
      $mail->Body = "thank you for joining us, click <a href='localhost/CafeteriaApp.Frontend/Views/infoConfirm?acc={$acc}&hashKey={$hashKey}'>here</a> to activate your account .";
      
      $result =$mail->Send();

      if($result)
      {
         echo "/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Views/confirm.php";// confirm  mail by sending a message and check link
      }
      else
      {    echo "/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Views/registerfailed.php";
     
      }
             //echo "Customer User Added successfully !";
              }
      else{

        echo "/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Views/registerfailed.php";
       // echo "Error: failed to create a Customer user !";
      }
  }
  }

require('CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/footer.php');

?>