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
  if ($conn->query($sql)) {
      $result = $conn->query($sql);
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
  $sql = "delete from FavoriteItem where Id = ".$id. "LIMIT 1";
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



if ($_SERVER['REQUEST_METHOD']=="GET") {
  if (isset($_GET["action"]) && $_GET["action"]=="getFavoriteItems"){
    getFavoriteItems($conn);
  }
  else {
    echo "Error occured while returning FavoriteItems";
  }
}

if ($_SERVER['REQUEST_METHOD']=="POST"){
    //decode the json data
    $data = json_decode(file_get_contents("php://input"));
    if (isset($data->action) && $data->action == "addFavoriteItem"){
      if ($data->Name != null){
        addFavoriteItem($conn,$data->Name);
      }
      else{
        echo "name is required";
      }
  }
}

if ($_SERVER['REQUEST_METHOD']=="PUT"){
    //decode the json data
    $data = json_decode(file_get_contents("php://input"));
    //echo $data;
      if ($data->Name != null && $data->Id != null) {
        //if ($data->action == "addcafeteria"){
        editFavoriteItem($conn,$data->Name,$data->Id);
      }
      else{
        echo "name is required";
      }
  //}
}

 ?>
