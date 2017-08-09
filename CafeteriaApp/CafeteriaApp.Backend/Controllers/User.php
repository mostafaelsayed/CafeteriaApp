<?php

require_once('CafeteriaApp.Backend/Controllers/Customer.php');

function getUsers($conn,$backend=false)
{  
  $sql = "select * from User";
  $result = $conn->query($sql);
  if ($result)
  {
    $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);
    $users = json_encode($users);
    if ($backend)
    { 
      return $users;   
    }
    else
    {
      echo $users;
    }
  }
  else
  {
    echo "Error retrieving Users: " . $conn->error;
  }
}

//print_r(json_decode(getUsers($conn), true)) ;

function getUserById($conn,$id,$backend=false)
{
  if (!isset($id)) 
  {
    echo "Error: User Id is not set";
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
      $user = json_encode($user);
      if ($backend)
      { 
        return $user;   
      }
      else
      {
        echo $user;
      } 
    }
    else
    {
      echo "Error retrieving User: " . $conn->error;
    }
  }
}

function registerAdminUser($conn,$userName,$firstName,$lastName,$image,$email,$phoneNumber,$password )
{
  if (checkExistingEmail($conn ,$email ,true)) 
  {
    echo "User Email already exists !";
  }
  elseif (checkExistingUserName($conn ,$userName,true))
  {
    echo "User Name already exists !";
  }
  else
  {
    $sql = "insert into User (UserName , FirstName , LastName , Image , Email , PhoneNumber , Password, RoleId) values (?,?,?,?,?,?,?,?)";
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
      echo "Admin User Added successfully !";
    }
    else
    {
      echo "Error: ".$conn->error;
    }
  }
}

function registerCashierUser($conn,$userName,$firstName,$lastName,$image,$email,$phoneNumber,$password )
{
  if (checkExistingEmail($conn ,$email ,true)) 
  {
    echo "User Email already exists !";
  }
  elseif (checkExistingUserName($conn ,$userName,true))
  {
    echo "User Name already exists !";
  } 
  else
  {
    $sql = "insert into User (UserName , FirstName , LastName , Image , Email , PhoneNumber , Password, RoleId) values (?,?,?,?,?,?,?,?)";
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
      echo "Cashier User Added successfully !";
    }
    else
    {
      echo "Error: ".$conn->error;
    }
  }
}

function registerCustomerUser($conn,$userName,$firstName,$lastName,$image,$email,$phoneNumber,$password )
{
  if (checkExistingEmail($conn ,$email ,true)) 
  {
    echo "User Email already exists !";
    return;
  }
  elseif (checkExistingUserName($conn ,$userName,true))
  {
    echo "User Name already exists !";
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
      echo $user_id;
      if (addCustomer($conn,0.0,$user_id))
      {
        echo "Customer User Added successfully !";
        return true;
      }
      else
      {
        echo "Error: failed to create a Customer user !";
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

//addCustomer($conn,0.0,1);

function editCustomerUser($conn,$userName,$image,$email,$phoneNumber,$password ,$id )
{
  if(checkExistingEmail($conn ,$email ,false)) 
  {
    echo "User Email already exists !";
  }
  elseif (checkExistingUserName($conn ,$userName,false))
  {
    echo "User Name already exists !";
  }
  else
  {
    $sql = "update User set UserName = (?), Image = (?), Email = (?), PhoneNumber= (?) , Password= (?) where Id = (?)"; 
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi",$UserName,$Image,$Email,$PhoneNumber,$Password,$Id);
    $UserName=$userName;
    $Image =$image;
    $Email =$email;
    $PhoneNumber=$phoneNumber;
    $Password=$password;
    $Id=$id;
    if ($stmt->execute()===TRUE)
    {
      echo "User updated successfully";
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
    mysqli_free_result($result);
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

function checkExistingEmail($conn,$email,$register_edit) // problem if he wants to edit his info cause' of his email
{
  $Email=mysqli_real_escape_string($conn, $email);
  $sql = "select count(*) from User where Email= '{$Email}' ";
  $result = $conn->query($sql);
  if ($result)
  {
    $result = mysqli_fetch_array($result, MYSQLI_NUM); 
    mysqli_free_result($result);
    if ($result[0]>0) // if he wants to change the mail and not keeping the old
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

function deleteUser($conn,$id) // cascaded delete ??
{ 
  if (!isset($id))
  {
    echo "Error: Id is not set";
    return;
  }
  else
  {
    //$conn->query("set foreign_key_checks = 0"); // ????????/
    $sql = "delete from User where Id = ".$id . " LIMIT 1";
    if ($conn->query($sql)===TRUE)
    {
      echo "User deleted successfully";
    }
    else
    {
      echo "Error: ".$conn->error;
    }
  }
}

?>