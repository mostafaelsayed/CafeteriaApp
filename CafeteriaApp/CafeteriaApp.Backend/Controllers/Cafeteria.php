<?php
  require('../ImageHandle.php');

  function getCafeterias($conn) {
    $sql = "select * from `Cafeteria`";

    if ( $result = $conn->query($sql) ) {
      $cafeterias = mysqli_fetch_all($result, MYSQLI_ASSOC); // ??
      mysqli_free_result($result);
      return $cafeterias;
    }
    else {
      echo "Error retrieving Cafeterias : ", $conn->error;
    }
  }

  function getCafeteriaById($conn, $id) {
    $sql = "select * from `Cafeteria` where `Id` =" . $id . " LIMIT 1";

    if ( $result = $conn->query($sql) ) {
      $cafeteria = mysqli_fetch_assoc($result); // fetch only the first row of the result
      mysqli_free_result($result);
      return $cafeteria;
    }
    else {
      echo "Error retrieving Cafeteria : ", $conn->error;
    }
  }

  function addCafeteria($conn, $name, $imageData) { // if image null ??????
    $sql = "insert into `cafeteria` (`Name`, `Image`) values (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param( "ss", $name, addImageFile($imageData) );

    if ($stmt->execute() === TRUE) {
      return "Cafeteria Added successfully";
    }
    else {
      echo "Error: ", $conn->error;
    }
  }

  function editCafeteria($conn, $name, $id, $imageData) {
    $result = $conn->query("select `Image` from `cafeteria` where `Id` = " . $id);
    $cafeteria = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    $sql = "update `cafeteria` set `Name` = (?) , `Image` = (?) where `Id` = (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $name, $Image, $id);
    
    if ($imageData != $cafeteria['Image']) {
      $Image = editImage($imageData, $cafeteria['Image']);
    }
    else {
      $Image = $imageData;
    }

    if ($stmt->execute() === TRUE) {
      return "Cafeteria updated successfully";
    }
    else {
      echo "Error: ", $conn->error;
    }
  }

  function deleteCafeteria($conn, $id) {
    $sql = "select `Image` from `cafeteria` where `Id` = " . $id . " LIMIT 1";
    $result = $conn->query($sql);
    deleteImageFileIfExists( mysqli_fetch_assoc($result)['Image'] );
    mysqli_free_result($result);
    //$conn->query("set foreign_key_checks = 0"); // ????????/
    $sql = "delete from `cafeteria` where `Id` = " . $id . " LIMIT 1";

    if ($conn->query($sql) === TRUE) {
      return "Cafeteria deleted successfully";
    }
    else {
      echo "Error: ", $conn->error;
    }
  }
?>