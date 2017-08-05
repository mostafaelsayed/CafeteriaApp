<?php
require_once( 'CafeteriaApp.Backend/Controllers/Comment.php');
require_once("CafeteriaApp.Backend/connection.php");


if ($_SERVER['REQUEST_METHOD']=="GET") {
  if (isset($_GET["action"]) && $_GET["action"]=="getComments"){
    getComments($conn);
  }
  else {
    echo "Error occured while returning Details";
  }
}

if ($_SERVER['REQUEST_METHOD']=="POST"){
    //decode the json data
    $data = json_decode(file_get_contents("php://input"));
    if (isset($data->action) && $data->action == "addComment"){
      if ($data->Details != null){
        addComment($conn,$data->Details);
      }
      else{
        echo "Details is required";
      }
  }
}

if ($_SERVER['REQUEST_METHOD']=="PUT"){
    //decode the json data
    $data = json_decode(file_get_contents("php://input"));
    //echo $data;
      if ($data->Details != null && $data->Id != null) {
        //if ($data->action == "addcafeteria"){
        editComment($conn,$data->Details,$data->Id);
      }
      else{
        echo "Details is required";
      }
  //}
}


require_once("CafeteriaApp.Backend/footer.php");

 ?>
