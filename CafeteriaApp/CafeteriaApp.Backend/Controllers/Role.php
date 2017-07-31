<?php
include 'CafeteriaApp.Backend\connection.php';

function getRoles($conn) {
  
  $sql = "select * from Role";
  $result = $conn->query($sql);
  if ($result) {
      $roles = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $roles = json_encode($roles);
      $conn->close();
      return $roles;
  } else {
      echo "Error retrieving Roles: " . $conn->error;
  }

}

function getRoleById($conn,$id) {
    if( !isset($id)) 
 {
 echo "Error: Role Id is not set";
  return;
  }
  else{
  $sql = "select * from Role where Id=".$id;
  $result = $conn->query($sql);
  if ($result) {
      $roles = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $roles = json_encode($roles);
      $conn->close();
      return $roles;
  } else {
      echo "Error retrieving Roles: " . $conn->error;
  }

}}

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
  $sql = "delete from Role where Id = ".$id . " LIMIT 1";
  if ($conn->query($sql)===TRUE) {
    echo "Role deleted successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}
}




 ?>
