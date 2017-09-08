<?php

function getFeedbackAbouts($conn)
{  
  $sql = "select * from FeedbackAbouts";
  $result = $conn->query($sql);
  if ($result)
  {
    $feedbackAbouts = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result); 
      return $feedbackAbouts;   
   
  }
  else
  {
    echo "Error retrieving Feedback Abouts: " . $conn->error;
  }
}



function addFeedbackAbouts($conn,$name)
{
  if (!isset($name))
  {
    return;
  }
  else
  {

    $sql = "insert into FeedbackAbouts (Name ) values (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s",$Name);
    $Name = $name;
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


?>