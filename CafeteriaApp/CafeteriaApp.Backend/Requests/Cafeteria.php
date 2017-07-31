<?php
require_once( 'CafeteriaApp.Backend/Controllers/Cafeteria.php');


if ($_SERVER['REQUEST_METHOD']=="GET") {
  if (isset($_GET["action"]) && $_GET["action"]=="getCafeterias"){
    getCafeterias($conn);
  }
  elseif (isset($_GET["id"])) {
    getCafeteriaById($conn,$_GET["id"]);
  }
  else {
    echo "Error occured while returning cafeterias";
  }
}

if ($_SERVER['REQUEST_METHOD']=="POST"){
    //decode the json data
    $data = json_decode(file_get_contents("php://input"));
    //if (isset($d $data->action == "addCafeteria"){ // chnage cafetria to uppercase first letter
      if ($data->Name != null){
        addCafeteria($conn,$data->Name);
      }
      else{
        echo "name is required";
      }
  //}
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
  $cafeteriaIdToDelete = $_GET["cafeteriaId"];
      if ($cafeteriaIdToDelete != null) {
        deleteCafeteria($conn,$cafeteriaIdToDelete);
      }
      else{
        //echo "No Id is provided";
      }
}

 ?>
