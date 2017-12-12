<?php
require('CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/ImageHandle.php');

function getMenuItemByCategoryId($conn, $id, $customer = false) { // ????????????????
  $sql = "select * from MenuItem where CategoryId = " . $id;

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
  $sql = "select * from MenuItem where Id = " . $id . " LIMIT 1";
  if ( $result = $conn->query($sql) ) {
    $MenuItem = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $MenuItem;
  }
  else {
    echo "Error retrieving MenuItem: ", $conn->error;
  }
}

// function getMenuItemsByIds($conn , $ids)
// {
//   if (!isset($ids))
//   {
//     //echo "Error:MenuItem Id is not set";
//     return;
//   }
//   else
//   {
//     $sql = "select * from MenuItem where Id in (". implode(',', $ids) . ")";
//     if ($result = $conn->query($sql))
//     {
//       $MenuItem = mysqli_fetch_all($result,MYSQLI_ASSOC);
//       mysqli_free_result($result);
//       return $MenuItem;
//     }
//     else
//     {
//       echo "Error retrieving MenuItem: " . $conn->error;
//     }
//   }
// }

function getMenuItemPriceById($conn, $id) {
  $sql = "select `Price` from `MenuItem` where `Id` = " . $id . " LIMIT 1";

  if ( $result = $conn->query($sql) ) {
    $MenuItem = mysqli_fetch_assoc($result);
    mysqli_free_result($result);
    return $MenuItem['Price'];
  }
  else {
    echo "Error retrieving MenuItem: ", $conn->error;
  }
}

function addMenuItem($conn, $name, $price, $description, $categoryId, $imageData) {
  $sql = "insert into menuitem (Name, Price, Description, CategoryId, Image) values (?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param( "sdsis", $name, $price, $description, $categoryId, addImageFile($imageData) );

  if ($stmt->execute() === TRUE) {
    return "MenuItem Added successfully";
  }
  else {
    echo "Error: ", $conn->error;
  }
}

function editMenuItem($conn, $name, $price, $description, $id, $imageData, $visible) {
  $result = $conn->query("select Image from menuitem where Id = " . $id);
  $menuItem = mysqli_fetch_assoc($result);
  mysqli_free_result($result);
  $sql = "update MenuItem set Name = (?), Price = (?), Description = (?), Image = (?), Visible = (?) 
  where Id = (?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sdssii", $name, $price, $description, $Image, $visible, $id);

  if ($imageData != $menuItem['Image']) {
    $Image = editImage($imageData, $menuItem['Image']);
  }
  else {
    $Image = $imageData;
  }

  if ($stmt->execute() === TRUE) {
    return "MenuItem updated successfully";
  }
  else {
    echo "Error: ", $conn->error;
  }
}

function deleteMenuItem($conn, $id) {
  $sql = "select Image from MenuItem where Id = " . $id . " LIMIT 1";
  $result = $conn->query($sql);
  deleteImageFileIfExists( mysqli_fetch_assoc($result)['Image'] );
  mysqli_free_result($result);
  //$conn->query("set foreign_key_checks = 0"); // ????????/
  $sql = "delete from MenuItem where Id = " . $id . " LIMIT 1";

  if ($conn->query($sql) === TRUE) {
    return "MenuItem deleted successfully";
  }
  else {
    echo "Error: ", $conn->error;
  }
}
?>