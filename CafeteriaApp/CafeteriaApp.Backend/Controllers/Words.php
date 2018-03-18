<?php
  function getWords($conn, $AssocOrNum) {
    $sql = "select * from words";
    $result = $conn->query($sql);

    if ($result) {
      $words = mysqli_fetch_all($result, $AssocOrNum);
      mysqli_free_result($result);
      return $words;
    }
    else {
      echo "Error retrieving Words: ", $conn->error;
    }
  }

  function addWord($conn, $name) {
    $sql = "insert into words (Name) values (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $name);
    
    if ($stmt->execute() === TRUE) {
      return "Word Added successfully";
    }
    else {
      echo "Error: ", $conn->error;
    }
  }

  function editWord($conn, $name, $id) {
    $sql = "update words set Name = (?), where Id = (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $name, $id);
    
    if ($stmt->execute() === TRUE) {
      return "Word updated successfully";
    }
    else {
      echo "Error: ", $conn->error;
    }
  }

  function deleteWord($conn, $id) { // drop the column also ???????
    //$conn->query("set foreign_key_checks = 0"); // ????????/
    $sql = "delete from words where Id = " . $id . " LIMIT 1";
    if ($conn->query($sql) === TRUE) {
      return "Word deleted successfully";
    }
    else {
      echo "Error: ", $conn->error;
    }
  }
?>