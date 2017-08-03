<?php
require_once( 'CafeteriaApp.Backend/Controllers/Times.php');
require_once("CafeteriaApp.Backend/connection.php");

 getCurrentTimeId($conn);
//
// if ($_SERVER['REQUEST_METHOD']=="GET") {
//   if (isset($_GET["action"]) && $_GET["action"]=="getTimes"){
//     getTimes($conn);
//   }
//   else {
//     echo "Error occured while returning Times";
//   }
// }
//
// if ($_SERVER['REQUEST_METHOD']=="POST"){
//     //decode the json data
//     $data = json_decode(file_get_contents("php://input"));
//     if (isset($data->action) && $data->action == "addTime"){
//       if ($data->Name != null){
//         addTime($conn);
//       }
//       else{
//         echo "Time is required";
//       }
//   }
// }



// if ($_SERVER['REQUEST_METHOD']=="PUT"){
//     //decode the json data
//     $data = json_decode(file_get_contents("php://input"));
//     //echo $data;
//       if ($data->Name != null && $data->Id != null) {
//         //if ($data->action == "addcafeteria"){
//         editTime($conn,$data->Name,$data->Id);
//       }
//       else{
//         echo "Time is required";
//       }
//   //}
// }

 
require_once("CafeteriaApp.Backend/footer.php");

 ?>
