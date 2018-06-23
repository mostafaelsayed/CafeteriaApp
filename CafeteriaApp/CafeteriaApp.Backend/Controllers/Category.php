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

  function getCategoryIdByName($conn, $name) {
    $sql = "select `Id` from category where `Name` = '{$name}'";

    if ( $result = $conn->query($sql) ) {
      $categoryId = (int)mysqli_fetch_assoc($result)['Id'];
      mysqli_free_result($result);

      return $categoryId;
    }
    else {
      echo "Error Retrieving Category: ", $conn->error;
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
      $imageFileName = addBinaryImageFile($imageData, $name)[0];
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
    $stmt = '';

    if ($imageData != null) {
      var_dump($category['Image']);
      var_dump($name);
      $sql = "update category set Name = (?) , Image = (?) where Id = (?)";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ssi", $name, $Image, $id);
      $Image = editBinaryImage($imageData, $category['Image'], $name)[0];
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
    $sql = "select Image from menuitem where CategoryId = " . $id;
    $result2 = $conn->query($sql);
    $sql = "delete from category where Id = " . $id . " LIMIT 1";
    
    if ($conn->query($sql) === TRUE) {
      deleteImageFileName( mysqli_fetch_assoc($result)['Image'] );
      mysqli_free_result($result);

      while ($row = mysqli_fetch_assoc($result2)) {
        deleteImageFileName( $row['Image'] );
      }

      mysqli_free_result($result2);

      return "Category deleted successfully";
    }
    else {
      echo "Error: ", $conn->error;
    }
  }
?>