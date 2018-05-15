<?php
  require(__DIR__ . '/../ImageHandle.php');
  require(__DIR__ . '/../mail-sender.php');

  function generate_salt($length) {
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

  function password_encrypt($password) {
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

  function addUser($conn, $firstName, $lastName, $image, $email, $phoneNumber, $password, $gender, $roleId, $dateOfBirth = '1990-1-1', $localeId = 1, $x1 = null, $y1 = null, $w = null, $h = null) {
    $x = checkExistingEmail($conn, $email);

    if ($x) {
      return "email already existed";
    }

    $sql = "insert into user (FirstName, LastName, Image, Email, PhoneNumber, PasswordHash, Gender, RoleId, DateOfBirth, LocaleId) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $pass = password_encrypt($password);
    $stmt->bind_param("ssssssiisi", $firstName, $lastName, $Image, $email, $phoneNumber, $pass, $gender, $roleId, $dateOfBirth, $localeId);
    
    if ($image != null && $image['size'] != 0) {

      $Image = addImageFile($image, $email, $x1, $y1, $w, $h);
    }
    
    if ($stmt->execute() === TRUE) {    
      $user_id = mysqli_insert_id($conn);
      sendMail($email, $user_id, $phoneNumber);
      
      return $user_id;
    }
    else {
      echo "Error: ", $conn->error;

      return false;
    }
  }

  function editUser($conn, $firstName, $lastName, $email, $image, $phoneNumber, $roleId, $id, $gender, $dateOfBirth, $x1 = null, $y1 = null, $w = null, $h = null) {
    $userEmail = mysqli_fetch_assoc( $conn->query("select Email from user where Id = " . $id) )['Email'];

    if ( !($userEmail == $email) && checkExistingEmail($conn, $email) ) {
      return;
    }
    else {
      if ($userEmail != $email) {
        sendMail($email, $id, $phoneNumber);
      }

      $result = $conn->query("select Image from user where Id = " . $id);
      $userImage = mysqli_fetch_assoc($result)['Image'];
      $name = $email;
      mysqli_free_result($result);

      if ($image != null) {
        $Image = editBinaryImage($image, $userImage, $name, $x1, $y1, $w, $h);
      }
      else {
        $Image = mysqli_fetch_assoc( $conn->query("select Image from user where Id = " . $id) )['Image'];
        var_dump($Image);
      }

      $sql = "update user set FirstName = (?), LastName = (?), Email = (?), Image = (?), PhoneNumber = (?), RoleId = (?), Gender = (?), DateOfBirth = (?) where Id = (?)"; 
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssiisi", $firstName, $lastName, $email, $Image, $phoneNumber, $roleId, $gender, $dateOfBirth, $id);

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

  function updateUserPasswordById($conn, $password, $id) {
    if ( !isset($password) || !isset($id) ) {
      //echo "User password is empty !";
      return;
    }
    else {
      $sql = "update User set PasswordHash = (?) where Id = (?)"; 
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("si", $Password, $Id);
      $Id = $id;
      $Password = $password;
      if ($stmt->execute() === TRUE) {
        return true;
      }
      else {
        echo "Error: " . $conn->error;
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