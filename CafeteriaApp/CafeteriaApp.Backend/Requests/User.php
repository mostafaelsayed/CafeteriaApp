<?php
require_once( 'CafeteriaApp.Backend/Controllers/User.php');
require_once("CafeteriaApp.Backend/connection.php");



if ($_SERVER['REQUEST_METHOD']=="GET") {
  if (isset($_GET["action"]) && $_GET["action"]=="getUsers"){
    getUsers($conn);
  }
  else {
    echo "Error occured while returning Users";
  }
}

if ($_SERVER['REQUEST_METHOD']=="POST"){
    //decode the json data
    $data = json_decode(file_get_contents("php://input"));
    if (isset($data->action) && $data->action == "addUser"){
      if ($data->Name != null){
        addUser($conn,$data->Name);
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
        editUser($conn,$data->Name,$data->Id);
      }
      else{
        echo "name is required";
      }
  //}
}

 ?>
