<?php

require_once( 'CafeteriaApp.Backend/Controllers/Category.php');
require_once("CafeteriaApp.Backend/connection.php");

if ($_SERVER['REQUEST_METHOD']=="GET")
{
  if (isset($_GET["cafeteriaId"]) && $_GET["cafeteriaId"] != null && !isset($_GET["id"]))
  {
    getByCafeteriaId($conn,$_GET["cafeteriaId"]);
  }
  elseif (isset($_GET["id"]) && $_GET["id"] != null && !isset($_GET["cafeteriaId"]))
  {
    getCategoryById($conn,$_GET["id"]);
  }
  else
  {
    echo "Error occured while returning categories";
  }
}

if ($_SERVER['REQUEST_METHOD']=="POST")
{
  $data = json_decode(file_get_contents("php://input"));
  if (isset($data->Name) && $data->Name != null && isset($data->CafeteriaId) && $data->CafeteriaId != null)
  {
    if (!isset($data->Image))
    {
      addCategory($conn,$data->Name,$data->CafeteriaId);
    }
    elseif (isset($data->Image))
    {
      addCategory($conn,$data->Name,$data->CafeteriaId,$data->Image);
    }
  }
  else
  {
    if(!isset($data->Name) || $data->Name == null)
    {
      echo "Error: Name is Required";
    }
    elseif (!isset($data->CafeteriaId) || $data->CafeteriaId == null)
    {
      echo "Error: No Cafeteria Id is Provided";
    }
  }
}

if ($_SERVER['REQUEST_METHOD']=="PUT")
{
  //decode the json data
  $data = json_decode(file_get_contents("php://input"));
  if ($data->Name != null && $data->Id != null)
  {
    if(!isset($data->Image))
    {
      editCategory($conn,$data->Name,$data->Id);
    }
    else
    {
      editCategory($conn,$data->Name,$data->Id,$data->Image);
    }
  }
  else
  {
    echo "name is required";
  }
}

if ($_SERVER['REQUEST_METHOD']=="DELETE")
{
  if (!isset($_GET["categoryId"]) || $_GET["categoryId"] != null)
  {
    deleteCategory($conn,$_GET["categoryId"]);
  }
  else
  {
    echo "No Id is provided";
  }
}

require_once("CafeteriaApp.Backend/footer.php");

?>
