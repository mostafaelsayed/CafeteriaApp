<?php
include 'CafeteriaApp.Backend\connection.php';

function getCafeterias($conn) {

  $sql = "select * from Cafeteria";
  $result = $conn->query($sql);
  if ($result) {
      $cafeterias = mysqli_fetch_all($result, MYSQLI_ASSOC); // ??
      $cafeterias = json_encode($cafeterias); // ??
      $conn->close();
      echo $cafeterias;
  } else {
      echo "Error retrieving Cafeterias : " . $conn->error;
  }

}


function getCafeteriaById($conn ,$id) {

  $sql = "select * from Cafeteria where Id =".$id;
  $result = $conn->query($sql);

  if ($result->query($sql)) {
      $cafeteria = mysqli_fetch_object($result); // fetch only the first row of the result
      $cafeteria = json_encode($cafeteria); // ??
      $conn->close();
      echo $cafeteria;
  } else {
      echo "Error retrieving Cafeteria : " . $conn->error;
  }

}


function addCafeteria($conn,$name) {

if( !isset($name))
 {
 echo "Error: Name is not set";
  return;
  }
// elseif (!isset($image)) {
//  echo "Error: Image is not set";
//   return;
//   }
  else
  {

  $sql = "insert into cafeteria (Name) values (?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s",$name);
  $name = $name;
  //$Image= $image;
  //$conn->query($sql);
  if ($stmt->execute()===TRUE) {
    echo "Cafeteria Added successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}
}


function editCafeteria($conn,$name,$id) {
  if( !isset($name))
 {
 echo "Error: Name is not set";
 return;
  }
 //   elseif( !isset($image))
 //  {
 // echo "Error: Image is not set";
 // return;
 //  }
elseif (!isset($id)) {
 echo "Error: Id is not set";
  return;
  }
  else
  {
  $sql = "update cafeteria set Name = (?) where Id = (?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("si",$Name,$Id);
  $Name = $name;
  //$Image = $image;
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
  $sql = "delete from cafeteria where Id = ".$id." LIMIT 1";
  if ($conn->query($sql)===TRUE) {
    echo "Cafeteria deleted successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}
}



 ?>
