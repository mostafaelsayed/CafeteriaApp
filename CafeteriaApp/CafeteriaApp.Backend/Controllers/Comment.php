<?php
include 'CafeteriaApp.Backend\connection.php';

function getComments($conn) {
  
  $sql = "select * from Comment";
  if ($conn->query($sql)) {
      $result = $conn->query($sql);
      $comments = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $comments = json_encode($comments);
      $conn->close();
      return $comments;
  } else {
      return "Error retrieving Comments: " . $conn->error;
  }
}


function addComment($conn,$n) {
  $sql = "insert into Comment (Details) values (?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s",$name);
  $name = $n;
  //$conn->query($sql);
  if ($stmt->execute()===TRUE) {
    echo "Comment Added successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}


function editComment($conn,$n,$Id) {
  $sql = "update Comment set Details = (?) where Id = (?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("si",$details,$id);
  $details = $n;
  $id = $Id;
  //$conn->query($sql);
  if ($stmt->execute()===TRUE) {
    echo "Comment updated successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}

if ($_SERVER['REQUEST_METHOD']=="GET") {
  if (isset($_GET["action"]) && $_GET["action"]=="getComments"){
    getComments($conn);
  }
  else {
    echo "Error occured while returning Details";
  }
}

if ($_SERVER['REQUEST_METHOD']=="POST"){
    //decode the json data
    $data = json_decode(file_get_contents("php://input"));
    if (isset($data->action) && $data->action == "addComment"){
      if ($data->Details != null){
        addComment($conn,$data->Details);
      }
      else{
        echo "Details is required";
      }
  }
}

if ($_SERVER['REQUEST_METHOD']=="PUT"){
    //decode the json data
    $data = json_decode(file_get_contents("php://input"));
    //echo $data;
      if ($data->Details != null && $data->Id != null) {
        //if ($data->action == "addcafeteria"){
        editComment($conn,$data->Details,$data->Id);
      }
      else{
        echo "Details is required";
      }
  //}
}

 ?>
