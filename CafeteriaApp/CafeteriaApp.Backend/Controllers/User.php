<?php
include 'CafeteriaApp.Backend\connection.php';

function getUsers($conn) {
  
  $sql = "select * from User";
  if ($conn->query($sql)) {
      $result = $conn->query($sql);
      $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $users = json_encode($users);
      $conn->close();
      echo $users;
  } else {
      echo "Error retrieving Users: " . $conn->error;
  }
}


function addUser($conn,$n) {
  $sql = "insert into User (Name) values (?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s",$name);
  $name = $n;
  //$conn->query($sql);
  if ($stmt->execute()===TRUE) {
    echo "User Added successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}


function editUser($conn,$n,$Id) {
  $sql = "update User set Name = (?) where Id = (?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("si",$name,$id);
  $name = $n;
  $id = $Id;
  //$conn->query($sql);
  if ($stmt->execute()===TRUE) {
    echo "User updated successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}

if ($_SERVER['REQUEST_METHOD']=="GET") {
  if (isset($_GET["action"]) && $_GET["action"]=="getUsers"){
    getUsers($conn);
  }
  else {
    echo "Error occured while returning cafeterias";
  }
}

if ($_SERVER['REQUEST_METHOD']=="POST"){
    //decode the json data
    $data = json_decode(file_get_contents("php://input"));
    if (isset($data->action) && $data->action == "addUser"){
      if ($data->Name != null){
        addUser($conn,$data->Name);
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
        editUser($conn,$data->Name,$data->Id);
      }
      else{
        echo "name is required";
      }
  //}
}

 ?>
