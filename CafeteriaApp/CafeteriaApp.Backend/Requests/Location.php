<?php

require('CafeteriaApp.Backend/Controllers/Location.php');
require('CafeteriaApp.Backend/connection.php');
require('CafeteriaApp.Backend/session.php');
require('TestRequestInput.php');

if ($_SERVER['REQUEST_METHOD'] == "GET")
{
  if (isset($_GET["userId"]) && test_int($_GET["userId"]))
  {
    checkResult(getUserLocations($conn,$_GET["userId"]));
  }
}

if ($_SERVER['REQUEST_METHOD'] == "POST")
{
  $data = json_decode(file_get_contents("php://input"));
  if (isset($data->UserId) && test_int($data->UserId) && normalize_string($conn,$data->PlaceName,$data->PlaceId,$data->PlaceAddress))
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

require('CafeteriaApp.Backend/footer.php');

?>