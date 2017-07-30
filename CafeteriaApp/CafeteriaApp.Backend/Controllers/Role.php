<?php
include 'CafeteriaApp.Backend\connection.php';

function getRoles($conn) {
  
  $sql = "select * from Role";
  if ($conn->query($sql)) {
      $result = $conn->query($sql);
      $roles = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $roles = json_encode($roles);
      $conn->close();
      return $roles;
  } else {
      echo "Error retrieving Roles: " . $conn->error;
  }

}

function addRole($conn,$name) {
if( !isset($name)) 
 {
 echo "Error: Role name is not set";
  return;
  }
  else
  {
  $sql = "insert into Role (Name) values (?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s",$Name);
  $Name = $name;
  //$conn->query($sql);
  if ($stmt->execute()===TRUE) {
    echo "Role Added successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}}


function editRole($conn,$name,$id) {
  if( !isset($name)) 
 {
 echo "Error: Role name is not set";
  return;
  }
  elseif(!isset($id))
  {
    echo "Error: Role id is not set";
  return;
  }
  else{
  $sql = "update Role set Name = (?) where Id = (?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("si",$Name,$Id);
  $Name = $name;
  $Id = $id;
  //$conn->query($sql);
  if ($stmt->execute()===TRUE) {
    echo "Role updated successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}}


function deleteRole($conn,$id) { // cascaded delete ??
 if (!isset($id))
  {
     echo "Error: Id is not set";
  return;
  }
  else{
  //$conn->query("set foreign_key_checks = 0"); // ????????/
  $sql = "delete from Role where Id = ".$id . "LIMIT 1";
  if ($conn->query($sql)===TRUE) {
    echo "Role deleted successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
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
