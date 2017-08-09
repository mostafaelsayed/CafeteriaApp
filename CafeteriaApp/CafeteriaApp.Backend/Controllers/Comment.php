<?php

function getCommentsByMenuItemId($conn,$id,$backend=false)
{
  if (!isset($id)) 
  {
    echo "Error: MenuItem Id is not set";
    return;
  }
  else
  {
    $sql = "select * from Comment where MenuItemId =".$id;
    $result = $conn->query($sql);
    if ($result)
    {
      $comments = mysqli_fetch_all($result, MYSQLI_ASSOC);
      mysqli_free_result($result);
      $comments = json_encode($comments);
      if ($backend)
      { 
        return $comments;   
      }
      else
      {
        echo $comments;
      }
    }
    else
    {
      echo "Error retrieving Comments: " . $conn->error;
    }
  } 
}

function getCommentById($conn,$id,$backend=false)
{
  if (!isset($id)) 
  {
    echo "Error: Comment Id is not set";
    return;
  }
  else
  {
    $sql = "select * from Comment where Id =".$id." LIMIT 1";
    $result = $conn->query($sql);
    if ($result)
    {
      $comments = mysqli_fetch_assoc($result);
      mysqli_free_result($result);
      $comments = json_encode($comments);
      if ($backend)
      { 
        return $comments;   
      }
      else
      {
        echo $comments;
      }
    }
    else
    {
      echo "Error retrieving Comment: " . $conn->error;
    }
  } 
}

function getCommentsByCustomerId($conn,$id,$backend=false) // check in future if it's redundunt
{  
  if (!isset($id)) 
  {
    echo "Error: Id is not set";
    return;
  }
  else
  {
    $sql = "select * from Comment where CustomerId =".$id;
    $result = $conn->query($sql);
    if ($result)
    {
      $comments = mysqli_fetch_assoc($result);
      mysqli_free_result($result);
      $comments = json_encode($comments);
      if ($backend)
      { 
        return $comments;   
      }
      else
      {
        echo $comments;
      }
    }
    else
    {
      echo "Error retrieving Comments: " . $conn->error;
    }
  } 
}

function addComment($conn,$details ,$Cid,$Mid)
{
  if (!isset($details)) 
  {
    echo "Error: Comment Details is not set";
    return;
  }
  elseif (!isset($Cid))
  {
    echo "Error: Customer Id is not set";
    return;
  }
  elseif (!isset($Mid))
  {
    echo "Error: MenuItem Id is not set";
    return;
  }
  else
  {
    $sql = "insert into Comment (Details , CustomerId ,MenuItemId ) values (?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sii",$Details, $CustomerId ,$MenuItemId);
    $Details = $details;
    $CustomerId = $Cid;
    $MenuItemId=$Mid;
    if ($stmt->execute()===TRUE)
    {
      echo "Comment Added successfully";
    }
    else
    {
      echo "Error: ".$conn->error;
    }
  }
}

function editComment($conn,$details,$id)
{
  if (!isset($details)) 
  {
    echo "Error: Comment Details is not set";
    return;
  }
  elseif (!isset($id))
  {
    echo "Error: Id is not set";
    return;
  }
  else
  {
    $sql = "update Comment set Details = (?) where Id = (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si",$Details,$Id);
    $Details = $details;
    $Id = $id;
    if ($stmt->execute()===TRUE)
    {
      echo "Comment updated successfully";
    }
    else
    {
      echo "Error: ".$conn->error;
    }
  } 
}

function deleteComment($conn,$id)
{
  if (!isset($id))
  {
    echo "Error: Id is not set";
    return;
  }
  else
  {
    $conn->query("set foreign_key_checks=0");
    $sql = "delete from Comment where Id = ".$id. " LIMIT 1";
    if ($conn->query($sql)===TRUE)
    {
      echo "Comment deleted successfully";
    }
    else
    {
      echo "Error: ".$conn->error;
    }
  } 
}

?>
