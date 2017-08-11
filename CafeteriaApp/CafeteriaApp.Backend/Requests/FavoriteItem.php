<?php
require_once( 'CafeteriaApp.Backend/Controllers/FavoriteItem.php');
require_once("CafeteriaApp.Backend/connection.php");
require_once("CafeteriaApp.Backend/session.php");


if ($_SERVER['REQUEST_METHOD']=="GET") {
  
    getFavoriteItemsByCustomerId($conn,$_SESSION["customerId"]);

}


if ($_SERVER['REQUEST_METHOD']=="DELETE") {
  if (isset($_GET["Id"])){
    deleteFavoriteItem($conn,$_GET["Id"]);
  }
  else {
    echo "Error occured while deleting Favorite Item ";
  }
}


if ($_SERVER['REQUEST_METHOD']=="POST"){
    //decode the json data
    $data = json_decode(file_get_contents("php://input"));
    if (isset($data->action) && $data->action == "addFavoriteItem"){
      if ($data->Name != null){
        addFavoriteItem($conn,$data->Name);
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
        editFavoriteItem($conn,$data->Name,$data->Id);
      }
      else{
        echo "name is required";
      }
  //}
}
require_once("CafeteriaApp.Backend/footer.php");

 ?>
