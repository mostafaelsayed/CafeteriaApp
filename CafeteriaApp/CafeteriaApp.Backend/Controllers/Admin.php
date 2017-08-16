<?php

function addAdmin($conn,$userName,$firstName,$lastName,$image,$email,$phoneNumber,$password )
{
  if (checkExistingEmail($conn ,$email ) || checkExistingUserName($conn ,$userName,true)) 
  {
   return;
  }
  elseif(!isset($firstName) ||!isset($lastName) || !isset($phoneNumber) || !isset($password))
  {
  return;
  }
  else
  {
    $sql = "insert into User (UserName , FirstName , LastName , Image , Email , PhoneNumber , PasswordHash, RoleId) values (?,?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssi",$UserName,$FirstName,$LastName,$Image,$Email,$PhoneNumber,$Password,$RoleId);
    $UserName = $userName;
    $FirstName = $firstName;
    $LastName = $lastName;
    $Image = $image;
    $Email = $email;
    $PhoneNumber = $phoneNumber;
    $Password = $password;
    $RoleId =1 ;    // admin role
    if ($stmt->execute()===TRUE)
    {
      $user_id =  mysqli_insert_id($conn);
      return "Admin User Added successfully !";
    }
    else
    {
      echo "Error: ".$conn->error;
    }
  }
}

?>