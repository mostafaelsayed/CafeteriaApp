<?php
  require(__DIR__.'/../functions.php');
  require(__DIR__.'/../ImageHandle.php');

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

  function addUser($conn, $userName, $firstName, $lastName, $image, $email, $phoneNumber, $password, $roleId, $localeId = 1) {
    $sql = "insert into user (UserName, FirstName, LastName, Image, Email, PhoneNumber, PasswordHash, RoleId, LocaleId) values (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssii", $userName, $firstName, $lastName, $Image, $email, $phoneNumber, password_encrypt($password), $roleId, $localeId);

    if ( isset($image) ) {
      $Image = addImageFile($image);
    }
    
    if ($stmt->execute() === TRUE) {    
      $user_id = mysqli_insert_id($conn);
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
      $result = $conn->query("select Image from user where Id = " . $id);
      $userImage = mysqli_fetch_assoc($result)['Image'];
      mysqli_free_result($result);
      $sql = "update user set UserName = (?), FirstName = (?), LastName = (?), Email = (?), Image = (?), PhoneNumber = (?), RoleId = (?) where Id = (?)"; 
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ssssssii", $userName, $firstName, $lastName, $email, $Image, $phoneNumber, $roleId, $id);
      
      if (isset($image) && $image != $userImage) {
        $Image = editImage($image, $userImage);
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

  // function updateUserPasswordById($conn,$password,$id)
  // {
  //    if (!isset($password) || !isset($id)) 
  //   {
  //     //echo "User password is empty !";
  //     return;
  //   }
  //   else
  //   {
  //     $sql = "update User set PasswordHash = (?) where Id = (?)"; 
  //     $stmt = $conn->prepare($sql);
  //     $stmt->bind_param("si",$Password,$Id);
  //     $Id = $id;
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