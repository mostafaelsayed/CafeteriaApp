<?php
include 'CafeteriaApp.Backend\connection.php';

function getDates($conn) {
  
  $sql = "select * from Dates";
  if ($conn->query($sql)) {
      $result = $conn->query($sql);
      $dates = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $dates = json_encode($dates);
      $conn->close();
      echo $dates;
  } else {
      echo "Error retrieving Dates: " . $conn->error;
  }

}

function addDate($conn,$n) {
  $sql = "insert into Dates (Date) values (?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s",$name);
  $name = $n;
  //$conn->query($sql);
  if ($stmt->execute()===TRUE) {
    echo "Role Added successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}

function editDate($conn,$n,$Id) {
  $sql = "update Dates set Date = (?) where Id = (?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("si",$name,$id);
  $name = $n;
  $id = $Id;
  //$conn->query($sql);
  if ($stmt->execute()===TRUE) {
    echo "Dates updated successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}

if ($_SERVER['REQUEST_METHOD']=="GET") {
  if (isset($_GET["action"]) && $_GET["action"]=="getRoles"){
    getRoles($conn);
  }
  else {
    echo "Error occured while returning Dates";
  }
}

if ($_SERVER['REQUEST_METHOD']=="POST"){
    //decode the json data
    $data = json_decode(file_get_contents("php://input"));
    if (isset($data->action) && $data->action == "addDate"){
      if ($data->Name != null){
        addDate($conn,$data->Name);
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
        editDate($conn,$data->Date,$data->Id);
      }
      else{
        echo "Date is required";
      }
  //}
}

 ?>
