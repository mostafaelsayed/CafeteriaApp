<?php



function getRatingIdsByUserIdAndMenuItemId($conn,$cid,$mid) // used for editing or deleting comments of a user
{  
  if ( !isset($cid) || !isset($mid))
  {
    //echo "Error: Id is not set";
    return 1;
  }
  else
  {
    $sql = "select count(*) from Rating where UserId ='".$cid."' and MenuItemId=".$mid ;
    $result = $conn->query($sql);
    if ($result)
    {
    $count = mysqli_fetch_all($result, MYSQLI_NUM);
       mysqli_free_result($result);
      
        return $count;   
    
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

    $DateId =getDateIdByDate($conn,date("Y-m-d"));

    $sql = "insert into Comment (Details , UserId , MenuItemId , DateId ) values (?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siii",$Details, $UserId ,$MenuItemId,$DateId);
    $Details = $details;
    $UserId = $Cid;
    $MenuItemId=$Mid;
    if ($stmt->execute()===TRUE)
    {
       return  mysqli_insert_id($conn);
      //return "Comment Added successfully";
    }
    else
    {
      echo "Error: ".$conn->error;
    }
  }
}



function checkOwnershipOfComment($conn,$id,$cid)//check if its for the customer before deleting
{
  if (!isset($id))
  {
    //echo "Error: Id is not set";
    return;
  }
  else
  {
    $sql = "select count(*) from Comment where Id = ".$id. " and UserId=".$cid;
    $result = $conn->query($sql);
    if ($result) {
      $count= mysqli_fetch_array($result , MYSQLI_NUM);
      $count=(int)$count[0];
      if ($count===1)
    {
      return true;
    }
    else
    {
      return false ;
    }
    }
   
  } 
}


 function calcAvgRatingByMenuItemId($conn,$id)
{
  if (!isset($id)) 
  {
    //echo "Error: MenuItem Id is not set";//hacker
    return;
  }
  else
  {
    $sql = "select avg(value) from Rating  where MenuItemId =".$id;
    $result = $conn->query($sql);
    if ($result)
    {
      $avg = mysqli_fetch_all($result, MYSQLI_ASSOC);
      mysqli_free_result($result);
        return $avg;
    }
    else
    { //server
      echo "Error retrieving average: " . $conn->error;//developer
    }

  } 
}


?>
