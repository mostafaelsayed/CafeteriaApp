<?php
require_once( 'CafeteriaApp.Backend/Controllers/Dates.php');


if ($_SERVER['REQUEST_METHOD']=="GET") {
  if (isset($_GET["action"]) && $_GET["action"]=="getDates"){
    getDates($conn);
  }
  else {
    echo "Error occured while returning Dates";
  }
}

if ($_SERVER['REQUEST_METHOD']=="POST"){
    //decode the json data
    $data = json_decode(file_get_contents("php://input"));
    if (isset($data->action) && $data->action == "addDate"){
      if ($data->Name != null){
        addDate($conn,$data->Name);
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
        editDate($conn,$data->Date,$data->Id);
      }
      else{
        echo "Date is required";
      }
}

 ?>
