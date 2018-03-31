<?php 
  //require('../functions.php');
  require(__DIR__.'/../Controllers/Role.php');
  require(__DIR__.'/../Controllers/User.php');
  require(__DIR__.'/../Controllers/Customer.php');
  require(__DIR__.'/../vendor/PHPMailer/PHPMailerAutoload.php');
  require(__DIR__.'/TestRequestInput.php');
  require(__DIR__.'/../Controllers/Order.php');

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //decode the json data
    $data = json_decode( file_get_contents('php://input') );

    if ( isset($data->userName, $data->email) && normalize_string($conn, $data->userName) && test_email($data->email) ) {
        $email = checkExistingEmail($conn, $data->email);
        $userName = checkExistingUserName($conn, $data->userName, true);

        if ($email && $userName) {
          echo "User Name and Email already exist !";
        }
        elseif ($userName) {
          echo "User Name already exists !";
        }
        elseif ($email) {
          echo "User Email already exists !";
        }
    }
  }

  if ($_SERVER['REQUEST_METHOD'] == 'PUT') { // isset >> normalizing >> length 
    //decode the json data
    $data = json_decode( file_get_contents('php://input') );

    // $required_fields = array($data->userName, $data->firstName, $data->lastName, $data->phone, $data->email, $data->gender, $data->dob, $data->password);
    //$arr = [$data->userName, $data->firstName, $data->lastName, $data->password];
    //var_dump($data);

    $fields_with_max_lengths = array($data->userName => 100, $data->firstName => 50, $data->lastName => 50, $data->phone => 13, $data->email => 100, $data->password => 100);
    //var_dump($arr);
    if ( normalize_string($conn, $data->userName, $data->firstName, $data->lastName, $data->password) && validate_max_lengths($fields_with_max_lengths) && test_date_of_birth($data->dob) && test_email($data->email) && test_int($data->gender, $data->phone) ) {
      $userName = $data->userName; // $_POST["userName"];
      $firstName = $data->firstName; // $_POST["firstName"];
      $lastName = $data->lastName; // $_POST["lastName"];  
      $phoneNumber = $data->phone; // $_POST["phone"];
      $email = $data->email; // $_POST["email"];
      $image = $data->image; // $_POST["image"];
      $dob = $data->dob;
      $genderId = $data->gender;
      $password = $data->password; // $_POST["password"];

      echo "123";

      if ($image != null) {
        chdir("../uploads"); // go to uploads directory
        $newImageName = $userName . ".jpg"; // get extension from data
        $ifp = fopen($newImageName, "x+");//w+
        fwrite($ifp, base64_decode($image) );
        fclose($ifp);
        $Image = "/CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/uploads/" . $newImageName;
      }
      else {
        //put a default photo
      }

      //get customer role id from db 
      //$roleId = getRoleIdByName($conn, 'Customer');
      $roleId = 2;
      $localeId = 1;

      $user_id = addUser($conn, $userName, $firstName, $lastName, $Image, $email, $phoneNumber, $password, $roleId, $localeId);

      //echo $userId;

      $customer_id = addCustomer($conn, 0.0, $dob, $user_id, $genderId);

      $theuser = attempt_login($conn, $data->email, $data->password);

      $_SESSION['userId'] = $theuser['Id'];
      //echo $_SESSION['userId'];
      $_SESSION['userName'] = $theuser['UserName'];
      $_SESSION['roleId'] = $theuser['RoleId'];
      $_SESSION['langId'] = 1;// if not found
      $_SESSION['Confirmed'] = $theuser['Confirmed'];

      if ($_SESSION['roleId'] != 1) {
        $deliveryTimeId = getCurrentTimeId($conn);
        $deliveryDateId = getCurrentDateId($conn);
        $_SESSION['orderId'] = addOrder($conn, $deliveryDateId, $deliveryTimeId, 1, 1, $_SESSION['userId']);
      }

      $_SESSION['notifications'] = [];

      if ($customer_id) {

        $acc = hash("sha256", $user_id, false);
        $hashKey = hash("sha256", $customer_id . $dob . $user_id . $genderId, false);
         //send confirm mail
        $mail = new PHPMailer();
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
        
        $result = $mail->Send();

        if ($result) {
          echo $user_id;
          //echo "/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Views/confirm.php"; // confirm mail by sending a message and check link
          //header("Location: ../../CafeteriaApp.Frontend/Areas/Public/Cafeteria/Views/showing cafeterias.php");
        }
        else {
          echo "/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Views/registerfailed.php";
        }
        //echo "Customer User Added successfully !";
      }
      else {
        echo "/CafeteriaApp/CafeteriaApp/CafeteriaApp.Frontend/Views/registerfailed.php";
        // echo "Error: failed to create a Customer user !";
      }
    }
  }

  require('../footer.php');
?>