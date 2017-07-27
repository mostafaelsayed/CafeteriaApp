<?php
include 'CafeteriaApp.Backend\connection.php';

function getTimes($conn) {
  
  $sql = "select * from Times";
  if ($conn->query($sql)) {
      $result = $conn->query($sql);
      $times = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $times = json_encode($times);
      $conn->close();
      echo $times;
  } else {
      echo "Error retrieving Times: " . $conn->error;
  }
}


function addTime($conn,$n) {
  $sql = "insert into Times (Time) values (?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s",$name);
  $name = $n;
  //$conn->query($sql);
  if ($stmt->execute()===TRUE) {
    echo "Time Added successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}


function editTime($conn,$n,$Id) {
  $sql = "update Times set Time = (?) where Id = (?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("si",$name,$id);
  $name = $n;
  $id = $Id;
  //$conn->query($sql);
  if ($stmt->execute()===TRUE) {
    echo "Time updated successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}

if ($_SERVER['REQUEST_METHOD']=="GET") {
  if (isset($_GET["action"]) && $_GET["action"]=="getTimes"){
    getTimes($conn);
  }
  else {
    echo "Error occured while returning Times";
  }
}

if ($_SERVER['REQUEST_METHOD']=="POST"){
    //decode the json data
    $data = json_decode(file_get_contents("php://input"));
    if (isset($data->action) && $data->action == "addTime"){
      if ($data->Name != null){
        addTime($conn,$data->Name);
      }
      else{
        echo "Time is required";
      }
  }
}

if ($_SERVER['REQUEST_METHOD']=="PUT"){
    //decode the json data
    $data = json_decode(file_get_contents("php://input"));
    //echo $data;
      if ($data->Name != null && $data->Id != null) {
        //if ($data->action == "addcafeteria"){
        editTime($conn,$data->Name,$data->Id);
      }
      else{
        echo "Time is required";
      }
  //}
}

 ?>
