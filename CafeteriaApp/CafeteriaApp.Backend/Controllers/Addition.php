<?php
include 'CafeteriaApp.Backend\connection.php';

function getAdditions($conn) {
  
  $sql = "select * from Addition";
  if ($conn->query($sql)) {
      $result = $conn->query($sql);
      $additions = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $additions = json_encode($additions);
      $conn->close();
      echo $additions;
  } else {
      echo "Error retrieving Additions: " . $conn->error;
  }
}


function addAddition($conn,$n) {
  $sql = "insert into Addition (Name) values (?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s",$name);
  $name = $n;
  //$conn->query($sql);
  if ($stmt->execute()===TRUE) {
    echo "Addition Added successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}


function editAddition($conn,$n,$Id) {
  $sql = "update Addition set Name = (?) where Id = (?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("si",$name,$id);
  $name = $n;
  $id = $Id;
  //$conn->query($sql);
  if ($stmt->execute()===TRUE) {
    echo "Addition updated successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}

if ($_SERVER['REQUEST_METHOD']=="GET") {
  if (isset($_GET["action"]) && $_GET["action"]=="getAdditions"){
    getAdditions($conn);
  }
  else {
    echo "Error occured while returning Additions";
  }
}

if ($_SERVER['REQUEST_METHOD']=="POST"){
    //decode the json data
    $data = json_decode(file_get_contents("php://input"));
    if (isset($data->action) && $data->action == "addAddition"){
      if ($data->Name != null){
        addAddition($conn,$data->Name);
      }
      else{
        echo "name is required";
      }
  }
}

if ($_SERVER['REQUEST_METHOD']=="PUT"){
    //decode the json data
    $data = json_decode(file_get_contents("php://input"));
    //echo $data;
      if ($data->Name != null && $data->Id != null) {
        //if ($data->action == "addcafeteria"){
        editAddition($conn,$data->Name,$data->Id);
      }
      else{
        echo "name is required";
      }
  //}
}

 ?>
