<?php
include 'CafeteriaApp.Backend\connection.php';

function getFavoriteItems($conn) {
  
  $sql = "select * from FavoriteItem";
  if ($conn->query($sql)) {
      $result = $conn->query($sql);
      $favoriteItems = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $favoriteItems = json_encode($favoriteItems);
      $conn->close();
      echo $favoriteItems;
  } else {
      echo "Error retrieving FavoriteItems: " . $conn->error;
  }
}


function addFavoriteItem($conn,$n) {
  $sql = "insert into FavoriteItem (Name) values (?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s",$name);
  $name = $n;
  //$conn->query($sql);
  if ($stmt->execute()===TRUE) {
    echo "FavoriteItem Added successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}


function editFavoriteItem($conn,$n,$Id) {
  $sql = "update FavoriteItem set Name = (?) where Id = (?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("si",$name,$id);
  $name = $n;
  $id = $Id;
  //$conn->query($sql);
  if ($stmt->execute()===TRUE) {
    echo "FavoriteItem updated successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}

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
