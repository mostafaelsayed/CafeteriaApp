<?php

function getOrderStatus($conn)
{  
  $sql = "select * from OrderStatus";
  $result = $conn->query($sql);
  if ($result)
  {
    $OrderStatus = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result); 
      return $OrderStatus;   
   
  }
  else
  {
    echo "Error retrieving OrderStatus: " . $conn->error;
  }
}

function getOrderStatusById($conn ,$id)
{
  if (!isset($id)) 
  {
    //echo "Error: OrderStatus Id is not set";
    return;
  }
  else
  {
    $sql = "select * from OrderStatus  where Id=".$id." LIMIT 1";
    $result = $conn->query($sql);
    if ($result)
    {
      $OrderStatus = mysqli_fetch_assoc($result);
      mysqli_free_result($result); 
        return $OrderStatus;   
      
    }
    else
    {
      echo "Error retrieving OrderStatus: " . $conn->error;
    }
  }
}

function addOrderStatus($conn,$name)
{
  if (!isset($name)) 
  {
    //echo "Error:OrderStatus name is not set";
    return;
  }
  else
  {
    $sql = "insert into OrderStatus (Name) values (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s",$Name);
    $Name = $name;
    if ($stmt->execute()===TRUE)
    {
      return "OrderStatus Added successfully";
    }
    else
    {
      echo "Error: ".$conn->error;
    }
  }
}

function editOrderStatus($conn,$name,$id)
{
  if (!isset($name)) 
  {
    //echo "Error:OrderStatus name is not set";
    return;
  }
  elseif (!isset($id))
  {
    //echo "Error:OrderStatus Id is not set";
    return;
  }
  else
  { 
    $sql = "update OrderStatus set Name = (?) where Id = (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si",$Name,$Id);
    $Name = $name;
    $Id = $id;
    if ($stmt->execute()===TRUE)
    {
      return "OrderStatus updated successfully";
    }
    else
    {
      echo "Error: ".$conn->error;
    }
  }
}

function deleteOrderStatus($conn,$id)
{
  if (!isset($id))
  {
    //echo "Error: Id is not set";
    return;
  }
  else
  {
    //$conn->query("set foreign_key_checks = 0"); // ????????/
    $sql = "delete from OrderStatus where Id = ".$id . " LIMIT 1";
    if ($conn->query($sql)===TRUE)
    {
      return "OrderStatus deleted successfully";
    }
    else
    {
      echo "Error: ".$conn->error;
    }
  }
}

?>