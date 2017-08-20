<?php

function addAdmin($conn,$userId)
{
  $sql = "insert into admin (UserId) values (?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i",$UserId);
  $UserId = $userId;
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

function deleteAdminByUserId($conn,$userId)
{
  if (!isset($userId))
  {
    //echo "Error: Id is not set";
    return;
  }
  else
  {
    $conn->query("set foreign_key_checks=0");
    $sql = "delete from Admin where UserId = ".$userId. " LIMIT 1";
    if ($conn->query($sql)===TRUE)
    {
      return "Admin deleted successfully";
    }
    else
    {
      echo "Error: ".$conn->error;
    }
  } 
}

function deleteAdmin($conn,$id)
{
  if (!isset($id))
  {
    //echo "Error: Id is not set";
    return;
  }
  else
  {
    //$conn->query("set foreign_key_checks = 0"); // ????????/
    $sql = "delete from Admin where Id = ".$id . " LIMIT 1";
    if ($conn->query($sql)===TRUE)
    {
      return "Admin deleted successfully";
    }
    else
    {
      echo "Error: ".$conn->error;
    }
  }
}

?>