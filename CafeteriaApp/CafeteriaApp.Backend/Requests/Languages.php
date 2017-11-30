<?php
require_once('CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/session.php');
require_once('CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/Controllers/Languages.php');
require_once('CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/connection.php');
require_once ('TestRequestInput.php');

if ($_SERVER['REQUEST_METHOD']=="GET")
{  
  checkResult(getLanguages($conn));
}


if ($_SERVER['REQUEST_METHOD']=="DELETE")
{
  if (isset($_GET["Id"])&& test_int($_GET["Id"]))
  {
    deleteLanguage($conn,$_GET["Id"]);
  }
  else
  {
    echo "Error occured while deleting Favorite Item ";
  }
}


if ($_SERVER['REQUEST_METHOD']=="POST")
{
  //decode the json data
  $data = json_decode(file_get_contents("php://input"));
  if (isset($data->langId)&& test_int($data->langId))
  {
    $_SESSION["langId"]=$data->langId;
  }
  else
  {
    echo "language Id is required";
  }
}

if ($_SERVER['REQUEST_METHOD']=="PUT")
{
  $data = json_decode(file_get_contents("php://input"));
  if (isset($data->Id) && test_int($data->Id) &&isset($data->Name) && normalize_string($conn,$data->Name))
  {
    editLanguage($conn,$data->Name,$data->Id);
  }
  else
  {
    echo "name is required";
  }
}

require('CafeteriaApp/CafeteriaApp/CafeteriaApp.Backend/footer.php');

?>