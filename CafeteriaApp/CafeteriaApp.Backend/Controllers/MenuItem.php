<?php
include 'CafeteriaApp.Backend\connection.php';

function getMenuItemByCategoryId($conn , $id) {
   if( !isset($id))
 {
 echo "Error:Category Id is not set";
  return;
  }
  else
  {
  $sql = "select * from MenuItem where CategoryId = ".$id;
  if ($conn->query($sql)) {
      $result = $conn->query($sql);
      $MenuItems = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $MenuItems = json_encode($MenuItems);
      $conn->close();
      echo $MenuItems;
  } else {
      echo "Error retrieving MenuItems: " . $conn->error;
  }
}}

function getMenuItemById($conn , $id) {
   if( !isset($id))
 {
 echo "Error:MenuItem Id is not set";
  return;
  }
  else
  {
  $sql = "select * from MenuItem where Id = ".$id;
  if ($result=$conn->query($sql)) {
      //$result = $conn->query($sql);
      $MenuItem = mysqli_fetch_object($result);
      $MenuItem = json_encode($MenuItem);
      $conn->close();
      echo $MenuItem;
  } else {
      echo "Error retrieving MenuItem: " . $conn->error;
  }
}}



function addMenuItem($conn,$name,$price,$description,$categoryId) {
   if( !isset($name))
 {
 echo "Error: MenuItem name is not set";
  return;
  }
// elseif (!isset($image)) {
//  echo "Error: MenuItem image Id is not set";
//   return;
//   }
  elseif (!isset($price)) {
 echo "Error: MenuItem price is not set";
  return;
  }
  elseif (!isset($description)) {
 echo "Error: MenuItem description is not set";
  return;
}
elseif (!isset($categoryId)) {
 echo "Error: Category Id is not set";
  return;
}
  else {
  $sql = "insert into menuitem (Name,Price,Description,CategoryId) values (?,?,?,?)"; // string should be quoted like that (single quotes)
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sdsi",$Name,$Price,$Description,$CategoryId); // not sure if float takes 'f'
  $Name=$name;
  //$Image=$image;
  $Price=$price;
  $Description=$description;
  $CategoryId=$categoryId;
  if ($stmt->execute()===TRUE) {
    echo "MenuItem Added successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
  $conn->close();
}
}



function editMenuItem($conn,$name,$price,$description,$id) {
  if( !isset($name))
 {
 echo "Error: MenuItem name is not set";
 return;
  }
// elseif (!isset($image)) {
//  echo "Error: MenuItem image is not set";
//   return;
//   }
  elseif (!isset($price)) {
 echo "Error: MenuItem price is not set";
  return;
  }
  elseif (!isset($description)) {
 echo "Error: MenuItem description is not set";
  return;
  }
  elseif (!isset($id)) {
 echo "Error: MenuItem id is not set";
  return;
  }
  else
  {
  $sql = "update MenuItem set Name = (?), Price=(?) ,Description =(?) where Id = (?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sdsi",$Name,$Price,$Description,$Id);
  $Name = $name;
  //$Image = $image;
  $Price = $price;
  $Description = $description;
  $Id = $id;
  //$conn->query($sql);
  if ($stmt->execute()===TRUE) {
    echo "MenuItem updated successfully";
  }
  else {
    echo "Error: ".$conn->error;

  }
}
}



function deleteMenuItem($conn,$id) {
 if (!isset($id))
  {
     echo "Error: Id is not set";
  return;
  }
  else{
  //$conn->query("set foreign_key_checks = 0"); // ????????/
  $sql = "delete from MenuItem where Id = ".$id;
  if ($conn->query($sql)===TRUE) {
    echo "MenuItem deleted successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}
}


?>
