<?php

require_once( 'CafeteriaApp.Backend/Controllers/Cafeteria.php');
require_once("CafeteriaApp.Backend/connection.php");

if ($_SERVER['REQUEST_METHOD']=="GET") {
  if (isset($_GET["id"])) {
    getCafeteriaById($conn,$_GET["id"]);
  }
  else {
    getCafeterias($conn);
  }
}

if ($_SERVER['REQUEST_METHOD']=="POST") {
  global $filePath;
  if ($_POST["name"] != null) {
    if (isset($_FILES['imageToUpload'])) {
      $uploadDir = "../uploads/"; // get parent directory
      $fileName = basename($_FILES["imageToUpload"]["name"]); // filename
      $tmp_name = $_FILES['imageToUpload']['tmp_name'];
      $filePath = "/CafeteriaApp.Backend/uploads/".$fileName;
      $uploadedFile = $uploadDir . $fileName;
      if (file_exists($uploadedFile)) {
        $filePath = null;
        echo "file with the same name already exists";
      }
      elseif (getimagesize($tmp_name) != true) { // file is not an image
        $filePath = null;
        echo "file is not an image";
      }
      else {
        if (move_uploaded_file($tmp_name,$uploadedFile)) {
          echo "File is successfully uploaded";
        }
        else {
          echo "Error: ".$conn->error;
        }
      }
    }
    else {
      $filePath = null;
    }
    addCafeteria($conn,$_POST["name"],$filePath);
    header("Location: " . rawurldecode("/CafeteriaApp.Frontend/Areas/Admin/Cafeteria/Views/showing and deleting cafeterias.php"));
  }
  else {
    echo "name is required";
  }
}

if ($_SERVER['REQUEST_METHOD']=="PUT") {
    //decode the json data
  $data = json_decode(file_get_contents("php://input"));
  if ($data->Name != null && $data->Id != null) {
    if(!isset($data->Image)) {
      editCafeteria($conn,$data->Name,$data->Id);
    }
    else {
      editCafeteria($conn,$data->Name,$data->Id,$data->Image);
    }
  }
  else {
    echo "name is required";
  }
}

if ($_SERVER['REQUEST_METHOD']=="DELETE") {
  $cafeteriaIdToDelete = $_GET["cafeteriaId"];
  if ($cafeteriaIdToDelete != null) {
    deleteCafeteria($conn,$cafeteriaIdToDelete);
  }
  else {
    echo "No Id is provided";
  }
}

 ?>
