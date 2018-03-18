<?php
  function getRoles($conn) {
    $sql = "select * from role";
    $result = $conn->query($sql);

    if ($result) {
      $roles = mysqli_fetch_all($result, MYSQLI_ASSOC);
      mysqli_free_result($result);
      return $roles;   
    }
    else {
      echo "Error retrieving Roles: ", $conn->error;
    }
  }

  function getRoleById($conn, $id) {
    $sql = "select * from role where Id = " . $id . " LIMIT 1";
    $result = $conn->query($sql);

    if ($result) {
      $roles = mysqli_fetch_assoc($result);
      mysqli_free_result($result);
      return $roles;
    }
    else {
      echo "Error retrieving Role: ", $conn->error;
    }
  }

  function addRole($conn, $name) {
    $sql = "insert into role (Name) values (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $name);
    
    if ($stmt->execute() === TRUE) {
      return "Role Added successfully";
    }
    else {
      echo "Error: ", $conn->error;
    }
  }
  
  function editRole($conn, $name, $id)
  {
    $sql = "update role set Name = (?) where Id = (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $name, $id);
    
    if ($stmt->execute() === TRUE) {
      return "Role updated successfully";
    }
    else {
      echo "Error: ", $conn->error;
    }
  }

  function deleteRole($conn, $id) { // cascaded delete ??
    //$conn->query("set foreign_key_checks = 0"); // ????????/
    $sql = "delete from role where Id = " . $id . " LIMIT 1";

    if ($conn->query($sql) === TRUE) {
      return "Role deleted successfully";
    }
    else {
      echo "Error: ", $conn->error;
    }
  }
?>