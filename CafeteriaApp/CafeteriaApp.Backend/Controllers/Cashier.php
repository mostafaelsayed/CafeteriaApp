<?php

function addCashier($conn,$userId)
{
  $sql = "insert into cashier (UserId) values (?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i",$UserId);
  $UserId = $userId;
  if ($stmt->execute() === TRUE)
  {
    return "Cashier User Added successfully !";
  }
  else
  {
    echo "Error: ".$conn->error;
  }
}

function deleteCashierByUserId($conn,$userId)
{
  //$conn->query("set foreign_key_checks = 0");
  $sql = "delete from Cashier where UserId = ".$userId. " LIMIT 1";
  if ($conn->query($sql) === TRUE)
  {
    return "Cashier deleted successfully";
  }
  else
  {
    echo "Error: ".$conn->error;
  }
}

?>