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
    if (isset($data->action) && $data->action == "addCafeteria"){ // chnage cafetria to uppercase first letter
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
      if ($data->Name != null && $data->Id != null) {
        editCafeteria($conn,$data->Name,$data->Id);
      }
      else{
        echo "name is required";
      }
}

if ($_SERVER['REQUEST_METHOD']=="DELETE") {
  $cafeteriaIdToDelete = $_GET["cafeteriaid"];
      if ($cafeteriaIdToDelete != null) {
        deleteCafeteria($conn,$cafeteriaIdToDelete);
      }
      else{
        //echo "No Id is provided";
      }
}

 ?>
