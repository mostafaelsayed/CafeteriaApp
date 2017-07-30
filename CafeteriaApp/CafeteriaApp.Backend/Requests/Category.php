<?php
require_once( 'CafeteriaApp.Backend/Controllers/Category.php');


if ($_SERVER['REQUEST_METHOD']=="GET") {
  if ($_GET["Id"] != null) {
    getByCafeteriaId($conn,$_GET["Id"]);
  }
  else {
    echo "Error occured while returning categories";
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

if ($_SERVER['REQUEST_METHOD']=="PUT"){
    //decode the json data
    $data = json_decode(file_get_contents("php://input"));
      if ($data->Name != null && $data->Id != null) {
        editCategory($conn,$data->Name,$data->Id);
      }
      else{
        echo "name is required";
      }
}

if ($_SERVER['REQUEST_METHOD']=="DELETE") {
  $categoryIdToDelete = $_GET["categoryid"];
      if ($categoryIdToDelete != null) {
        deleteCategory($conn,$categoryIdToDelete);
      }
      else{
        //echo "No Id is provided";
      }
}

?>
