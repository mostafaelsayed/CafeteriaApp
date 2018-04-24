<?php
  require(__DIR__ . '/../ImageHandle.php');
  require(__DIR__ . '/../lib/vendor/autoload.php');

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;


function generate_salt($length)
{
    // Not 100% unique, not 100% random, but good enough for a salt
    // MD5 returns 32 characters
    $unique_random_string = md5(uniqid(mt_rand(), true));
    // Valid characters for a salt are [a-zA-Z0-9./]
    $base64_string = base64_encode($unique_random_string);
    // But not '+' which is valid in base64 encoding
    $modified_base64_string = str_replace('+', '.', $base64_string);
    // Truncate string to the correct length
    $salt = substr($modified_base64_string, 0, $length);
    return $salt;
}

function password_encrypt($password)
{
    $hash_format     = "$2y$10$"; // Tells PHP to use Blowfish with a "cost" or rounds of 10
    $salt_length     = 22; // Blowfish salts should be 22-characters or more
    $salt            = generate_salt($salt_length);
    $format_and_salt = $hash_format . $salt;
    $hash            = crypt($password, $format_and_salt);
    return $hash;
}



  function getUsers($conn) {
    $sql = "select * from user";
    $result = $conn->query($sql);
    
    if ($result) {
      $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
      mysqli_free_result($result);
      return $users;
    }
    else {
      echo "Error retrieving Users: ", $conn->error;
    }
  }

  function getUserById($conn, $id) {
    $sql = "select * from user where Id = " . $id . " LIMIT 1";
    $result = $conn->query($sql);

    if ($result) {
      $user = mysqli_fetch_assoc($result);
      mysqli_free_result($result);
      return $user;
    }
    else {
      echo "Error retrieving User: ", $conn->error;
    }
  }

  function addUser($conn, $firstName, $lastName, $image, $email, $phoneNumber, $password, $dateOfBirth, $gender, $roleId, $localeId = 1) {
    $sql = "insert into user (UserName, FirstName, LastName, Image, Email, PhoneNumber, PasswordHash, RoleId, LocaleId) values (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $pass = password_encrypt($password);
    $stmt->bind_param("sssssssii", $email, $firstName, $lastName, $Image, $email, $phoneNumber, $pass, $roleId, $localeId);

    // die(var_dump($image));

    if ( isset($image) && $image['size'] != 0) {
      $Image = addImageFile($image, $email);
    }
    
    if ($stmt->execute() === TRUE) {    
      $user_id = mysqli_insert_id($conn);

      try {

        $acc = hash("sha256", $user_id, false);
        $hashKey = hash("sha256", $phoneNumber . $user_id, false);
         //send confirm mail
        $mail = new PHPMailer(true);                          // Passing `true` enables exceptions
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = "smtp.gmail.com";                       // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'mostafaelsayed9419@gmail.com';     // SMTP username
        $mail->Password = 'nacxgewvqqhvydoa';                 // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to
        $mail->setFrom('mostafaelsayed9419@gmail.com', 'Cafeteria App');
        $mail->addAddress($email, "");
        $mail->Subject = "Cafeteria App Info Confirm";
        $mail->Body = "thank you for joining us";

        // only on localhost
        $mail->SMTPOptions = array(
          'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
          )
        );
        
        $result = $mail->Send();
      }

      catch (phpmailerException $e) {
        echo $e->errorMessage();
      }

      catch (Exception $e) {
        echo $e->getMessage();
      }
      
      return $user_id;
    }
    else {
      echo "Error: ", $conn->error;
      return false;
    }
  }

  function editUser($conn, $userName, $firstName, $lastName, $email, $image, $phoneNumber, $roleId, $id) {
    $userUserName = mysqli_fetch_assoc( $conn->query("select UserName from user where Id = " . $id) )['UserName'];

    if ( !($userUserName == $userName) && checkExistingUserName($conn, $userName, true) ) {
      return;
    }
    else {
      $result = $conn->query("select * from user where Id = " . $id);
      $userImage = mysqli_fetch_assoc($result)['Image'];
      $name = mysqli_fetch_assoc($result)['Email'];
      mysqli_free_result($result);
      $sql = "update user set UserName = (?), FirstName = (?), LastName = (?), Email = (?), Image = (?), PhoneNumber = (?), RoleId = (?) where Id = (?)"; 
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ssssssii", $userName, $firstName, $lastName, $email, $Image, $phoneNumber, $roleId, $id);
      
      if ($image != null) {
        $Image = editImage($image, $userImage, $email);
      }
      else {
        $Image = $image;
      }

      if ($stmt->execute() === TRUE) {
        echo "User updated successfully";
      }
      else {
        echo "Error: ", $conn->error;
      }
    }
  }

  // function updateUserPasswordByEmail($conn,$password,$email)
  // {
  //   if (!isset($password) || !isset($email)) 
  //   {
  //     //echo "User password is empty !";
  //     return;
  //   }
  //   else
  //   {
  //     $sql = "update User set PasswordHash = (?) where Email = (?)"; 
  //     $stmt = $conn->prepare($sql);
  //     $stmt->bind_param("ss",$Password,$Email);
  //     $Email = $email;
  //     $Password = $password;
  //     if ($stmt->execute() === TRUE)
  //     {
  //       return "User updated successfully";
  //     }
  //     else
  //     {
  //       echo "Error: ".$conn->error;
  //     }
  //   }
  // }

  function updateUserPasswordById($conn,$password,$id)
  {
     if (!isset($password) || !isset($id)) 
    {
      //echo "User password is empty !";
      return;
    }
    else
    {
      $sql = "update User set PasswordHash = (?) where Id = (?)"; 
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("si",$Password,$Id);
      $Id = $id;
      $Password = $password;
      if ($stmt->execute() === TRUE)
      {
        return true;
      }
      else
      {
        echo "Error: ".$conn->error;
      }
    }
  }

  function activateUser($conn, $id) {
    $sql = "update user set Confirmed = True where Id = (?)"; 
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute() === TRUE) {
      return true;
    }
    else {
      echo "Error: ", $conn->error;
    }
  }

  function checkExistingUserName($conn, $userName, $register_edit) {
    $UserName = mysqli_real_escape_string($conn, $userName);
    $sql = "select count(*) from user where UserName = '{$UserName}'";
    $result = $conn->query($sql);

    if ($result) {
      $result = mysqli_fetch_array($result, MYSQLI_NUM); 
      //mysqli_free_result($result);
      $result = (int)$result[0];

      if ($result > 0) { // if he wnats to change the mail and not keeping the old
        return true; // exist
      }
      else {
        return false;//not exist
      }
    }
    else {
      echo "Error: ", $conn->error;
    }
  }
    
  // need to know if he's entering the same email or not as the condition will differ
  function checkExistingEmail($conn, $email) { // problem if he wants to edit his info cause' of his email
    $email = trim($email);
    $Email = mysqli_real_escape_string($conn, $email);
    $sql = "select count(*) from user where Email = '{$Email}'";
    $result = $conn->query($sql);

    if ($result) {
      $result = mysqli_fetch_array($result, MYSQLI_NUM);
      $result = (int)$result[0];

      if ($result > 0) { // if he wants to change the mail and not keeping the old 
        return true; // exist
      }
      else {
        return false;//not exist
      }

      mysqli_free_result($result);
    }
    else {
      echo "Error: ", $conn->error;
    }
  }

  function deleteUser($conn, $id) { // cascaded delete ??
    //$conn->query("set foreign_key_checks = 0"); // ????????/
    $sql = "delete from user where Id = " . $id . " LIMIT 1";

    if ($conn->query($sql) === TRUE) {
      return "User deleted successfully";
    }
    else {
      echo "Error: ", $conn->error;
    }
  }
?>