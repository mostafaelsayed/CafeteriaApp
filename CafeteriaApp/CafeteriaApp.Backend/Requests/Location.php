<?php

require_once('CafeteriaApp.Backend/Controllers/Location.php');
require_once('CafeteriaApp.Backend/connection.php');
require_once('CafeteriaApp.Backend/session.php');
require_once ('CheckResult.php');

if ($_SERVER['REQUEST_METHOD']=="GET")
{
  if (isset($_GET["userId"]))
  {
    checkResult(getUserLocations($conn,$_GET["userId"]));
  }
  // else
  // {
  //   checkResult(getCafeterias($conn));
  // }
}

if ($_SERVER['REQUEST_METHOD']=="POST")
{
  $data = json_decode(file_get_contents("php://input"));
  if (isset($data->PlaceId) && isset($data->PlaceName) && isset($data->PlaceAddress) && isset($data->UserId))
  {
    addLocation($conn,$data->PlaceId,$data->PlaceName,$data->PlaceAddress,$data->UserId);
  }
}

// if ($_SERVER['REQUEST_METHOD']=="PUT")
// {
//   //decode the json data
//   $data = json_decode(file_get_contents("php://input"));
//   if (isset($data->Name) && isset($data->Id) && $data->Name != null && $data->Id != null)
//   {
//     if (!isset($data->Image))
//     {
//       editCafeteria($conn,$data->Name,$data->Id);
//     }
//     else
//     {
//       editCafeteria($conn,$data->Name,$data->Id,$data->Image);
//     }
//   }
//   else
//   {
//     echo "name is required";
//   }
// }

// if ($_SERVER['REQUEST_METHOD']=="DELETE")
// {
//   $cafeteriaIdToDelete = $_GET["cafeteriaId"];
//   if ($cafeteriaIdToDelete != null)
//   {
//     deleteCafeteria($conn,$cafeteriaIdToDelete);
//   }
//   else
//   {
//     echo "No Id is provided";
//   }
// }

require_once("CafeteriaApp.Backend/footer.php");

?>