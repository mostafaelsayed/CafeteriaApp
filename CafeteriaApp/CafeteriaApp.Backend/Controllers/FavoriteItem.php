<?php
include 'CafeteriaApp.Backend\connection.php';

function getFavoriteItemsByCustomerId($conn,$Cid) {
  if( !isset($Cid)) 
 {
 echo "Error: Customer Id is not set";
  return;
  }
  else
  {
  $sql = "select * from FavoriteItem where CustomerId =".$Cid;
  $result = $conn->query($sql);
  if ($result) {
      $favoriteItems = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $favoriteItems = json_encode($favoriteItems);
      $conn->close();
      return $favoriteItems;
  } else {
      echo "Error retrieving FavoriteItems: " . $conn->error;
  }
}}


function getFavoriteItemById($conn,$id) {
  if( !isset($id)) 
 {
 echo "Error: FavoriteItem Id is not set";
  return;
  }
  else
  {
  $sql = "select * from FavoriteItem where CustomerId =".$id;
  $result = $conn->query($sql);
  if ($result) {
      $favoriteItems = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $favoriteItems = json_encode($favoriteItems);
      $conn->close();
      return $favoriteItems;
  } else {
      echo "Error retrieving FavoriteItems: " . $conn->error;
  }
}}


function addFavoriteItem($conn,$Cid,$Mid) {
   if (!isset($Cid)) {
 echo "Error: Customer Id is not set";
  return;
  }
  elseif (!isset($Mid)) {
 echo "Error: MenuItem Id is not set";
  return;
  }
  else {
  $sql = "insert into FavoriteItem (CustomerId,MenuItemId) values (?,?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ii",$CustomerId,$MenuItemId);
  $name = $Cid;
  $MenuItemId=$Mid;
  //$conn->query($sql);
  if ($stmt->execute()===TRUE) {
    echo "FavoriteItem Added successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}}



function deleteFavoriteItem($conn,$id) {
if (!isset($id)) {
 echo "Error: Id is not set";
  return;
  }
  else {
  //$conn->query("set foreign_key_checks=0");
  $sql = "delete from FavoriteItem where Id = ".$id. " LIMIT 1";
  if ($conn->query($sql)===TRUE) {
    echo "Comment FavoriteItem successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}}


// function editFavoriteItem($conn,$n,$Id) {
//   $sql = "update FavoriteItem set Name = (?) where Id = (?)";
//   $stmt = $conn->prepare($sql);
//   $stmt->bind_param("si",$name,$id);
//   $name = $n;
//   $id = $Id;
//   //$conn->query($sql);
//   if ($stmt->execute()===TRUE) {
//     echo "FavoriteItem updated successfully";
//   }
//   else {
//     echo "Error: ".$conn->error;
//   }
// }



 ?>
