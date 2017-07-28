<?php
include 'CafeteriaApp.Backend\connection.php';

function getCategoryByCafeteriaId($conn,$id) {
  
  $sql = "select * from category where CafeteriaId = $id";
  if ($conn->query($sql)) {
      $result = $conn->query($sql);
      $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $categories = json_encode($categories);
      $conn->close();
      echo $categories;
  } else {
      echo "Error retrieving categories: " . $conn->error;
  }
}



function addCategory($conn,$name,$CafeteriaId) {
  $sql = "insert into category (Name,CafeteriaId) values (?,?)"; // string should be quoted like that (single quotes)
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("si",$n,$id);
  $n = $name;
  $id = $CafeteriaId;
  //echo $stmt->execute();
  if ($stmt->execute()===TRUE){
    echo "Category Added successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
  $conn->close();
}

function editCategory($conn,$n,$Id) {
  $sql = "update category set Name = (?) where Id = (?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("si",$name,$id);
  $name = $n;
  $id = $Id;
  //$conn->query($sql);
  if ($stmt->execute()===TRUE) {
    echo "Category updated successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}

function deleteCategory($conn,$Id) {
  $conn->query("set foreign_key_checks=0");
  $sql = "delete from category where Id = ".$Id;
  if ($conn->query($sql)===TRUE) {
    echo "Category deleted successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}


if ($_SERVER['REQUEST_METHOD']=="GET") {
  if ($_GET["Id"] != null) {
    getByCafeteriaId($conn,$_GET["Id"]);
  }
  else {
    echo "Error occured while returning cafeterias";
  }
}

if ($_SERVER['REQUEST_METHOD']=="POST"){
    //decode the json data
    $data = json_decode(file_get_contents("php://input"));
    if (isset($data->action) && $data->action == "addCategory" && $data->CafeteriaId != null && $data->Name != null){
        addCategory($conn,$data->Name,$data->CafeteriaId);
      }
      else{
        echo "error occured while creating category";
      }
}

if ($_SERVER['REQUEST_METHOD']=="PUT"){
    //decode the json data
    $data = json_decode(file_get_contents("php://input"));
      if ($data->Name != null && $data->Id != null) {
        editCategory($conn,$data->Name,$data->Id);
      }
      else{
        echo "name is required";
      }
}

if ($_SERVER['REQUEST_METHOD']=="DELETE") {
  $categoryIdToDelete = $_GET["categoryid"];
      if ($categoryIdToDelete != null) {
        deleteCategory($conn,$categoryIdToDelete);
      }
      else{
        //echo "No Id is provided";
      }
}

?>
