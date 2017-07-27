<?php
include 'CafeteriaApp.Backend\connection.php';

function getRoles($conn) {
  
  $sql = "select * from Role";
  if ($conn->query($sql)) {
      $result = $conn->query($sql);
      $roles = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $roles = json_encode($roles);
      $conn->close();
      echo $roles;
  } else {
      echo "Error retrieving Roles: " . $conn->error;
  }

}

function addRole($conn,$n) {
  $sql = "insert into Role (Name) values (?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s",$name);
  $name = $n;
  //$conn->query($sql);
  if ($stmt->execute()===TRUE) {
    echo "Role Added successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}

function editRole($conn,$n,$Id) {
  $sql = "update Role set Name = (?) where Id = (?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("si",$name,$id);
  $name = $n;
  $id = $Id;
  //$conn->query($sql);
  if ($stmt->execute()===TRUE) {
    echo "Role updated successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}

if ($_SERVER['REQUEST_METHOD']=="GET") {
  if (isset($_GET["action"]) && $_GET["action"]=="getRoles"){
    getRoles($conn);
  }
  else {
    echo "Error occured while returning Roles";
  }
}

if ($_SERVER['REQUEST_METHOD']=="POST"){
    //decode the json data
    $data = json_decode(file_get_contents("php://input"));
    if (isset($data->action) && $data->action == "addRole"){
      if ($data->Name != null){
        addRole($conn,$data->Name);
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
        editRole($conn,$data->Name,$data->Id);
      }
      else{
        echo "name is required";
      }
  //}
}

 ?>
