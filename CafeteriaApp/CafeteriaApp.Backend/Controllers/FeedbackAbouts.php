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

?>