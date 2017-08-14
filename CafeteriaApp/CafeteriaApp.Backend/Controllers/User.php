<?php

require_once('CafeteriaApp.Backend/Controllers/Customer.php');

function getUsers($conn)
{  
  $sql = "select * from User";
  $result = $conn->query($sql);
  if ($result)
  {
    $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);
      return $users;   
    
  }
  else
  {
    echo "Error retrieving Users: " . $conn->error;
  }
}



function getUserById($conn,$id)
{
  if (!isset($id)) 
  {
    //echo "Error: User Id is not set";
    return;
  }
  else
  {
    $sql = "select * from User where Id=".$id." LIMIT 1";
    $result = $conn->query($sql);
    if ($result)
    {
      $user = mysqli_fetch_assoc($result);
      mysqli_free_result($result);
        return $user;   
     
    }
    else
    {
      echo "Error retrieving User: " . $conn->error;
    }
  }
}

function registerAdminUser($conn,$userName,$firstName,$lastName,$image,$email,$phoneNumber,$password )
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
    $RoleId =1 ;    // customer role
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

function registerCashierUser($conn,$userName,$firstName,$lastName,$image,$email,$phoneNumber,$password )
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
    $RoleId =2 ;    // customer role
    if ($stmt->execute()===TRUE)
    {
      $user_id =  mysqli_insert_id($conn);
      return "Cashier User Added successfully !";
    }
    else
    {
      echo "Error: ".$conn->error;
    }
  }
}



function registerCustomerUser($conn,$userName,$firstName,$lastName,$image,$email,$phoneNumber,$password,$dob,$genderId ) {
   if (checkExistingEmail($conn ,$email ) || checkExistingUserName($conn ,$userName,true)) 
  {
   return;
  }
  elseif(!isset($firstName) ||!isset($lastName) || !isset($phoneNumber) || !isset($password) || !isset($dob) || !isset($genderId))
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
  $RoleId =2 ;    // customer role
  //$conn->query($sql);
  if ($stmt->execute()===TRUE) {
    
    $user_id =  mysqli_insert_id($conn);
    //echo $user_id;

    if(addCustomer($conn,0.0,$dob,$user_id,$genderId))
      {
        return true;
      }
      else
      {
        return false;
      }
    }
    else
    {
      echo "Error: ".$conn->error;
      return false;
    }
  }
}



function editCustomerUser($conn,$userName,$image,$phoneNumber,$password ,$id )
{
   if ( checkExistingUserName($conn ,$userName,true)) 
  {
   return;
  }
  elseif(!isset($phoneNumber) || !isset($password) || !isset($image))
  {
  return;
  }
  else
  {
    $sql = "update User set UserName = (?), Image = (?), PhoneNumber= (?) , PasswordHash= (?) where Id = (?)"; 
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi",$UserName,$Image,$PhoneNumber,$Password,$Id);
    $UserName=$userName;
    $Image =$image;
    $PhoneNumber=$phoneNumber;
    $Password=$password;
    $Id=$id;
    if ($stmt->execute()===TRUE)
    {
      return "User updated successfully";
    }
    else
    {
      echo "Error: ".$conn->error;
    }
  }
}


function updateUserPasswordByEmail($conn,$password ,$email)
{
  if( !isset($password) || !isset($email)) 
  {
    //echo "User password is empty !";
    return;
  }
  else
  {
    $sql = "update User set PasswordHash= (?) where Email = (?)"; 
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss",$Password,$Email);
    $Email=$email;
    $Password=$password;
    if ($stmt->execute()===TRUE)
    {
      return "User updated successfully";
    }
    else
    {
      echo "Error: ".$conn->error;
    }
  }
}

function updateUserPasswordById($conn,$password ,$id)
{
   if( !isset($password) || !isset($id)) 
  {
    //echo "User password is empty !";
    return;
  }
  else
  {
    $sql = "update User set PasswordHash= (?) where Id = (?)"; 
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si",$Password,$Id);
    $Id=$id;
    $Password=$password;
    if ($stmt->execute()===TRUE)
    {
      return "User updated successfully";
    }
    else
    {
      echo "Error: ".$conn->error;
    }
  }
}


function checkExistingUserName($conn,$userName ,$register_edit)
{
  $UserName=mysqli_real_escape_string($conn,$userName);
  $sql = "select count(*) from User where UserName='{$UserName}'";
  $result = $conn->query($sql);
  if ($result)
  {
    $result = mysqli_fetch_array($result, MYSQLI_NUM); 
    //mysqli_free_result($result);
    if ($result[0]>0) // if he wnats to change the mail and not keeping the old
    { 
      return true; // exist
    }
    else
    {
      return false;//not exist
    }
  }
  else
  {
    echo "Error: ".$conn->error;
  }
}
  
// need to know if he's entering the same email or not as the condition will differ

function checkExistingEmail($conn,$email) // problem if he wants to edit his info cause' of his email
{ 
  $email = trim($email);
  $Email=mysqli_real_escape_string($conn, $email);
  $sql = "select count(*) from User where Email= '{$Email}' ";
  $result = $conn->query($sql);
  if ($result)
  {
    $result = mysqli_fetch_array($result, MYSQLI_NUM); 
    
    if ($result[0]>0) // if he wants to change the mail and not keeping the old
    { 
      return true; // exist
    }
    else
    {
      return false;//not exist
    }
    mysqli_free_result($result);
  }
  else
  {
    echo "Error: ".$conn->error;
  }
}

function deleteUser($conn,$id) // cascaded delete ??
{ 
  if (!isset($id))
  {
    //echo "Error: Id is not set";
    return;
  }
  else
  {
    //$conn->query("set foreign_key_checks = 0"); // ????????/
    $sql = "delete from User where Id = ".$id . " LIMIT 1";
    if ($conn->query($sql)===TRUE)
    {
      return "User deleted successfully";
    }
    else
    {
      echo "Error: ".$conn->error;
    }
  }
}

?>