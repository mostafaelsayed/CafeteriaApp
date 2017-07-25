<?php
include 'CafeteriaApp.Backend\connection.php';

function getCafeterias() {
  $connection = new Connection();
  $conn = $connection->check_connection();
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

function addCafeteria($n) {
  $connection = new Connection();
  $conn = $connection->check_connection();
  $sql = "insert into cafeteria (Name) values ('$n')"; // string should be quoted like that (single quotes)
  if ($conn->query($sql)===TRUE) {
    echo "Cafeteria Added successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
}

if ($_SERVER['REQUEST_METHOD']=="GET") {
  if (isset($_GET["action"]) && $_GET["action"]=="getCafeterias"){
    getCafeterias();
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
        addCafeteria($data->Name);
      }
      else{
        echo "name is required";
      }
  }
}

 ?>
