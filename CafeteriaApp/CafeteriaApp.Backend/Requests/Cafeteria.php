<?php

require_once( 'CafeteriaApp.Backend/Controllers/Cafeteria.php');
require_once("CafeteriaApp.Backend/connection.php");

if ($_SERVER['REQUEST_METHOD']=="GET")
{
  if (isset($_GET["id"]))
  {
    getCafeteriaById($conn,$_GET["id"]);
  }
  else
  {
    getCafeterias($conn);
  }
}

if ($_SERVER['REQUEST_METHOD']=="POST")
{
  $data = json_decode(file_get_contents("php://input"));
  if (!isset($data->Image))
  {
    addCafeteria($conn,$data->Name);
  }
  elseif (isset($data->Name) && $data->Name != null)
  {
    addCafeteria($conn,$data->Name,$data->Image);
  }
}

if ($_SERVER['REQUEST_METHOD']=="PUT")
{
  //decode the json data
  $data = json_decode(file_get_contents("php://input"));
  if (isset($data->Name) && isset($data->Id) && $data->Name != null && $data->Id != null)
  {
    if(!isset($data->Image))
    {
      editCafeteria($conn,$data->Name,$data->Id);
    }
    else
    {
      editCafeteria($conn,$data->Name,$data->Id,$data->Image);
    }
  }
  else
  {
    echo "name is required";
  }
}

if ($_SERVER['REQUEST_METHOD']=="DELETE")
{
  $cafeteriaIdToDelete = $_GET["cafeteriaId"];
  if ($cafeteriaIdToDelete != null)
  {
    deleteCafeteria($conn,$cafeteriaIdToDelete);
  }
  else
  {
    echo "No Id is provided";
  }
}

require_once("CafeteriaApp.Backend/footer.php");

?>
