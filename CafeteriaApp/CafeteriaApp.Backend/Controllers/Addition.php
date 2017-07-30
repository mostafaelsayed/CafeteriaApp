<?php
include 'CafeteriaApp.Backend\connection.php';

function getAdditionsByCategoryId($conn,$id) {
  
  $sql = "select * from Addition where CategoryId=".$id;
  if ($conn->query($sql)) {
      $result = $conn->query($sql);
      $additions = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $additions = json_encode($additions);
      $conn->close();
      echo $additions;
  } else {
      echo "Error retrieving Additions: " . $conn->error;
  }
}

function getAdditionsById($conn,$id) {
  
  $sql = "select * from Addition where Id=".$id;
  if ($conn->query($sql)) {
      $result = $conn->query($sql);
      $additions = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $additions = json_encode($additions);
      $conn->close();
      echo $additions;
  } else {
      echo "Error retrieving Additions: " . $conn->error;
  }
}


function addAddition($conn,$name,$price,$categoryId) {
  $sql = "insert into Addition (Name,Price,CategoryId) values (?,?,?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("sfi",$Name,$Price ,$CategoryId);
  $Name = $name;
  $Price=$price;
  $CategoryId=$categoryId;
  //$conn->query($sql);
  if ($stmt->execute()===TRUE) {
    echo "Addition Added successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}



function editAddition($conn,$name,$price,$id) {
  $sql = "update Addition set Name = (?) , Price=(?) where Id = (?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssi",$Name,$Price,$Id);
  $Name = $name;
  $Price=$price;
  $Id = $id;
  //$conn->query($sql);
  if ($stmt->execute()===TRUE) {
    echo "Addition updated successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}


function deleteAddition($conn,$id) {
 if (!isset($id))
  {
     echo "Error: Id is not set";
  return;
  }
  else{
  //$conn->query("set foreign_key_checks = 0"); // ????????/
  $sql = "delete from Addition where Id = ".$id . "LIMIT 1";
  if ($conn->query($sql)===TRUE) {
    echo "Addition deleted successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}
}


 ?>
