<?php
require_once( 'CafeteriaApp.Backend/Controllers/Addition.php');
require_once("CafeteriaApp.Backend/connection.php");



if ($_SERVER['REQUEST_METHOD']=="GET") {
  if (isset($_GET["action"]) && $_GET["action"]=="getAdditions"){
    getAdditions($conn);
  }
  else {
    echo "Error occured while returning Additions";
  }
}

if ($_SERVER['REQUEST_METHOD']=="POST"){
    //decode the json data
    $data = json_decode(file_get_contents("php://input"));
    if (isset($data->action) && $data->action == "addAddition"){
      if ($data->Name != null){
        addAddition($conn,$data->Name);
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
        editAddition($conn,$data->Name,$data->Id);
      }
      else{
        echo "name is required";
      }
  //}
}

 ?>
