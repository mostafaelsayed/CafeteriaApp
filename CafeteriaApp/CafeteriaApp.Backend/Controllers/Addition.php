<?php

function getAdditionsByCategoryId($conn,$id,$backend=false)
{
  $sql = "select * from Addition where CategoryId=".$id;
  $result = $conn->query($sql);
  if ($result)
  {
    $additions = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);
    if ($backend)
    { 
      return $additions;   
    }
    else
    {   
     $additions = json_encode($additions);
      echo $additions;
    }  
  }
  else
  {
    echo "Error retrieving Additions: " . $conn->error;
  }
}

function getAdditionById($conn,$id,$backend=false)
{  
  $sql = "select * from Addition where Id=".$id." LIMIT 1";
  $result = $conn->query($sql);
  if ($result)
  {
    $additions = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    if ($backend)
    { 
      return $additions;   
    }
    else
    {    $additions = json_encode($additions);

      echo $additions;
    }
  }
  else
  {
    echo "Error retrieving Addition: " . $conn->error;
  }
}

function addAddition($conn,$name,$price,$categoryId)
{
  $sql = "insert into Addition (Name,Price,CategoryId) values (?,?,?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sfi",$Name,$Price ,$CategoryId);
  $Name = $name;
  $Price=$price;
  $CategoryId=$categoryId;
  if ($stmt->execute()===TRUE)
  {
    echo "Addition Added successfully";
  }
  else
  {
    echo "Error: ".$conn->error;
  }
}

function editAddition($conn,$name,$price,$id)
{
  $sql = "update Addition set Name = (?) , Price=(?) where Id = (?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssi",$Name,$Price,$Id);
  $Name = $name;
  $Price=$price;
  $Id = $id;
  if ($stmt->execute()===TRUE)
  {
    echo "Addition updated successfully";
  }
  else
  {
    echo "Error: ".$conn->error;
  }
}

function deleteAddition($conn,$id)
{
  if (!isset($id))
  {
    echo "Error: Id is not set";
    return;
  }
  else
  {
    //$conn->query("set foreign_key_checks = 0"); // ????????/
    $sql = "delete from Addition where Id = ".$id . " LIMIT 1";
    if ($conn->query($sql)===TRUE)
    {
      echo "Addition deleted successfully";
    }
    else
    {
      echo "Error: ".$conn->error;
    }
  }
}

?>
