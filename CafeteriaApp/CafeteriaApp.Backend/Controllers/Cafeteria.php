<?php
include 'CafeteriaApp.Backend\connection.php';

function getCafeterias($conn) {
  
  $sql = "select * from cafeteria";
  if ($conn->query($sql)) {
      $result = $conn->query($sql);
      $cafeterias = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $cafeterias = json_encode($cafeterias);
      $conn->close();
      echo $cafeterias;
  } else {
      echo "Error retrieving cafeterias: " . $conn->error;
  }

}

function addCafeteria($conn,$n) {
  $sql = "insert into cafeteria (Name) values (?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s",$name);
  $name = $n;
  //$conn->query($sql);
  if ($stmt->execute()===TRUE) {
    echo "Cafeteria Added successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}

function editCafeteria($conn,$n,$Id) {
  $sql = "update cafeteria set Name = (?) where Id = (?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("si",$name,$id);
  $name = $n;
  $id = $Id;
  //$conn->query($sql);
  if ($stmt->execute()===TRUE) {
    echo "Cafeteria updated successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}

if ($_SERVER['REQUEST_METHOD']=="GET") {
  if (isset($_GET["action"]) && $_GET["action"]=="getCafeterias"){
    getCafeterias($conn);
  }
  else {
    echo "Error occured while returning cafeterias";
  }
}

if ($_SERVER['REQUEST_METHOD']=="POST"){
    //decode the json data
    $data = json_decode(file_get_contents("php://input"));
    if (isset($data->action) && $data->action == "addcafeteria"){
      if ($data->Name != null){
        addCafeteria($conn,$data->Name);
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
        editCafeteria($conn,$data->Name,$data->Id);
      }
      else{
        echo "name is required";
      }
  //}
}

 ?>
