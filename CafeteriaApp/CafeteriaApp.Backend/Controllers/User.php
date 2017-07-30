<?php
include 'CafeteriaApp.Backend\connection.php';
require_once( 'CafeteriaApp.Backend\Customer.php');

function getUsers($conn) {
  
  $sql = "select * from User";
  if ($conn->query($sql)) {
      $result = $conn->query($sql);
      $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $users = json_encode($users);
      $conn->close();
      return $users;
  } else {
      echo "Error retrieving Users: " . $conn->error;
  }
}


function attemptLogin($email, $password) {
    $user = getUserByEmail($email);
    if ($user) {
      // found user, now check password
      if (passwordCheck($password, $user["PasswordHash"])) {
        // password matches
        return $user;
      } else {
        // password does not match
        return false;
      }
    } else {
      // user not found
      return false;
    }
  }


function getUserByEmail($conn,$email) {    
   if (!isset($email))
  {
     echo "Error: User Email is not set";
  return;
  }
  else{
    $safe_email = mysqli_real_escape_string($conn, $email);
    
    $query  = "SELECT * ";
    $query .= "FROM User ";
    $query .= "WHERE Email = '{$safe_email}' ";
    $query .= "LIMIT 1";
    $user_set = mysqli_query($conn, $query);
    confirmQuery($user_set);
    if($user = mysqli_fetch_assoc($user_set)) {
      return $user;
    } else {
      return null;
    }
  }}
  

function confirmQuery($result_set) {
    if (!$result_set) {
      die("Database query failed."); //  not give the user who wants to login any info
    }
  }

  function passwordCheck($password, $existing_hash) {
    // existing hash contains format and salt at start
    $hash = crypt($password, $existing_hash);
    if ($hash === $existing_hash) {
      return true;
    } else {
      return false;
    }
  }




function registerCustomerUser($conn,$userName,$firstName,$lastName,$image,$email,$phoneNumber,$password, ) {
   if(checkExistingEmail($conn ,$email ,true)) 
 { echo "User Email already exists !";
  }
elseif(  checkExistingUserName($conn ,$userName,true))
   { echo "User Name already exists !";
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
  $RoleId = ;    // customer role
  //$conn->query($sql);
  if ($stmt->execute()===TRUE) {
    
    $user_id =  mysqli_insert_id($conn);
    if(addCustomer($conn,0.0,$user_id))
    {
     echo "User Added successfully !";
    }
    else
    {
      echo "Error: failed to create a customer for the user !";
    }
  }
  else {
    echo "Error: ".$conn->error;
  }
}
}





function editCustomerUser($conn,$userName,$image,$email,$phoneNumber,$password ,$id ) {
 if(checkExistingEmail($conn ,$email ,false)) 
 { echo "User Email already exists !";
  }
elseif(  checkExistingUserName($conn ,$userName,false))
   { echo "User Name already exists !";
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
  //$conn->query($sql);
  if ($stmt->execute()===TRUE) {
    echo "User updated successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}
}


function checkExistingUserName($conn,$userName ,$register_edit)
{
  $sql = "select count(*) from User where UserName=(?)";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s",$UserName);
  $UserName=$userName;
  //$conn->query($sql);
  if ($stmt->execute()===TRUE) {
  $result = mysqli_fetch_all($result, MYSQLI_NUM);  
  }
else {
    echo "Error: ".$conn->error;
  }


if(  $result[0] > 0 )
  { return true;
  }
  else
  {
    return false;
  }
}

  
// need to know if he's entering the same email or not as the condition will differ , validation , times , login ,logout


function checkExistingEmail($conn,$email,$register_edit) // problem if he wants to edit his info cause' of his email
{
  $sql = "select count(*) from User where Email=(?)";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s",$Email);
  $Email=$email;
  //$conn->query($sql);
  if ($stmt->execute()===TRUE) {
  $result = mysqli_fetch_all($result, MYSQLI_NUM);  
  }
  else {
    echo "Error: ".$conn->error;
  }

  if( $result[0] > 0  ) // if he wnats to change the mail and not keeping the old
  { 
  return true; // exist
  }
  else
  {
    return false;//not exist
  }

}



function deleteUser($conn,$id) { // cascaded delete ??
 if (!isset($id))
  {
     echo "Error: Id is not set";
  return;
  }
  else{
  //$conn->query("set foreign_key_checks = 0"); // ????????/
  $sql = "delete from User where Id = ".$id . "LIMIT 1";
  if ($conn->query($sql)===TRUE) {
    echo "User deleted successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}
}





if ($_SERVER['REQUEST_METHOD']=="GET") {
  if (isset($_GET["action"]) && $_GET["action"]=="getUsers"){
    getUsers($conn);
  }
  else {
    echo "Error occured while returning Users";
  }
}

if ($_SERVER['REQUEST_METHOD']=="POST"){
    //decode the json data
    $data = json_decode(file_get_contents("php://input"));
    if (isset($data->action) && $data->action == "addUser"){
      if ($data->Name != null){
        addUser($conn,$data->Name);
      }
      else{
        echo "name is required";
      }
  }
}

if ($_SERVER['REQUEST_METHOD']=="PUT"){
    //decode the json data
    $data = json_decode(file_get_contents("php://input"));
    //echo $data;
      if ($data->Name != null && $data->Id != null) {
        //if ($data->action == "addcafeteria"){
        editUser($conn,$data->Name,$data->Id);
      }
      else{
        echo "name is required";
      }
  //}
}

 ?>
