<?php 
require_once("CafeteriaApp.Backend/session.php");// must be first as it uses cookies

function getCustomers($conn)
{
  $sql = "select * from Customer";
  $result = $conn->query($sql);
  if ($result)
  {
    $result = $conn->query($sql);
    $customers = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);
      return $customers;
    
  }
  else
  {
    echo "Error retrieving customers: " . $conn->error;
  }
}

function getCustomerById($conn ,$id)
{
  if (!isset($id))
  {
    //echo "Error: Customer Id is not set";
    return;
  }
  else
  {
    $sql = "select * from Customer where Id =".$id." LIMIT 1";
    $result = $conn->query($sql);
    if ($result) {
      $customers = mysqli_fetch_assoc($result);
      mysqli_free_result($result);
        return $customers;
     
    }
    else
    {
      echo "Error retrieving Customer: " . $conn->error;
    }
  }
}

function getCurrentCustomerinfoByUserId($conn)
{
  if (isset($_SESSION["UserId"]))
  {
    $userId=$_SESSION["UserId"];
  }
  if (!isset($userId))
  {
    //echo "Error: User Id is not set";
    return;
  }
  else
  {
    $sql = "select * from Customer inner join User on Customer.UserId=User.Id  where Customer.UserId =".$userId." LIMIT 1";
    $result = $conn->query($sql);
    if ($result)
    {
      $customer = mysqli_fetch_assoc($result);
      mysqli_free_result($result);
        return $customer;
    }
    else
    {
      echo "Error retrieving customer: " . $conn->error;
    }
  }
}

function getCustomerByUserId($conn,$userId)
{
  if (!isset($userId))
  {
    //echo "Error: User Id is not set";
    return;
  }
  else
  {
    $sql = "select * from Customer where UserId =".$userId." LIMIT 1";
    $result = $conn->query($sql);
    if ($result)
    {
      $customer = mysqli_fetch_assoc($result);
      mysqli_free_result($result);
        return $customer;
      
    }
    else
    {
      echo "Error retrieving customer: " . $conn->error;
    }
  }
}


function getCustomerIdByUserId($conn,$userId)
{
  if (!isset($userId))
  {
    echo "Error: User Id is not set";
    return;
  }
  else
  {
    $sql = "select Id from Customer where UserId =".$userId." LIMIT 1";
    $result = $conn->query($sql);
    if ($result)
    {
      $customer = mysqli_fetch_assoc($result);
      mysqli_free_result($result);
     
        return $customer;
    }
    else
    {
      echo "Error retrieving customer: " . $conn->error;
    }
  }
}



function addCustomer($conn,$cred,$dob,$userId,$genderId) {
   if( !isset($cred) || !isset($dob) || !isset($userId)  || !isset($genderId))
 {
 //echo "Error: Credit is not set";
  return;
  }
  else {
  $sql = "insert into Customer (Credit,DateOfBirth,UserId,GenderId) values (?,?,?,?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("dsii",$Credit,$Dob,$UserId,$GenderId);
  $Credit = $cred;
  $Dob=$dob;
  $UserId=$userId;
  $GenderId=$genderId;
  //$conn->query($sql);
  if ($stmt->execute()===TRUE) {
    return true;
  }
  else {
    return false;
  }
}}


function editCustomer($conn,$cred,$genderId,$dob,$userId) {
  if( !isset($cred))
 {
 //echo "Error: Credit is not set";
  return;
  }
elseif (!isset($userId)) {
 //echo "Error: User Id is not set";
  return;
  }
  else {
  $sql = "update `Customer` set `Credit` = (?) , GenderId = (?) , DateOfBirth = (?) where UserId = (?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("disi",$Credit,$GenderId,$DateOfBirth,$UserId);
  $Credit = $cred;
  $GenderId = $genderId;
  $DateOfBirth = ($dob);
  $UserId = $userId;
  if ($stmt->execute()===TRUE) {
    return "Customer updated successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}}


// function deleteUser($conn,$id) // cascaded delete ??
// { 
//   if (!isset($id))
//   {
//     //echo "Error: Id is not set";
//     return;
//   }
//   else
//   {
//     //$conn->query("set foreign_key_checks = 0"); // ????????/
//     $sql = "delete from Customer where Id = ".$id . " LIMIT 1";
//     if ($conn->query($sql)===TRUE)
//     {
//       return "Customer deleted successfully";
//     }
//     else
//     {
//       echo "Error: ".$conn->error;
//     }
//   }
// }

?>
