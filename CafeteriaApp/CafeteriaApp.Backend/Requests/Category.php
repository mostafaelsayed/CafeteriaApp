<?php
require_once( 'CafeteriaApp.Backend/Controllers/Category.php');
require_once("CafeteriaApp.Backend/connection.php");


if ($_SERVER['REQUEST_METHOD']=="GET") {
  if (isset($_GET["cafeteriaId"])) {
    getByCafeteriaId($conn,$_GET["cafeteriaId"]);
  }
  elseif ($_GET["id"] != null) {
    getCategoryById($conn,$_GET["id"]);
  }
  else {
    echo "Error occured while returning categories";
  }
}

if ($_SERVER['REQUEST_METHOD']=="POST") {
  $data = json_decode(file_get_contents("php://input"));
  if (!isset($data->Image)) {
    $data->Image = null;
  }
  if (isset($data->Name) && $data->Name != null && isset($data->CafeteriaId) && $data->CafeteriaId != null) {
    addCategory($conn,$data->Name,$data->CafeteriaId,$data->Image);
  }
}

if ($_SERVER['REQUEST_METHOD']=="PUT") {
  //decode the json data
  $data = json_decode(file_get_contents("php://input"));
  if ($data->Name != null && $data->Id != null) {
    if(!isset($data->Image)) {
      editCategory($conn,$data->Name,$data->Id);
    }
    else
    {
      editCategory($conn,$data->Name,$data->Id,$data->Image);
    }
  }
  else{
    echo "name is required";
  }
}

if ($_SERVER['REQUEST_METHOD']=="DELETE") {
  $categoryIdToDelete = $_GET["categoryId"];
  if ($categoryIdToDelete != null) {
    deleteCategory($conn,$categoryIdToDelete);
  }
  else {
    echo "No Id is provided";
  }
}

require_once("CafeteriaApp.Backend/footer.php");

?>
