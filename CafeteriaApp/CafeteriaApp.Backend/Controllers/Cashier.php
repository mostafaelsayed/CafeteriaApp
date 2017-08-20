<?php

function addCashier($conn,$userId)
{
  // if (checkExistingEmail($conn ,$email ) || checkExistingUserName($conn ,$userName,true)) 
  // {
  //  return;
  // }
  // elseif(!isset($firstName) ||!isset($lastName) || !isset($phoneNumber) || !isset($password))
  // {
  // return;
  // }
  // else
  // {
    $sql = "insert into cashier (UserId) values (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i",$UserId);
    $UserId = $userId;
    if ($stmt->execute()===TRUE)
    {
      $user_id =  mysqli_insert_id($conn);
      return "Cashier User Added successfully !";
    }
    else
    {
      echo "Error: ".$conn->error;
    }
  //}
}

function deleteCashierByUserId($conn,$userId)
{
  if (!isset($userId))
  {
    //echo "Error: Id is not set";
    return;
  }
  else
  {
    $conn->query("set foreign_key_checks=0");
    $sql = "delete from Cashier where UserId = ".$userId. " LIMIT 1";
    if ($conn->query($sql)===TRUE)
    {
      return "Cashier deleted successfully";
    }
    else
    {
      echo "Error: ".$conn->error;
    }
  } 
}

function deleteCashier($conn,$id)
{
  if (!isset($id))
  {
    //echo "Error: Id is not set";
    return;
  }
  else
  {
    //$conn->query("set foreign_key_checks = 0"); // ????????/
    $sql = "delete from Cashier where Id = ".$id . " LIMIT 1";
    if ($conn->query($sql)===TRUE)
    {
      return "Cashier deleted successfully";
    }
    else
    {
      echo "Error: ".$conn->error;
    }
  }
}

?>