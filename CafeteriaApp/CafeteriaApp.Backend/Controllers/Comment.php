<?php
//result=getCommentsByMenuItemId();
//if(result)
 // echo json_encode(result);
//if add or edit , echo a message
//else
// redirect to fear the hacker

 function getCommentsByMenuItemId($conn,$id)
{
  if (!isset($id)) 
  {
    //echo "Error: MenuItem Id is not set";//hacker
    return;
  }
  else
  {
    $sql = "select User.UserName , Comment.Details  from Comment inner join Customer on Comment.CustomerId=Customer.Id inner join User on User.Id=Customer.UserId  where MenuItemId =".$id;
    $result = $conn->query($sql);
    if ($result)
    {
      $comments = mysqli_fetch_all($result, MYSQLI_ASSOC);
      mysqli_free_result($result);
        return $comments;   
    }
    else
    { //server
      echo "Error retrieving Comments: " . $conn->error;//developer
    }

  } 
}

function getCommentsByCustomerId($conn,$id) // used for editing or deleting comments of a user
{  
  if (!isset($id)) 
  {
    //echo "Error: Id is not set";
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
        return $comments;   
    
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
    //echo "Error: Comment Details is not set";
    return;
  }
  elseif (!isset($Cid))
  {
   // echo "Error: Customer Id is not set";
    return;
  }
  elseif (!isset($Mid))
  {
    //echo "Error: MenuItem Id is not set";
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
      return "Comment Added successfully";
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
    //echo "Error: Comment Details is not set";
    return;
  }
  elseif (!isset($id))
  {
    //echo "Error: Id is not set";
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
      return "Comment updated successfully";
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
    //echo "Error: Id is not set";
    return;
  }
  else
  {
    $conn->query("set foreign_key_checks=0");
    $sql = "delete from Comment where Id = ".$id. " LIMIT 1";
    if ($conn->query($sql)===TRUE)
    {
      return "Comment deleted successfully";
    }
    else
    {
      echo "Error: ".$conn->error;
    }
  } 
}

?>
