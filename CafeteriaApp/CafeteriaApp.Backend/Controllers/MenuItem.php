<?php
  require_once __DIR__ . '/../ImageHandle.php';

  function getMenuItemByCategoryId($conn, $id, $customer = false) { // ????????????????
    $sql = "select * from menuitem where CategoryId = " . $id;

    if ($customer) {
      $sql .= " and Visible = 1";
    }

    if ( $result = $conn->query($sql) ) {
      $MenuItems = mysqli_fetch_all($result, MYSQLI_ASSOC);
      mysqli_free_result($result);

      return $MenuItems;
    }
    else {
      echo "Error retrieving MenuItems: ", $conn->error;
    }
  }

  function getMenuItemById($conn, $id) {
    $sql = "select * from menuitem where Id = " . $id . " LIMIT 1";
    if ( $result = $conn->query($sql) ) {
      $MenuItem = mysqli_fetch_assoc($result);
      mysqli_free_result($result);
      
      return $MenuItem;
    }
    else {
      echo "Error retrieving MenuItem: ", $conn->error;
    }
  }

  function getMenuItemPriceById($conn, $id) {
    $sql = "select `Price` from `menuitem` where `Id` = " . $id . " LIMIT 1";

    if ( $result = $conn->query($sql) ) {
      $MenuItem = mysqli_fetch_assoc($result);
      mysqli_free_result($result);
      
      return $MenuItem['Price'];
    }
    else {
      echo "Error retrieving MenuItem: ", $conn->error;
    }
  }

  function addMenuItem($conn, $name, $price, $description, $categoryId, $imageData = null) {
    if ($imageData != null) {
      $sql = "insert into menuitem (Name, Price, Description, CategoryId, Image) values (?, ?, ?, ?, ?)";
      $stmt = $conn->prepare($sql);
      $theImage = addBinaryImageFile($imageData, $name . $categoryId)[0];
      $stmt->bind_param("sdsis", $name, $price, $description, $categoryId, $theImage);
    }
    else {
      $sql = "insert into menuitem (Name, Price, Description, CategoryId) values (?, ?, ?, ?)";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("sdsi", $name, $price, $description, $categoryId);
    }

    if ($stmt->execute() === TRUE) {
      return "MenuItem Added successfully";
    }
    else {
      echo "Error: ", $conn->error;
    }
  }

  function editMenuItem($conn, $name, $price, $description, $id, $imageData, $visible) {
    $result = $conn->query("select Image, CategoryId from menuitem where Id = " . $id);
    $menuItem = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    $stmt = '';

    if ($imageData != null) {
      $sql = "update menuitem set Name = (?), Price = (?), Description = (?), Image = (?), Visible = (?) 
      where Id = (?)";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("sdssii", $name, $price, $description, $Image, $visible, $id);
      $Image = editBinaryImage($imageData, $menuItem['Image'], $name . $menuItem['CategoryId'])[0];
    }
    else {
      $sql = "update menuitem set Name = (?), Price = (?), Description = (?), Visible = (?) 
      where Id = (?)";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("sdsii", $name, $price, $description, $visible, $id);
    }

    if ($stmt->execute() === TRUE) {
      return "MenuItem updated successfully";
    }
    else {
      echo "Error: ", $conn->error;
    }
  }

  function deleteMenuItem($conn, $id) {
    $sql = "select Image from menuitem where Id = " . $id . " LIMIT 1";
    $result = $conn->query($sql);
    $sql = "delete from menuitem where Id = " . $id . " LIMIT 1";

    if ($conn->query($sql) === TRUE) {
      deleteImageFileName( mysqli_fetch_assoc($result)['Image'] );
      mysqli_free_result($result);

      return "MenuItem deleted successfully";
    }
    else {
      echo "Error: ", $conn->error;
    }
  }
?>