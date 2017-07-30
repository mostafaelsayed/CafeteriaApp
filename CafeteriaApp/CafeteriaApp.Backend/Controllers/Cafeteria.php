<?php
include 'CafeteriaApp.Backend\connection.php';

function getCafeterias($conn) {

  $sql = "select * from Cafeteria";
  if ($conn->query($sql)) {
      $result = $conn->query($sql);
      $cafeterias = mysqli_fetch_all($result, MYSQLI_ASSOC); // ??
      $cafeterias = json_encode($cafeterias); // ??
      $conn->close();
      return $cafeterias;
  } else {
      echo "Error retrieving Cafeterias : " . $conn->error;
  }

}


function getCafeteriaById($conn ,$id) {

  $sql = "select * from Cafeteria where Id =".$id;
  if ($conn->query($sql)) {
      $result = $conn->query($sql);
      $cafeterias = mysqli_fetch_all($result, MYSQLI_ASSOC); // ??
      $cafeterias = json_encode($cafeterias); // ??
      $conn->close();
      return $cafeterias;
  } else {
      echo "Error retrieving Cafeterias : " . $conn->error;
  }

}


function addCafeteria($conn,$name,$image) {

if( !isset($name)) 
 {
 echo "Error: Name is not set";
  return;
  }
elseif (!isset($image)) {
 echo "Error: Image is not set";
  return;
  }
  else
  {

  $sql = "insert into cafeteria (Name,Image) values (?,?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ss",$name,$Image);
  $name = $name;
  $Image= $image;
  //$conn->query($sql);
  if ($stmt->execute()===TRUE) {
    echo "Cafeteria Added successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}
}


function editCafeteria($conn,$name,$image,$id) {
  if( !isset($name)) 
 {
 echo "Error: Name is not set";
 return;
  }
   elseif( !isset($image)) 
  {
 echo "Error: Image is not set";
 return;
  }
elseif (!isset($id)) {
 echo "Error: Id is not set";
  return;
  }
  else
  {
  $sql = "update cafeteria set Name = (?),Image = (?) where Id = (?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssi",$Name,$Image,$Id);
  $Name = $name;
  $Image = $image;
  $Id = $id;
  //$conn->query($sql);
  if ($stmt->execute()===TRUE) {
    echo "Cafeteria updated successfully";
  }
  else {
    echo "Error: ".$conn->error;
  
  }
}
}




function deleteCafeteria($conn,$id) {
 if (!isset($id))
  {
     echo "Error: Id is not set";
  return;
  }
  else{
  $conn->query("set foreign_key_checks = 0"); // ????????/
  $sql = "delete from cafeteria where Id = ".$id. "LIMIT 1";
  if ($conn->query($sql)===TRUE) {
    echo "Cafeteria deleted successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}
}



 ?>
