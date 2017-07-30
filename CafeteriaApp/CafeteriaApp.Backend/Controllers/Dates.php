<?php
include 'CafeteriaApp.Backend\connection.php';

function getDates($conn) {
  
  $sql = "select * from Dates";
  if ($conn->query($sql)) {
      $result = $conn->query($sql);
      $dates = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $dates = json_encode($dates);
      $conn->close();
      return $dates;
  } else {
      echo "Error retrieving Dates: " . $conn->error;
  }
}


function addDate($conn,$date) { // check format of the input
 if (!isset($date)) {
 echo "Error: Date is not set";
  return;
  }
  else {
  $sql = "insert into Dates (Date) values (?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s",$Date);
  $Date = $date;
  //$conn->query($sql);
  if ($stmt->execute()===TRUE) {
    echo "Date Added successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}}


function editDate($conn,$date,$id) {
  if (!isset($id)) {
 echo "Error: Id is not set";
  return;
  }
  elseif (!isset($date)) {
 echo "Error: Date is not set";
  return;
  }
  else {
  $sql = "update Dates set Date = (?) where Id = (?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("si",$Date,$Id);
  $Date = $date;
  $Id = $id;
  //$conn->query($sql);
  if ($stmt->execute()===TRUE) {
    echo "Date updated successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}}


function deleteDate($conn,$id) {
if (!isset($id)) {
 echo "Error: Id is not set";
  return;
  }
  else {
  //$conn->query("set foreign_key_checks=0");
  $sql = "delete from Dates where Id = ".$id. "LIMIT 1";
  if ($conn->query($sql)===TRUE) {
    echo "Date deleted successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}}


if ($_SERVER['REQUEST_METHOD']=="GET") {
  if (isset($_GET["action"]) && $_GET["action"]=="getDates"){
    getDates($conn);
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
