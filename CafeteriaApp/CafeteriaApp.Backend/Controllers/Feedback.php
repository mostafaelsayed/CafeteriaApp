<?php
require_once("CafeteriaApp.Backend/Controllers/Dates.php"); 

 function getVisitorFeedbackByDate($conn,$id)
{
  if (!isset($id)) 
  {
    //echo "Error: MenuItem Id is not set";//hacker
    return;
  }
  else
  {
    $DateId= getCurrentDateId($conn);
    $sql = "select * from VisitorFeedback where DateId =".$DateId;
    $result = $conn->query($sql);
    if ($result)
    {
      $feedbacks = mysqli_fetch_all($result, MYSQLI_ASSOC);
      mysqli_free_result($result);
        return $feedbacks;
    }
    else
    { //server
      echo "Error retrieving Feedbacks: " . $conn->error;//developer
    }

  } 
}


function addVisitorFeedback($conn,$name,$phone,$mail,$message,$aboutId)
{
  if (!isset($name)||!isset($phone)||!isset($mail)||!isset($message)||!isset($aboutId))
  {    //echo "Error: Comment Details is not set";
    return;
  }
  else
  {
    $DateId =getDateIdByDate($conn,date("Y-m-d"));

    $sql = "insert into VisitorFeedback (Name ,Phone ,Email ,Message,DateId,AboutId) values (?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssii",$Name,$Phone,$Email,$Message,$DateId,$AboutId);
    $Name = $name;
    $Phone = $phone;
    $Email=$mail;
    $Message=$message;
    $AboutId=$aboutId;

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



function deleteVisitorFeedback($conn,$id)//check if its for the customer before deleting
{
  if (!isset($id))
  {
    return;
  }
  else
  {
    $sql = "delete from VisitorFeedback where Id = ".$id. " LIMIT 1";
    if ($conn->query($sql)===TRUE)
    {
      return "Visitor Feedback deleted successfully";
    }
    else
    {
      echo "Error: ".$conn->error;
    }
  } 
}

?>