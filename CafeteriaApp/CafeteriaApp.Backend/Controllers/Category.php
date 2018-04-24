<?php
  require_once(__DIR__ . '/../ImageHandle.php');

  function getCategories($conn) {
    $sql = "select * from `category`";

    if ( $result = $conn->query($sql) ) {
      $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
      mysqli_free_result($result);
      return $categories;
    }
    else {
      echo "Error Retrieving Categories: ", $conn->error;
    }
  }

  function getCategoryById($conn, $id) {
    if ( !isset($id) ) {
      //echo "Error: Id is not set";
      return;
    }
    else {
      $sql = "select * from category where Id = " . $id . " LIMIT 1";

      if ( $result = $conn->query($sql) ) {
        $category = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        return $category;
      }
      else {
        echo "Error Retrieving Category: ", $conn->error;
      }
    }
  }

  function addCategory($conn, $name, $imageData = null) {
    if ($imageData != null) {
      $imageFileName = addImageFile($imageData, $name);
      $sql = "insert into category (Name, Image) values (?, ?)";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ss", $name, $imageFileName);
    }
    else {
      $sql = "insert into category (Name) values (?)";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("s", $name);
    }

    if ($stmt->execute() === TRUE) {
      return "Category Added successfully";
    }
    else {
      echo "Error: ", $conn->error;
    }
  }

  function editCategory($conn, $name, $id, $imageData = null) {
    $result = $conn->query("select Image from category where Id = " . $id);
    $category = mysqli_fetch_assoc($result);
    mysqli_free_result($result);

    if ($imageData != null) {
      $imageFileName = editImage($imageData, $category['Image'], $name);
      $sql = "update category set Name = (?) , Image = (?) where Id = (?)";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ssi", $name, $imageFileName, $id);
    }
    else {
      $sql = "update category set Name = (?) where Id = (?)";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("si", $name, $id);
    }

    if ($stmt->execute() === TRUE) {
      return "Category updated successfully";
    }
    else {
      echo "Error: ", $conn->error;
    }
  }

  function deleteCategory($conn, $id) {
    $sql = "select Image from category where Id = " . $id . " LIMIT 1";
    $result = $conn->query($sql);
    deleteImageFileIfExists( mysqli_fetch_assoc($result)['Image'] );
    mysqli_free_result($result);
    //$conn->query("set foreign_key_checks=0");
    $sql = "delete from category where Id = " . $id . " LIMIT 1";
    
    if ($conn->query($sql) === TRUE) {
      return "Category deleted successfully";
    }
    else {
      echo "Error: ", $conn->error;
    }
  }
?>