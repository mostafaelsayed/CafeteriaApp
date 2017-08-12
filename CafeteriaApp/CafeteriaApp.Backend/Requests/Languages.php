<?php
require_once( 'CafeteriaApp.Backend/Controllers/Languages.php');
require_once("CafeteriaApp.Backend/connection.php");


if ($_SERVER['REQUEST_METHOD']=="GET") {
  
    getLanguages($conn);

}


if ($_SERVER['REQUEST_METHOD']=="DELETE") {
  if (isset($_GET["Id"])){
    deleteLanguage($conn,$_GET["Id"]);
  }
  else {
    echo "Error occured while deleting Favorite Item ";
  }
}


if ($_SERVER['REQUEST_METHOD']=="POST"){
    //decode the json data
    $data = json_decode(file_get_contents("php://input"));
   
      if ($data->Name != null){
        addLanguage($conn,$data->Name);
      }
      else{
        echo "name is required";
      }
  
}

if ($_SERVER['REQUEST_METHOD']=="PUT"){
    //decode the json data
    $data = json_decode(file_get_contents("php://input"));
    //echo $data;
      if ($data->Name != null && $data->Id != null) {
        //if ($data->action == "addcafeteria"){
        editLanguage($conn,$data->Name,$data->Id);
      }
      else{
        echo "name is required";
      }
  //}
}
require_once("CafeteriaApp.Backend/footer.php");

 ?>
