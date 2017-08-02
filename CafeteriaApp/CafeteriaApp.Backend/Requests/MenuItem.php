<?php
require_once( 'CafeteriaApp.Backend/Controllers/MenuItem.php');
require_once("CafeteriaApp.Backend/connection.php");



if ($_SERVER['REQUEST_METHOD']=="GET") {
  if (isset($_GET["categoryId"])) {
    getMenuItemByCategoryId($conn,$_GET["categoryId"]);
  }
  // elseif (isset($_GET["id"])) {
  //   getMenuItemById($conn,$_GET["id"]);
  // }
  // else {
  //   echo "Error occured while returning MenuItem";
  // }
}

// i don't know how to handle
if ($_SERVER['REQUEST_METHOD']=="POST"){
    //decode the json data
    $data = json_decode(file_get_contents("php://input"));// ????????????
    if (isset($data->CategoryId) && isset($data->Name) && isset($data->Description) && $data->CategoryId != null && $data->Name != null && $data->Description != null){
        addMenuItem($conn,$data->Name ,$data->Price ,$data->Description , $data->CategoryId);
      }
      else{
        echo "name is required";
      }
}

if ($_SERVER['REQUEST_METHOD']=="PUT"){
  //decode the json data
  $data = json_decode(file_get_contents("php://input"));
    if ($data->Name != null && $data->Id != null) {
      editMenuItem($conn,$data->Name,$data->Price,$data->Description,$data->Id);
    }
    else{
      echo "name is required";
    }
}

if ($_SERVER['REQUEST_METHOD']=="DELETE") {
  $menuItemIdToDelete = $_GET["menuItemId"];
      if ($menuItemIdToDelete != null) {
        deleteMenuItem($conn,$menuItemIdToDelete);
      }
      else{
        //echo "No Id is provided";
      }
}

?>
