<?php
include 'CafeteriaApp.Backend\connection.php';

function getByCafeteriaId($conn,$id) {
  
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



function addCategory($conn,$name,$CafetriaId) {
  $sql = "insert into category (Name,CafeteriaId) values ('$name',$CafetriaId)"; // string should be quoted like that (single quotes)
  if ($conn->query($sql)===TRUE) {
=======
function addCategory($n,$Id) {
  $connection = new Connection();
  $conn = $connection->check_connection();
  $sql = "insert into category (Name,CafeteriaId) values (?,?)"; // string should be quoted like that (single quotes)
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("si",$name,$id);
  $name = $n;
  $id = $Id;
  if ($stmt->execute()===TRUE) {
>>>>>>> origin/master
    echo "Category Added successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
  $conn->close();
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
?>
