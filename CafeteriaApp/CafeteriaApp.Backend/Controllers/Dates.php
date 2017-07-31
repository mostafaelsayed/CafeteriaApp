<?php
include 'CafeteriaApp.Backend\connection.php';

function getDates($conn) {
  
  $sql = "select * from Dates";
  $result = $conn->query($sql);
  if ($result)
   {    
      $dates = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $dates = json_encode($dates);
      $conn->close();
      return $dates;
  } else {
      echo "Error retrieving Dates: " . $conn->error;
  }
}

function getDateById($conn ,$id) {
  if (!isset($id)) {
 echo "Error: Date id is not set";
  return;
  }
  else {
  $sql = "select Date from Dates where Id=".$id;
  $result = $conn->query($sql);
  if ($result) {
      $Id = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $Id= json_encode($Id);
      $conn->close();
      return $Id;
  } else {
      echo "Error retrieving Dates: " . $conn->error;
  }
}}


function getIdByDate($conn ,$value) {
  if (!isset($value)) {
 echo "Error: Date value  is not set";
  return;
  }
  else {
  $sql = "select Id from Dates where Date=".$value;
   $result = $conn->query($sql);
  if ($result) {
      $date = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $date= json_encode($date);
      $conn->close();
      return $date;
  } else {
      echo "Error retrieving Dates: " . $conn->error;
  }
}}


function getIdByTodayDate($conn) { //CURDATE() mysql
  $today = date("Y-m-d");
  $sql = "select Id from Dates where Date = STR_TO_DATE('{$today}', '%Y-%m-%d')";
  $result = $conn->query($sql);
  if ($result) {
      $date = mysqli_fetch_all($result, MYSQLI_ASSOC);
      //echo $date[0]["Id"] ;
      $date= json_encode($date);
      $conn->close();
      return $date;
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


function addTodayDate($conn) { // check format of the input
 
  $sql = "insert into Dates (Date) values (?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s",$Date);
  $Date = date("Y/m/d");
  //$conn->query($sql);
  if ($stmt->execute()===TRUE) {
    echo "Date Added successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}


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
  $sql = "delete from Dates where Id = ".$id. " LIMIT 1";
  if ($conn->query($sql)===TRUE) {
    echo "Date deleted successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}}


 ?>
