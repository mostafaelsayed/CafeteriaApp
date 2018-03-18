<?php
  function addAdmin($conn, $userId) {
    $sql = "insert into `admin` (`UserId`) values (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);

    if ($stmt->execute() === TRUE) {
      return "Admin User Added successfully !";
    }
    else {
      echo "Error: ", $conn->error;
    }
  }

  function deleteAdminByUserId($conn, $userId) {
    //$conn->query("set foreign_key_checks = 0");
    $sql = "delete from `admin` where `UserId` = " . $userId . " LIMIT 1";

    if ($conn->query($sql) === TRUE) {
      return "Admin deleted successfully";
    }
    else {
      echo "Error: ", $conn->error;
    }
  }
?>