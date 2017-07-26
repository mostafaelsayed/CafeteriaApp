<?php
include 'CafeteriaApp.Backend\connection.php';

function getByMenuItemId($conn , $id) {
  
  $sql = "select * from MenuItem where CategoryId = $id";
  if ($conn->query($sql)) {
      $result = $conn->query($sql);
      $MenuItems = mysqli_fetch_all($result, MYSQLI_ASSOC);
      $MenuItems = json_encode($MenuItems);
      $conn->close();
      echo $MenuItems;
  } else {
      echo "Error retrieving MenuItems: " . $conn->error;
  }
}


function addMenuItem($conn,$name,$Image,$Price,$Description,$CategoryId) {
  $sql = "insert into MenuItem (Name,Image,Price,Description,CategoryId) values ('$name','$Image',$Price,'$Description',$CategoryId)"; // string should be quoted like that (single quotes)
  if ($conn->query($sql)===TRUE) {
    echo "MenuItem Added successfully";
  }
  else {
    echo "Error: ".$conn->error;
  }
  $conn->close();
}



if ($_SERVER['REQUEST_METHOD']=="GET") {
  if ($_GET["Id"] != null) {
    getByMenuItemId($conn,$_GET["Id"]);
  }
  else {
    echo "Error occured while returning cafeterias";
  }
}

// i don't know how to handle
if ($_SERVER['REQUEST_METHOD']=="POST"){
    //decode the json data
    $data = json_decode(file_get_contents("php://input"));// ????????????
    if (isset($data->action) && $data->action == "addMenuItem" && $data->Id != null && $data->Name != null){
        addMenuItem($conn,$data->Name,$data->Image ,$data->Price ,$data->Description , $data->Id);
      }
      else{
        echo "name is required";
      }
}
?>
