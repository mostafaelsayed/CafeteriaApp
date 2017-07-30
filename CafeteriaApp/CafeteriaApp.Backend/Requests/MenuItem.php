<?php
require_once( 'CafeteriaApp.Backend/Controllers/MenuItem.php');



if ($_SERVER['REQUEST_METHOD']=="GET") {
  if ($_GET["Id"] != null) {
    getMenuItemByCategoryId($conn,$_GET["Id"]);
  }
  else {
    echo "Error occured while returning MenuItems";
  }
}

// i don't know how to handle
if ($_SERVER['REQUEST_METHOD']=="POST"){
    //decode the json data
    $data = json_decode(file_get_contents("php://input"));// ????????????
    if (isset($data->action) && $data->action == "addMenuItem" && $data->CategoryId != null && $data->Name != null){
        addMenuItem($conn,$data->Name ,$data->Price ,$data->Description , $data->CategoryId);
      }
      else{
        echo "name is required";
      }
}
?>
